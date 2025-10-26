#!/bin/bash
# ~/.config/sketchybar/plugins/frontapp.sh
# 偵測目前前景 App，高亮對應圖示；開啟但非前景顯示黃色；沒開啟保持灰色

FRONT_APP=$(osascript -e 'tell application "System Events" to get name of first application process whose frontmost is true')

echo "[$(date '+%H:%M:%S')] 前景 App 偵測結果：$FRONT_APP"
echo "----------------------------------------"

# 顏色設定
default_color=0xff3b4252       # 深灰藍 (未開啟)
highlight_color=0xff00ffc3     # 電青綠 (前景高亮)
opened_color=0xffff9500        # 霓虹橘 (已開啟但非前景)
highlight_bg=0x3300ffc3        # 青綠光暈
border_color=0xff00e0ff        # 淺藍青邊框
border_width=2
corner_radius=7

# 檢查 app 是否開啟
function is_app_open() {
  local app_name=$1
  pgrep -x "$app_name" >/dev/null 2>&1
  return $?
}

# 高亮（前景）
function highlight() {
  local name=$1
  sketchybar --set "$name" \
    icon.background.drawing=on \
    icon.background.height=30 \
    icon.background.corner_radius=$corner_radius \
    icon.background.border_width=$border_width \
    icon.background.border_color=$highlight_color \
    icon.background.color=$highlight_bg \
    icon.color=$highlight_color
}

# 開啟但非前景
function mark_opened() {
  local name=$1
  sketchybar --set "$name" \
    icon.color=$opened_color \
    icon.background.drawing=off
}

# 關閉狀態
function mark_closed() {
  local name=$1
  sketchybar --set "$name" \
    icon.color=$default_color \
    icon.background.drawing=off
}

# App 對應表
APPS=(
  finder "Finder"
  launchpad "Launchpad"
  system "System Settings"
  chrome "Google Chrome"
  datagrip "datagrip"
  tabby "Tabby"
  chatgpt "ChatGPT"
  postman "Postman"
  phpstorm "phpstorm"
  line "LINE"
  slack "Slack"
  goland "goland"
  vscode "Electron"
  webstorm "webstorm"
  karabiner "Karabiner-Elements"
  pycharm "pycharm"
  bongocat "bongo-cat"
)

# 單輪檢查全部 app 狀態
for ((i=0; i<${#APPS[@]}; i+=2)); do
  name="${APPS[i]}"
  app="${APPS[i+1]}"

  if [[ "$FRONT_APP" == "$app" ]]; then
    echo "🔹 前景 App：$app"
    highlight "$name"
  elif is_app_open "$app"; then
    echo "🟡 已開啟 App：$app"
    mark_opened "$name"
  else
    mark_closed "$name"
  fi
done
