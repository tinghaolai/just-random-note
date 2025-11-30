#!/usr/bin/env bash
# ----------------------------------------------------------
# Tabby 隨機更換背景圖片腳本 (macOS 舊版 bash 相容)
# ----------------------------------------------------------

CONFIG="$HOME/Library/Application Support/tabby/config.yaml"
IMG_DIR="$HOME/__tools/wallpaper"

# 收集圖片清單
IMAGES=()
while IFS= read -r -d '' file; do
  IMAGES+=("$file")
done < <(find "$IMG_DIR" -type f \( -iname "*.jpg" -o -iname "*.jpeg" -o -iname "*.png" \) -print0)

# 確認有圖片
if [ ${#IMAGES[@]} -eq 0 ]; then
  echo "❌ 沒找到任何背景圖片在 $IMG_DIR"
  exit 1
fi

# 隨機選一張
RANDOM_INDEX=$((RANDOM % ${#IMAGES[@]}))
RANDOM_IMG=${IMAGES[$RANDOM_INDEX]}
FILE_URL="file://$RANDOM_IMG"

# 檢查設定檔
if [ ! -f "$CONFIG" ]; then
  echo "⚠️ 找不到 Tabby 設定檔：$CONFIG"
  exit 1
fi

# 清除舊 appearance 區塊
sed -i '' '/^appearance:/,/^$/d' "$CONFIG"

# 插入新的背景設定
cat <<EOF >> "$CONFIG"

appearance:
  css: |
    .terminal {
      background: url("$FILE_URL") center/cover no-repeat !important;
      background-color: black !important;
    }
EOF

echo "✅ 已更新 Tabby 背景：$FILE_URL"