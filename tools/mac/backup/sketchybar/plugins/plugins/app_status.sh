#!/bin/bash
# ~/.config/sketchybar/plugins/app_status.sh
# Slack 專用最終版：正確區分 紅點(•)、數字、無通知("")，並附 debug 輸出

APP_NAME="$1"
ITEM="$2"

# 讀取 Dock badge 狀態
RAW_INFO=$(lsappinfo info -only StatusLabel "Slack" 2>/dev/null)
BADGE=$(echo "$RAW_INFO" | grep -oE '"label"="[^"]*"' | cut -d'"' -f4)

# Debug 輸出
echo "[$(date '+%H:%M:%S')] lsappinfo 回傳內容："
echo "$RAW_INFO"
echo "解析出的 BADGE 值：${BADGE:-<EMPTY>}"
echo "----------------------"

# 狀態判斷邏輯
if [[ -z "$BADGE" ]]; then
  # 空字串 = 無通知
  echo "⚪️ Case: 無通知（label 空字串）"
  sketchybar --set "$ITEM" label="0" label.color=0xff808080 icon.color=0xff808080

elif [[ "$BADGE" == "•" ]]; then
  # 有紅點
  echo "🟠 Case: 紅點（label = •）"
  sketchybar --set "$ITEM" label="•" label.color=0xffff5555 icon.color=0xffff5555

else
  # 有數字徽章
  echo "🔴 Case: 數字通知（label = $BADGE）"
  sketchybar --set "$ITEM" label="$BADGE" label.color=0xffff5555 icon.color=0xffff5555
fi
