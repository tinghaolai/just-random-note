# strerss tests
alias stressconnectmaster="ssh -N -L 0.0.0.0:8089:0.0.0.0:8089 ubuntu@vp-load-gen-master"
alias stressstartworker="./start_worker.sh && ./start_worker.sh --repeat 1 --count 33 && ./start_worker.sh --repeat 1 --count 33 && ./start_worker.sh --repeat 1 --count 33 && ./start_worker.sh --repeat 1 --count 33 && ./start_worker.sh --repeat 1 --count 33 && ./start_worker.sh --repeat 1 --count 33"
alias clocust="open -a 'Google Chrome' http://localhost:8089"
alias cstressecs="hidden content"
alias cstressredis="hidden content"
alias cstressrecord="hidden content"
alias cstressvcpu="hidden content"


# chrome
alias ccalendar='open -a "Google Chrome" https://calendar.google.com/calendar/u/0/r'
alias ckeep='open -a "Google Chrome" https://keep.google.com/u/0/'
alias ctodo='open -a "Google Chrome" https://keep.google.com/u/0/#NOTE/1JhmkSsB8pOtj6OueY7j1-0mz1-K-t75yNXn0GK3GIHGo6abko149T3lj-pLyGQ'
alias ctodos='open -a "Google Chrome" https://keep.google.com/u/0/#NOTE/1TWLjuYDmBPI1o_KbN66NUbPhDOtPfUYnfJldAd_tVcxehOwE5V4Q7nPf6MSBmA'
alias croadmap="hidden content"
alias cpm="hidden content"
alias caws="hidden content"
alias clab="hidden content"
alias clabapi="hidden content"
alias clabpayment="hidden content"
alias clabsocket="hidden content"
alias clablogin="hidden content"
alias clabplayback="hidden content"
alias clablog="hidden content"
alias clabcd="hidden content"
alias chr="hidden content"
alias cprod="hidden content"
alias cstg="hidden content"
alias cdev="hidden content"
alias cqa="hidden content"
alias cai='open -a "Google Chrome" https://chatgpt.com/'
alias cchat='bash ~/__tools/open_chatgpt_web.sh'


#aws
# aws sso login --profile  PowerUserAccess-XXXXX
# aws ssm start-session --target i-xxxxx
# aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '{\"portNumber\":[\"3306\"],\"localPortNumber\":[\"1056\"],\"host\":[\"xxx\"]}'
# alias awslogin="hidden content"
alias awslogin="hidden content"
alias awsstgjump="hidden content"
alias awsstgdbcontent="hidden content"
alias awsstgdbpayment="hidden content"
alias awsstgdb="hidden content"
alias awsprodjump="hidden content"
alias awsproddb="hidden content"
alias awsproddbcontent="hidden content"
alias awsproddbpayment="hidden content"
alias awsstges="hidden content"
alias awsdevjump="hidden content"
alias awsdevdb="hidden content"
alias awsdevcache="hidden content"

alias awsdevcacheproxy="hidden content"


alias awsqajump="hidden content"
alias awsqadb="hidden content"

awstarget() {
  local target="$1"
  shift
  aws ssm start-session --target "$target" "$@"
}



#setting or helper
alias cpbranch='branch=$(git rev-parse --abbrev-ref HEAD | tr -d "\n"); echo "📋 Copied branch: $branch"; echo -n "$branch" | pbcopy'
alias composerlocallib="bash ~/__tools/auto_sync_local_lib.sh"
alias gptssl="launchctl kickstart -k system/com.davelai.bypassopenai"
alias gptlog="cat /var/log/bypass_openai.log"
alias aaa="cat ~/.zshrc"
alias nosleep="caffeinate -d"
alias hhh="head ~/.zshrc"
alias vimrc="vim ~/.zshrc"
alias sourcerc="source ~/.zshrc"
alias sail='./vendor/bin/sail'
alias dc="docker-compose"
alias dcrestart="docker-compose down && docker-compose up -d"
alias dockerstart="colima start"
alias ll="ls -al"
alias gitadd="git add . && git reset todo.md note.md auth.json __temp app/Console/Commands/__temp docker-compose.yml docker"
alias gitstatus="git -c color.status=always status | grep --color=always  -v -e 'note\.md' -e 'todo\.md' -e 'auth.json' -e '__temp' -e 'docker'"
alias help="echo -e 'common command:\n  -typioca\n  -sudo -pkill coreaudiod \n \n custom commands: \n -scg <keyword> \n -ide <project_name> \n -src  <keyword>'"
alias chat='echo "sgpt --repl $(date +%s)"; sgpt --repl $(date +%s)'
alias pansoreload="espanso service restart"


phpstorm-open-projects() {
    # 找出最新版本的 PhpStorm 資料夾
    local config_dir
    config_dir=$(ls -d ~/Library/Application\ Support/JetBrains/PhpStorm* | sort -V | tail -n 1)

    local file="$config_dir/options/recentProjects.xml"

    if [ ! -f "$file" ]; then
        echo "❌ 找不到 recentProjects.xml"
        return 1
    fi

    echo "🔍 PhpStorm 正在開啟的 Projects："
    grep 'opened="true"' "$file" \
      | sed -E 's/.*path="([^"]+)".*/\1/' \
      | sed 's/$/\//' \
      | sort -u
}


typeset -A IDE_PROJECTS=(
  [rc]="$HOME/.zshrc"
  [api]="$HOME/git/api-videopass"
  [tool]="$HOME/git/tools-videopass"
  [login]="$HOME/git/api-videopass-login"
  [socket]="$HOME/git/api-videopass-sockets"
  [playback]="$HOME/git/api-videopass-playback"
  [payment]="$HOME/git/api-payment"
  [goback]="$HOME/git/api-playback"
  [worker]="$HOME/git/worker-videopass"
  [log]="$HOME/git/api-videopass-log"
  [cd]="$HOME/git/cd-ecs"
)


# ide
alias iderc='open -a "PhpStorm" ~/.zshrc'
alias ideapi='open -na "PhpStorm.app" --args ~/git/api-videopass'
alias idetool='open -na "PhpStorm.app" --args ~/git/tools-videopass'
alias idelogin='open -na "PhpStorm.app" --args ~/git/api-videopass-login'
alias idesocket='open -na "PhpStorm.app" --args ~/git/api-videopass-sockets'
alias ideplayback='open -na "PhpStorm.app" --args ~/git/api-videopass-playback'
alias idepayment='open -na "PhpStorm.app" --args ~/git/api-payment'
alias idegoback='open -na "PhpStorm.app" --args ~/git/api-playback'
alias ideworker='open -na "PhpStorm.app" --args ~/git/worker-videopass'
alias idelog='open -na "PhpStorm.app" --args ~/git/api-videopass-log'
alias idecd='open -na "PhpStorm.app" --args ~/git/cd-ecs'
alias ideaero='open -na "PhpStorm.app" --args ~/.config/aerospace/aerospace.toml'


# alias ideapi='idep api'
# alias idetool='idep tool'
# alias idelogin='idep login'
# alias idesocket='idep socket'
# alias ideplayback='idep playback'
# alias idepayment='idep payment'
# alias idegoback='idep goback'
# alias ideworker='idep worker'
# alias idelog='idep log'
# alias idecd='idep cd'
# alias iderc='idep rc'


#cd
alias cdgit="cd ~/git"
alias cdgits="cd ~/git_for_search"
alias cdapi="cd ~/git/api-videopass"
alias cdtool="cd ~/git/tools-videopass"
alias cdlogin="cd ~/git/api-videopass-login"
alias cdlog="cd ~/git/api-videopass-log"
alias cdsocket="cd ~/git/api-videopass-sockets"
alias cdplayback="cd ~/git/api-videopass-playback"
alias cdpayment="cd ~/git/api-payment"
alias cdgoback="cd ~/git/api-playback"
alias cdworker="cd ~/git/worker-videopass"
alias cdcd="cd ~/git/cd-ecs"
alias cdsvc="cd ~/git/docker-services"


#helper
alias cpmain="cp ~/git/api-videopass/docker-compose.yml ./docker-compose_from_main.yml && cp ~/git/api-videopass/Dockerfile ./Dockerfile_from_main"
alias jiracheck="php ~/git/davelai/jira-checking/main.php"
alias apic="docker exec api-videopass-api-vp-1 php artisan "
alias apits="docker exec api-videopass-api-vp-1 php artisan ts"
alias apibash="docker exec -it api-videopass-api-vp-1 bash"
alias redisbash="docker exec -it api-videopass-redis-1 bash"
alias gobackbash="docker exec -it api-playback-api-playback-1 bash"
alias workerbash="docker exec -it worker-videopass-worker-1 bash"
alias paymentbash="docker exec -it api-payment-api-1 bash"
alias wokermetatest='docker exec -it worker-videopass-worker-1 sh -c "cp -R _saved/metadataIngestionFile tests/ && cd tests && ../vendor/bin/phpunit ./MetadataImportTest"'
alias wokercatatest='docker exec -it worker-videopass-worker-1 sh -c "cd tests && ../vendor/bin/phpunit ./GenerateCatalogDBTest"'
alias workerdocker='cd ~/git/worker-videopass && cp docker-compose_0915saved.yml docker-compose.yml && cp Dockerfile_0915saveed Dockerfile && cp fluentd/Dockerfile_0915saved fluentd/Dockerfile'
alias wgb='docker exec -it go-consumer-go-consumer-1 bash'
alias wgpb='docker exec -it go-consumer-php-worker-api-1 bash'
alias idepanso='ide ~/Library/Application\ Support/espanso/match/base.yml'
alias switchhome="bash ~/__tools/switch_home.sh"
alias switchself="bash ~/__tools/switch_self.sh"
alias switchoffice="bash ~/__tools/switch_office.sh"
alias barreload="sketchybar --reload"
alias idebar="ide ~/.config/sketchybar/sketchybarrc"
alias hammeroff='osascript -e "tell application \"Hammerspoon\" to quit"'
alias hammeron='open -a Hammerspoon'
alias aeroreload='aerospace reload-config'


# replace vendor file
alias vendorauth="cp ~/__for_copy/Auth_auto_login.php vendor/videopass/laravel-authentication/src/Facades/Auth.php"
alias vendores="cp ~/__for_copy/ElasticsearchServiceProvider.php vendor/kkbox/laravel-videopass/src/providers/Elasticsearch/ElasticsearchServiceProvider.php"
alias vendormember="ide vendor/kkbox/lib-videopass-model/src/DataModel/Member.php"
alias vendormemberdb="ide  vendor/kkbox/lib-videopass-orm-model/src/Model/Member.php"
alias vendormemberredis="ide  vendor/kkbox/lib-videopass-model/src/Model/Redis/Member.php"



# 搜尋檔案內容, e.g. `scg keyword`
# 第二個參數是可選的副檔名 (如 php、go), e.g. `scg keyword php`
scg() {
  # 第一個參數是關鍵字，第二個是可選的副檔名 (如 php、go)
  local keyword="$1"
  local ext="$2"
  local include_opt=""

  # 如果有第二個參數，限制搜尋特定副檔名
  if [ -n "$ext" ]; then
    include_opt="--include=*.${ext}"
  fi

  grep -R -i --binary-files=without-match \
    $include_opt \
    --exclude-dir=vendor \
    --exclude='bundle.js.map' \
    --exclude='*.jpg' --exclude='*.png' --exclude='*.gif' \
    --exclude='*.zip' --exclude='*.gz' --exclude='*.pdf' \
    --exclude='laravel.log' \
    --exclude='swagger-ui.js' \
    "$keyword" . | awk '{
      if (length($0) > 300)
        print substr($0, 1, 300) "...";
      else
        print
    }'
}

catp() {
    cat "$@" | tee /dev/tty | pbcopy
}

# 同 scg, 但不排除 vendor 資料夾
scgv() {
  # 第一個參數是關鍵字，第二個是可選的副檔名 (如 php、go)
  local keyword="$1"
  local ext="$2"
  local include_opt=""

  # 如果有第二個參數，限制搜尋特定副檔名
  if [ -n "$ext" ]; then
    include_opt="--include=*.${ext}"
  fi

  grep -R -i --binary-files=without-match \
    $include_opt \
    --exclude='bundle.js.map' \
    --exclude='*.jpg' --exclude='*.png' --exclude='*.gif' \
    --exclude='*.zip' --exclude='*.gz' --exclude='*.pdf' \
    --exclude='laravel.log' \
    --exclude='swagger-ui.js' \
    "$keyword" . | awk '{
      if (length($0) > 300)
        print substr($0, 1, 300) "...";
      else
        print
    }'
}

awsenv() {
START_URL="hidden content"
ACCOUNT_ID="hidden content"
ROLE_NAME="hidden content"
REGION="hidden content"
  local ENV_FILE="$HOME/__files/secret/aws_env.sh"

  # Step 1：找最新 Token File
  NEWEST_TIME=0
  TOKEN_FILE=""

  for f in ~/.aws/sso/cache/*.json; do
    [[ -e "$f" ]] || continue
    if [[ "$(jq -r '.startUrl // empty' "$f")" != "$START_URL" ]]; then
      continue
    fi
    local t=$(stat -f %m "$f")
    if (( t > NEWEST_TIME )); then
      NEWEST_TIME=$t
      TOKEN_FILE="$f"
    fi
  done

  if [[ -z "$TOKEN_FILE" ]]; then
    echo "❌ 找不到 token，請先登入"
    awslogin
    return 1
  fi

  # 抓 accessToken
  ACCESS_TOKEN=$(jq -r '.accessToken // empty' "$TOKEN_FILE")
#   ACCESS_TOKEN=$(jq -r '.ooo // empty' "$TOKEN_FILE")

echo "access token: $ACCESS_TOKEN"
  # Step 2：取得 STS，失敗時自動 retry
  TRY_COUNT=0
  MAX_TRIES=2

  while true; do
    read AWS_ACCESS_KEY_ID AWS_SECRET_ACCESS_KEY AWS_SESSION_TOKEN AWS_ACCESS_KEY_EXPIRATION < <(
      aws sso get-role-credentials \
        --account-id "$ACCOUNT_ID" \
        --role-name "$ROLE_NAME" \
        --access-token "$ACCESS_TOKEN" \
        --region "$REGION" \
        --query 'roleCredentials.[accessKeyId,secretAccessKey,sessionToken,expiration]' \
        --output text 2>/tmp/aws_role_cred_error.log
    )

    # 成功
    if [[ $? -eq 0 && -n "$AWS_ACCESS_KEY_ID" && "$AWS_ACCESS_KEY_ID" != "None" ]]; then
      break
    fi

    # 超過最大重試次數
    if (( TRY_COUNT >= MAX_TRIES )); then
      echo "❌ STS 重試 $TRY_COUNT 次仍失敗"
      echo "🔍 AWS 錯誤：" && cat /tmp/aws_role_cred_error.log
      return 1
    fi

    echo "⚠️ STS 取得失敗 → 執行 awslogin 再試一次..."
    awslogin

    # login 完重新抓最新 token file
    NEWEST_TIME=0
    TOKEN_FILE=""
    for f in ~/.aws/sso/cache/*.json; do
      [[ -e "$f" ]] || continue
      local url=$(jq -r '.startUrl // empty' "$f")
      [[ "$url" == "$START_URL" ]] || continue
      local t=$(stat -f %m "$f")
      if (( t > NEWEST_TIME )); then
        NEWEST_TIME=$t
        TOKEN_FILE="$f"
      fi
    done

    ACCESS_TOKEN=$(jq -r '.accessToken' "$TOKEN_FILE")
    (( TRY_COUNT++ ))
  done

  # Step 3：輸出到 env file
  cat > "$ENV_FILE" <<EOF
export AWS_ACCESS_KEY_ID="$AWS_ACCESS_KEY_ID"
export AWS_SECRET_ACCESS_KEY="$AWS_SECRET_ACCESS_KEY"
export AWS_SESSION_TOKEN="$AWS_SESSION_TOKEN"
export AWS_ACCESS_KEY_EXPIRATION="$AWS_ACCESS_KEY_EXPIRATION"
EOF

  echo "📦 Exported to $ENV_FILE"
  echo "🎉 AWS credentials refreshed"
}



ide() {
  if [ -z "$1" ]; then
    echo "❌ 請輸入要開啟的檔案，例如： ide ~/.zshrc"
    return 1
  fi

  # 支援相對或絕對路徑
  local target="$1"

  # 如果只給檔名，預設從目前目錄找
  if [ ! -e "$target" ]; then
    target="./$target"
  fi

  # 開啟 PhpStorm
  open -a "PhpStorm" "$target"
}

src() {
  if [ -z "$1" ]; then
    echo "❌ 用法: src <關鍵字>"
    return 1
  fi
  grep -in --color=always "$1" ~/.zshrc
}

idedownload() {
  target=$(ls -t ~/Downloads | head -n 1)
  if [ -z "$target" ]; then
    echo "❌ 找不到 ~/Downloads 裡的檔案"
    return 1
  fi

  fullpath="$HOME/Downloads/$target"
  echo "📂 正在開啟: $fullpath"
  open -a "PhpStorm" "$fullpath"
}


function awstaskbash() {
    local cluster="$1"
    local container="$2"
    local task="$3"

    if [ -z "$cluster" ] || [ -z "$container" ] || [ -z "$task" ]; then
        echo "Usage: awstaskbash <cluster> <container> <task-id>"
        return 1
    fi

    aws ecs execute-command \
        --cluster "$cluster" \
        --task "$task" \
        --container "$container" \
        --interactive \
        --command "/bin/sh"
}


function awstasklog() {
    local cluster="$1"
    local container="$2"
    local task="$3"

    if [ -z "$cluster" ] || [ -z "$container" ] || [ -z "$task" ]; then
        echo "Usage: awstasklog <cluster> <container> <task-id>"
        return 1
    fi

    # 動態本地檔案名稱
    local logfile="ecs-${cluster}-${container}-${task}.log"

    # 動態遠端 log 路徑
    local remote_path="/kkcorp/${container}/storage/logs/laravel.log"

    echo "[INFO] Fetching laravel.log from ECS task..."
    echo "[INFO] Remote path: $remote_path"
    echo "[INFO] Output file: $logfile"
    echo "-----------------------------------------------"

    aws ecs execute-command \
        --cluster "$cluster" \
        --task "$task" \
        --container "$container" \
        --interactive \
        --command "cat ${remote_path}" \
        | tee "$logfile"

    echo "-----------------------------------------------"
    echo "[DONE] Saved to: $logfile"
}


# Bash/Zsh - Harmony SASE helper
# 把下面三個變數改成你的設定
HARMONY_APP_NAME="Harmony SASE"                 # 用於 open -a
HARMONY_PROCESS_PATTERN="Harmony"               # 用於 pgrep -f，改成可識別的 process 名稱
HARMONY_CLI="/usr/local/bin/harmony-cli"        # 若有 CLI 工具，填完整路徑

# 開啟 App
hsase_open() {
  if command -v open >/dev/null 2>&1; then
    echo "開啟: $HARMONY_APP_NAME"
    open -a "$HARMONY_APP_NAME" >/dev/null 2>&1 || echo "open 失敗，確認 App 名稱是否正確"
  else
    echo "此系統不支援 open"
    return 1
  fi
}

# 關閉 App（先用 AppleScript，再用 pkill 作為 fallback）
hsase_close() {
  echo "嘗試關閉: $HARMONY_APP_NAME"
  osascript -e "tell application \"$HARMONY_APP_NAME\" to quit" >/dev/null 2>&1
  sleep 0.3
  if pgrep -f "$HARMONY_PROCESS_PATTERN" >/dev/null 2>&1; then
    echo "仍在執行，使用 pkill 終止 process"
    pkill -f "$HARMONY_PROCESS_PATTERN" || echo "pkill 失敗"
  else
    echo "已關閉"
  fi
}

# 顯示現在的網路狀態（process, default interface, local IP, gateway, public IP, macOS VPN 列表）
hsase_status() {
  echo "=== Harmony SASE 狀態 ==="

  # process
  if pgrep -f "$HARMONY_PROCESS_PATTERN" >/dev/null 2>&1; then
    echo "App process: running (PID: $(pgrep -f "$HARMONY_PROCESS_PATTERN" | head -n1))"
  else
    echo "App process: not running"
  fi

  # default route / interface / local IP / gateway
  iface=$(route get default 2>/dev/null | awk '/interface:/{print $2}')
  gw=$(route get default 2>/dev/null | awk '/gateway:/{print $2}')
  if [ -n "$iface" ]; then
    local_ip=$(ipconfig getifaddr "$iface" 2>/dev/null || echo "N/A")
    echo "Default interface: $iface"
    echo "Local IP on $iface: $local_ip"
    echo "Gateway: ${gw:-N/A}"
  else
    echo "找不到 default interface"
  fi

  # public IP (可用網路決定是否成功)
  if command -v curl >/dev/null 2>&1; then
    pubip=$(curl -s --max-time 5 https://ifconfig.co || echo "N/A")
    echo "Public IP: $pubip"
  else
    echo "curl 不可用，無法取得 public IP"
  fi

  # macOS VPN 列表（若存在 scutil --nc）
  if scutil --nc list >/dev/null 2>&1; then
    echo "macOS VPN services:"
    scutil --nc list | sed 's/^/  /'
  else
    echo "scutil --nc 不可用或無 VPN 服務資訊"
  fi

  echo "========================="
}

alias vpnon='hsase_open'
alias vpnoff='hsase_close'
alias vpnstatus='hsase_status'


#default
export ZSH="$HOME/.oh-my-zsh"

ZSH_THEME="robbyrussell"

plugins=(git)

source $ZSH/oh-my-zsh.sh



[[ -s "$HOME/.gvm/scripts/gvm" ]] && source "$HOME/.gvm/scripts/gvm"

[[ -s "/Users/davelai/.gvm/scripts/gvm" ]] && source "/Users/davelai/.gvm/scripts/gvm"


autoload -Uz compinit
compinit
zstyle ':completion:*' completer _complete
zstyle ':completion:*' list-colors ''
zstyle ':completion:*' menu select
setopt AUTO_LIST          # 打一部分按 Tab 時自動列出所有可能
setopt AUTO_MENU          # 第二次按 Tab 會自動循環選擇

afterstylusdownload() {
  # 取得 Downloads 最新檔案
  target=$(ls -t ~/Downloads | head -n 1)
  if [ -z "$target" ]; then
    echo "❌ 找不到 ~/Downloads 裡的檔案"
    return 1
  fi

  src="$HOME/Downloads/$target"
  dst="$HOME/git/personal/just-random-note/tools/mac/backup/stylus/setting.json"

  # 建立目錄（若不存在）
  mkdir -p "$(dirname "$dst")"

  echo "📂 移動檔案："
  echo "   $src"
  echo "➡️  $dst"

  mv "$src" "$dst"

  echo "✅ 已完成"
}

checkawsexpireandrefresh() {
  local ENV_FILE="$HOME/__files/secret/aws_env.sh"

  #
  # Step 1：環境變數未載入 → 自動載入
  #
  if [[ -z "$AWS_ACCESS_KEY_EXPIRATION" ]]; then
    echo "⚠️  尚未載入 AWS_ACCESS_KEY_EXPIRATION，正在載入 $ENV_FILE..."

    if [[ -f "$ENV_FILE" ]]; then
      source "$ENV_FILE"
      echo "🔄 已載入 aws_env.sh"
    else
      echo "❌ 找不到 $ENV_FILE，無法載入 AWS credentials"
      return 1
    fi

    # 載入後如果還是沒有 expiration → 直接報錯
    if [[ -z "$AWS_ACCESS_KEY_EXPIRATION" ]]; then
      echo "❌ aws_env.sh 沒有帶 expiration，請重新 awsenv"
      return 1
    fi
  fi

  #
  # Step 2：檢查是否過期
  #
  local exp_s=$((AWS_ACCESS_KEY_EXPIRATION / 1000))
  local now_s=$(date +%s)
  local diff=$((exp_s - now_s))

  if (( diff <= 0 )); then
    echo "⛔️ AWS STS credentials 已過期！"
    echo "🔄 正在自動刷新 awsenv…"

    # 嘗試刷新
    if ! awsenv; then
      echo "❌ 刷新失敗，請手動 aws sso login"
      return 1
    fi

    # 刷新成功後重新載入 env file
    source "$ENV_FILE"

    # 若仍無 expiration → 報錯
    if [[ -z "$AWS_ACCESS_KEY_EXPIRATION" ]]; then
      echo "❌ 刷新後仍無 AWS_ACCESS_KEY_EXPIRATION"
      return 1
    fi

    # 更新時間重新計算
    exp_s=$((AWS_ACCESS_KEY_EXPIRATION / 1000))
    now_s=$(date +%s)
    diff=$((exp_s - now_s))
  fi


  #
  # Step 3：顯示剩餘時間
  #
  local minutes=$((diff / 60))
  local hours=$((minutes / 60))

  echo "⏳ AWS credentials 有效，剩餘 ${hours} 小時（約 ${minutes} 分鐘）"
  echo "📅 過期時間：$(date -r $exp_s '+%Y-%m-%d %H:%M:%S')"
}


preexec() {
#   echo "Debug: preexec called with raw='$raw', expanded='$expanded'"
  local raw="$1"

  if [[ "$raw" == aws* ]] \
     && [[ "$raw" != aws\ sso* ]] \
     && [[ "$raw" != awsenv* ]] \
     && [[ "$raw" != awslogin* ]]; then

    checkawsexpireandrefresh
  fi
}



# 只在互動 shell 才載入
[[ -o interactive ]] || return

# 基本需求
setopt prompt_subst
autoload -Uz colors add-zsh-hook
colors

# 自動載入模組（依檔名排序）
for cfg in ~/.zshrc.d/*.zsh(.N); do
  source "$cfg"
done
# Created by `pipx` on 2025-11-23 10:48:37
export PATH="$PATH:/Users/davelai/.local/bin"
export PATH="$HOME/Library/Python/3.9/bin:$PATH"
