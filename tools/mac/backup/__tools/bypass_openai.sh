#!/bin/bash
# Full OpenAI allowlist route-bypass script
# Run as root (LaunchDaemon). Do NOT use sudo inside.
LOG="/var/log/bypass_openai.log"
ROUTE_BIN="/sbin/route"
DIG_BIN="/usr/bin/dig"

echo "=== $(date) START ===" >> "$LOG"

# wait for default gateway (max 120s)
WAIT=0
GW=""
IFACE=""
while [[ -z "$GW" && $WAIT -lt 120 ]]; do
  GW=$($ROUTE_BIN get default 2>/dev/null | awk '/gateway:/{print $2}' || true)
  IFACE=$($ROUTE_BIN get default 2>/dev/null | awk '/interface:/{print $2}' || true)
  if [[ -z "$GW" ]]; then
    echo "$(date): gateway not found yet, sleeping 1s" >> "$LOG"
    sleep 1
    WAIT=$((WAIT+1))
  fi
done

if [[ -z "$GW" ]]; then
  echo "$(date): no gateway found after wait; exiting" >> "$LOG"
  echo "=== $(date) END (no gateway) ===" >> "$LOG"
  exit 1
fi

echo "$(date): gateway is $GW, interface ${IFACE:-unknown}" >> "$LOG"

# official/extended allowlist + expansions for wildcards
BASE_DOMAINS=(
".openai.com"
"auth0.openai.com"
"*.auth.openai.com"
"setup.auth.openai.com"
"chat.openai.com"
"tcr9i.chat.openai.com"
".chatgpt.com"
"*.oaiusercontent.com"
"*.oaistatic.com"
".statsig.com"
"statsigapi.net"
"events.statsigapi.net"
".featuregates.org"
".intercomcdn.com"
"js.intercomcdn.com"
"*.intercom.io"
"js.stripe.com"
"challenges.cloudflare.com"
"rum.browser-intake-datadoghq.com"
"o33249.ingest.sentry.io"
"ios.chat.openai.com"
"android.chat.openai.com"
"desktop.chat.openai.com"
"prodregistryv2.org"
"featureassets.org"
"setup.workos.com"
"events.launchdarkly.com"
"forwarder.workos.com"
"clientstream.launchdarkly.com"
"app.launchdarkly.com"
"o207216.ingest.sentry.io"
"workos.imgix.net"
"cdn.workos.com"
"images.workoscdn.com"
"*.ct.sendgrid.net"
)

# prefixes to expand wildcard domains (common subdomains)
PREFIXES=( "www." "files." "cdn." "static." "api." "app." "images." "img." "uploads." "assets." "mobile." "desktop." "ios." "android." )

# helper: given an entry, produce a list of concrete hostnames to dig
expand_hosts() {
  entry="$1"
  hosts=()
  if [[ "$entry" == \*.* ]]; then
    # entry like *.example.com -> expand with PREFIXES
    base="${entry#*.}"
    for p in "${PREFIXES[@]}"; do
      hosts+=("${p}${base}")
    done
  elif [[ "$entry" == .* ]]; then
    # entry like .example.com -> try without dot and 'www.' plus prefixes
    base="${entry#.}"
    hosts+=("$base")
    hosts+=("www.${base}")
    for p in "${PREFIXES[@]}"; do
      hosts+=("${p}${base}")
    done
  else
    hosts+=("$entry")
  fi
  # dedupe hosts (preserve order)
  awk -v RS='\n' '!seen[$0]++' <<< "$(printf "%s\n" "${hosts[@]}")"
}

# build final hostlist by expanding each base domain
HOSTS=()
for e in "${BASE_DOMAINS[@]}"; do
  while read -r h; do
    HOSTS+=("$h")
  done < <(expand_hosts "$e")
done

echo "$(date): will resolve ${#HOSTS[@]} hostnames (sample: ${HOSTS[*]:0:6} ...)" >> "$LOG"

# resolve and add routes per IP
for host in "${HOSTS[@]}"; do
  echo "$(date): resolving $host" >> "$LOG"
  IPs=$($DIG_BIN +short "$host" @1.1.1.1 | grep -E '^[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+$' || true)
  if [[ -z "$IPs" ]]; then
    echo "$(date): no A records for $host" >> "$LOG"
    continue
  fi

  # process each resolved IP
  echo "$IPs" | while IFS= read -r ip; do
    ip=$(echo "$ip" | tr -d '\r\n')
    [[ -z "$ip" ]] && continue
    echo "$(date): processing $host -> $ip" >> "$LOG"

    # if route already exists pointing to GW, skip
    if $ROUTE_BIN get "$ip" 2>/dev/null | grep -q "gateway: $GW"; then
      echo "$(date): route for $ip via $GW already exists" >> "$LOG"
      continue
    fi

    # delete any old host-specific route (best-effort), then add
    $ROUTE_BIN -n delete -host "$ip" "$GW" 2>/dev/null || true
    if $ROUTE_BIN -n add -host "$ip" "$GW" >> "$LOG" 2>&1; then
      echo "$(date): added route for $ip via $GW" >> "$LOG"
    else
      echo "$(date): FAILED to add route for $ip via $GW" >> "$LOG"
    fi
  done
done

echo "=== $(date) END ===" >> "$LOG"

