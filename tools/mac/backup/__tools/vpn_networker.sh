#!/usr/bin/env bash
# p81-local-networks.sh
# 解析本機 Perimeter81 / Harmony agent 的 wgconf 與介面資訊
# Usage:
#   ./p81-local-networks.sh
#   sudo ./p81-local-networks.sh   # 若 wgconf 在 /var/root 需要 root 權限

set -euo pipefail

# Helpers
err() { echo "⚠️  $*" >&2; }
ok()  { echo "✅  $*"; }

echo "🔎 掃描正在執行的 Perimeter81 / WireGuard 相關 process ..."
# 找出可能的 wgconf 路徑（從 process args 取）
WG_CONF_FILES=()
while IFS= read -r line; do
  echo "777"

  # 從 ps line 取出類似 ... wgconf0.conf 的完整路徑
  fp=$(echo "$line" | grep -oE '(/[^ ]*wgconf[^ ]*\.conf)')
  if [ -n "$fp" ]; then
    echo "777999"

    WG_CONF_FILES+=("$fp")
  fi
  echo "888"
done < <(ps aux | grep -i -E 'perimeter|wg-quick|wgconf' | grep -v grep || true)

echo "123"

# 另外也嘗試幾個常見位置（fallback）
CANDIDATES=(
  "/var/root/Library/Application Support/com.perimeter81d/wgconf0.conf"
  "/var/root/Library/Application Support/com.perimeter81d/wgconf1.conf"
  "$HOME/Library/Application Support/Perimeter 81/wgconf0.conf"
  "$HOME/Library/Application Support/Perimeter 81/wgconf1.conf"
)
for c in "${CANDIDATES[@]}"; do
  if [ -f "$c" ]; then
    WG_CONF_FILES+=("$c")
  fi
done

# Dedup
if [ ${#WG_CONF_FILES[@]} -gt 0 ]; then
  # unique preserve order
  uniq_files=()
  declare -A seen
  for f in "${WG_CONF_FILES[@]}"; do
    if [ -n "$f" ] && [ -z "${seen[$f]:-}" ]; then
      uniq_files+=("$f")
      seen[$f]=1
    fi
  done
  WG_CONF_FILES=("${uniq_files[@]}")
fi

if [ ${#WG_CONF_FILES[@]} -eq 0 ]; then
  err "找不到任何 wgconf 檔案（也就是 agent 沒把 conf 路徑放到 process args），或你需要用 sudo 執行來讀取 /var/root。"
  echo
  echo "你可以手動檢查："
  echo "  ps aux | grep -i perimeter"
  echo "  ls '/var/root/Library/Application Support/com.perimeter81d/'"
  exit 2
fi

ok "找到 ${#WG_CONF_FILES[@]} 個可能的 wgconf 檔案："
for f in "${WG_CONF_FILES[@]}"; do
  echo "  - $f"
done

echo
# 解析每個 conf
for conf in "${WG_CONF_FILES[@]}"; do
  echo "────────────────────────────────────────────────────────"
  echo "📄  檔案: $conf"
  if [ ! -r "$conf" ]; then
    err "沒辦法讀取 $conf — 可能需要 sudo"
    continue
  fi

  echo "🔧  解析 Interface 欄位..."
  # Interface block: Address / DNS / PrivateKey(not shown) / ListenPort
  awk '
    BEGIN { section=""; print "" }
    /^\[Interface\]/ { section="if"; next }
    /^\[Peer\]/ { section="peer"; next }
    section=="if" && match($0, /Address[[:space:]]*=[[:space:]]*(.*)/, a) { print "  Address: " a[1] }
    section=="if" && match($0, /DNS[[:space:]]*=[[:space:]]*(.*)/, a) { print "  DNS: " a[1] }
    section=="if" && match($0, /ListenPort[[:space:]]*=[[:space:]]*(.*)/, a) { print "  ListenPort: " a[1] }
  ' "$conf" || true

  echo "🔗  Peers (Endpoint / AllowedIPs):"
  # For peers, print Endpoint and AllowedIPs
  awk '
    BEGIN { inpeer=0; peeridx=0 }
    /^\[Peer\]/ { inpeer=1; peeridx++; endpoint=""; allowed=""; next }
    inpeer && match($0, /Endpoint[[:space:]]*=[[:space:]]*(.*)/, a) { endpoint=a[1] }
    inpeer && match($0, /AllowedIPs[[:space:]]*=[[:space:]]*(.*)/, a) { allowed=a[1] }
    (NF==0 || /^\\[/) && inpeer { printf "  - Peer %d:\n      Endpoint: %s\n      AllowedIPs: %s\n", peeridx, (endpoint==""?"<none>":endpoint), (allowed==""?"<none>":allowed); inpeer=0 }
    END { if(inpeer) printf "  - Peer %d:\n      Endpoint: %s\n      AllowedIPs: %s\n", peeridx, (endpoint==""?"<none>":endpoint), (allowed==""?"<none>":allowed) }
  ' "$conf" || true

  # try to infer "network name" from filename or comment lines
  name=$(basename "$conf")
  echo "🏷️  推測 network id/name: $name"

  echo
done

echo "────────────────────────────────────────────────────────"
echo "🖧  系統目前的 VPN / WireGuard / utun 介面（ifconfig 篩選）："
ifconfig_output=$(ifconfig 2>/dev/null || true)
if [ -n "$ifconfig_output" ]; then
  # list utun and wg interfaces and their inet addresses
  echo "$ifconfig_output" | awk '
    BEGIN { in_block=0; name=""; addr="" }
    /^[^ \t]/ {
      if (in_block==1) {
        if (addr!="") print "  " name " -> " addr;
        else print "  " name " -> <no ipv4>";
      }
      in_block=1; name=$1; addr=""
    }
    /inet / && in_block==1 {
      # get the inet addr
      for(i=1;i<=NF;i++) if($i=="inet") { addr=$(i+1) }
    }
    END {
      if (in_block==1) {
        if (addr!="") print "  " name " -> " addr;
        else print "  " name " -> <no ipv4>";
      }
    }' | grep -E 'utun|wg|p8|utun|tun' || true
else
  err "ifconfig 無輸出（很罕見）"
fi

echo
echo "🛣️  路由表（含 default route / 可能的 VPN route）:"
netstat -rn | head -n 30 || true

echo
echo "🗂️  建議下一步："
echo "  • 若上面 wgconf 無法讀取，請用 sudo 執行： sudo ./p81-local-networks.sh"
echo "  • 你也可以直接看 agent 日誌（最近 200 行）："
echo "      tail -n 200 \"$HOME/Library/Logs/Perimeter 81\"/* 2>/dev/null || true"
echo "      sudo tail -n 200 /var/root/Library/Application\\ Support/com.perimeter81d/* 2>/dev/null || true"
echo
ok "完成"
