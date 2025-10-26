# chrome
alias ccalendar='open -a "Google Chrome" https://calendar.google.com/calendar/u/0/r'
alias ckeep='open -a "Google Chrome" https://keep.google.com/u/0/'
alias ctodo='open -a "Google Chrome" https://keep.google.com/u/0/#NOTE/1JhmkSsB8pOtj6OueY7j1-0mz1-K-t75yNXn0GK3GIHGo6abko149T3lj-pLyGQ'
alias ctodos='open -a "Google Chrome" https://keep.google.com/u/0/#NOTE/1TWLjuYDmBPI1o_KbN66NUbPhDOtPfUYnfJldAd_tVcxehOwE5V4Q7nPf6MSBmA'
alias croadmap='open -a "Google Chrome" https://docs.google.com/spreadsheets/d/18EqgLlMJJPyuenmdJGvplu5xy5RzPhbDdgUQ9MmvY4I/edit'
alias cpm='open -a "Google Chrome" https://docs.google.com/spreadsheets/d/1iEhdbkCvNAFi9wZtqjvnHKs-PPpwigDUaZFWpzkGRS0/edit'
alias caws='open -a "Google Chrome" https://aws-sso-multimedia.kkcompany.com/'
alias clab='open -a "Google Chrome" https://gitlab.kkinternal.com/videopass'
alias clabapi='open -a "Google Chrome" https://gitlab.kkinternal.com/videopass/api-videopass'


#aws
alias awslogin="aws sso login --profile PowerUserAccess-xxxx"
alias awsstgjump="aws ssm start-session --target i-xxxx"
alias awsstgdbcontent="aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '{\"portNumber\":[\"3306\"],\"localPortNumber\":[\"2054\"],\"host\":[\"db-videopass-content-ingestion.videopass\"]}'"
alias awsstgdb="aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '{\"portNumber\":[\"3306\"],\"localPortNumber\":[\"2053\"],\"host\":[\"db-videopass.videopass\"]}'"
alias awsprodjump="aws ssm start-session --target i-xxxx"
alias awsproddb="aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '{\"portNumber\":[\"3306\"],\"localPortNumber\":[\"1054\"],\"host\":[\"db-videopass.videopass\"]}'"
alias awsproddbcontent="aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '{\"portNumber\":[\"3306\"],\"localPortNumber\":[\"1055\"],\"host\":[\"db-videopass-content-ingestion.videopass\"]}'"
alias awsproddbpayment="aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '{\"portNumber\":[\"3306\"],\"localPortNumber\":[\"1056\"],\"host\":[\"db-videopass-payment.videopass\"]}'"
alias awsstges="aws ssm start-session --target i-xxxx"
alias awsdevjump="aws ssm start-session --target i-xxxx"
alias awsdevdb="aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '{\"portNumber\":[\"3306\"],\"localPortNumber\":[\"7054\"],\"host\":[\"db-videopass.videopass\"]}'"
alias awsqajump="aws ssm start-session --target  i-xxxx"
alias awsqadb='aws ssm start-session --target i-xxxx --document-name AWS-StartPortForwardingSessionToRemoteHost --parameters '\''{"portNumber":["3306"],"localPortNumber":["4054"],"host":["db-videopass.videopass"]}'\'''


#setting or helper
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
alias help="echo ''common command: typioca''"

# ide
alias iderc='open -a "PhpStorm" ~/.zshrc'
alias ideapi='open -a "PhpStorm" ~/git/api-videopass'
alias idetool='open -a "PhpStorm" ~/git/tools-videopass'
alias idelogin='open -a "PhpStorm" ~/git/api-videopass-login'
alias idesocket='open -a "PhpStorm" ~/git/api-videopass-sockets'
alias ideplayback='open -a "PhpStorm" ~/git/api-videopass-playback'
alias idepayment='open -a "PhpStorm" ~/git/api-payment'
alias idegoback='open -a "GoLand" ~/git/api-playback'
alias ideworker='open -a "PhpStorm" ~/git/worker-videopass'
alias idelog='open -a "PhpStorm" ~/git/api-videopass-log'


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


#helper
alias cpmain="cp ~/git/api-videopass/docker-compose.yml ./docker-compose_from_main.yml && cp ~/git/api-videopass/Dockerfile ./Dockerfile_from_main"

alias apic="docker exec api-videopass-api-vp-1 php artisan "
alias apits="docker exec api-videopass-api-vp-1 php artisan ts"
alias apibash="docker exec -it api-videopass-api-vp-1 bash"
alias redisbash="docker exec -it api-videopass-redis-1 bash"
alias gobackbash="docker exec -it api-playback-api-playback-1 bash"
alias workerbash="docker exec -it worker-videopass-worker-1 bash"
alias paymentbash="docker exec -it api-payment-api-payment-1 bash"
alias wokermetatest='docker exec -it worker-videopass-worker-1 sh -c "cp -R _saved/metadataIngestionFile tests/ && cd tests && ../vendor/bin/phpunit ./MetadataImportTest"'
alias wokercatatest='docker exec -it worker-videopass-worker-1 sh -c "cd tests && ../vendor/bin/phpunit ./GenerateCatalogDBTest"'
alias workerdocker='cd ~/git/worker-videopass && cp docker-compose_0915saved.yml docker-compose.yml && cp Dockerfile_0915saveed Dockerfile && cp fluentd/Dockerfile_0915saved fluentd/Dockerfile'
alias wgb='docker exec -it go-consumer-go-consumer-1 bash'
alias wgpb='docker exec -it go-consumer-php-worker-api-1 bash'


# replace vendor file
alias vendorauth="cp ~/__for_copy/Auth_auto_login.php vendor/videopass/laravel-authentication/src/Facades/Auth.php"
alias vendores="cp ~/__for_copy/ElasticsearchServiceProvider.php vendor/kkbox/laravel-videopass/src/providers/Elasticsearch/ElasticsearchServiceProvider.php"



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
  START_URL="xxxxxx"
  ACCOUNT_ID="xxxxx"
  ROLE_NAME="PowerUserAccess"
  REGION="ap-northeast-1"

  TOKEN_FILE=""
  NEWEST_TIME=0

  for f in ~/.aws/sso/cache/*.json; do
    # 取得 startUrl
    if [[ "$(jq -r '.startUrl // empty' "$f")" != "$START_URL" ]]; then
      continue
    fi

    # 根據平台取 mtime
    if stat --version >/dev/null 2>&1; then
      FILE_TIME=$(stat -c %Y "$f")       # Linux
    else
      FILE_TIME=$(stat -f %m "$f")       # macOS / BSD
    fi

    # 比較最新時間
    if (( FILE_TIME > NEWEST_TIME )); then
      NEWEST_TIME=$FILE_TIME
      TOKEN_FILE="$f"
    fi
  done

  if [[ -z "$TOKEN_FILE" ]]; then
    echo "❌ 找不到對應的 token 檔案，請先執行："
    echo "   aws sso login --profile PowerUserAccess-xxxxx --no-browser"
    return 1
  fi

  ACCESS_TOKEN=$(jq -r '.accessToken' "$TOKEN_FILE")

  read AWS_ACCESS_KEY_ID AWS_SECRET_ACCESS_KEY AWS_SESSION_TOKEN < <(
    aws sso get-role-credentials \
      --account-id "$ACCOUNT_ID" \
      --role-name "$ROLE_NAME" \
      --access-token "$ACCESS_TOKEN" \
      --region "$REGION" \
      --query 'roleCredentials.[accessKeyId,secretAccessKey,sessionToken]' \
      --output text
  )

  export AWS_ACCESS_KEY_ID AWS_SECRET_ACCESS_KEY AWS_SESSION_TOKEN

  echo "✅ AWS credentials exported from $TOKEN_FILE"
#   echo "AWS_ACCESS_KEY_ID=$AWS_ACCESS_KEY_ID"
#   echo "AWS_SECRET_ACCESS_KEY=$AWS_SECRET_ACCESS_KEY"
#   echo "AWS_SESSION_TOKEN=$AWS_SESSION_TOKEN"
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


#default
export ZSH="$HOME/.oh-my-zsh"

ZSH_THEME="robbyrussell"

plugins=(git)

source $ZSH/oh-my-zsh.sh



[[ -s "$HOME/.gvm/scripts/gvm" ]] && source "$HOME/.gvm/scripts/gvm"

[[ -s "/Users/davelai/.gvm/scripts/gvm" ]] && source "/Users/davelai/.gvm/scripts/gvm"
