#!/usr/bin/env bash
set -e

# -------user 設定區 start-------
GITREPO="$HOME/git"
LOCAL_LIB_FOLDER="local-libs"
COMPOSER_FILE="composer.json"
CONTAINER_PATH="/kkcorp/worker-videopass" # 容器內路徑
# -------user 設定區 end---------

echo "📦 掃描本地 KKBOX library..."
echo "GIT 來源: $GITREPO"
echo "LOCAL LIB: $LOCAL_LIB_FOLDER"
echo "--------------------------------"

if [ ! -d "$LOCAL_LIB_FOLDER" ]; then
  mkdir -p "$LOCAL_LIB_FOLDER"
fi

KKBOX_REPOS=$(jq -r '.require | keys[] | select(startswith("kkbox/"))' "$COMPOSER_FILE")

echo "✅ KKBOX Repositories:"
echo "$KKBOX_REPOS"
echo "--------------------------------"

PATH_REPOS_JSON=()
AUTOLOAD_ENTRIES=()
REPLACE_ENTRIES=()
VOLUME_LINES=()

for repo in $KKBOX_REPOS; do
  folder_name=$(basename "$repo")
  repo_path="$GITREPO/$folder_name"
  local_path="$LOCAL_LIB_FOLDER/$folder_name"

  if [ ! -d "$repo_path" ]; then
    echo "❌ 缺少 $repo_path"
    exit 1
  fi

  version=$(jq -r --arg repo "$repo" '.require[$repo]' "$COMPOSER_FILE")
  [ -z "$version" ] || [ "$version" == "null" ] && version="*"

  ns=$(jq -r '.autoload["psr-4"] | keys[0]?' "$repo_path/composer.json" 2>/dev/null)
  if [ -z "$ns" ] || [ "$ns" == "null" ]; then
    echo "⚠️  無法從 $folder_name 讀取 namespace，略過 autoload"
    continue
  fi

  echo "📘 $folder_name => namespace: $ns"
  echo "   原始版本：$version"

  # --- 建立 symlink ---
  if [ -L "$local_path" ] || [ -d "$local_path" ]; then
    echo "🔁 已存在 $local_path，刪除舊的連結或資料夾"
    rm -rf "$local_path"
  fi

  echo "🔗 建立軟連結: $local_path → $repo_path"
  ln -s "$repo_path" "$local_path" && echo "✅ 成功建立軟連結" || {
    echo "❌ 建立軟連結失敗: $local_path"
    exit 1
  }

  # --- 組合 JSON ---
  repo_json=$(jq -n \
    --arg path "$LOCAL_LIB_FOLDER/$folder_name" \
    '{type:"path", url:$path, options:{symlink:true}}')
  PATH_REPOS_JSON+=("$repo_json")

  AUTOLOAD_ENTRIES+=("$(jq -n --arg ns "$ns" --arg path "$LOCAL_LIB_FOLDER/$folder_name/src/" \
    '{($ns): [$path]}')")

  REPLACE_ENTRIES+=("$repo:$version")

  # --- Docker volume line (保持 ~ 不展開) ---
  VOLUME_LINES+=("- ~/git/${folder_name}:${CONTAINER_PATH}/${LOCAL_LIB_FOLDER}/${folder_name}")
done

REPOS_JSON=$(printf '%s\n' "${PATH_REPOS_JSON[@]}" | jq -s '.')
AUTOLOAD_JSON=$(printf '%s\n' "${AUTOLOAD_ENTRIES[@]}" | jq -s 'add')
REPLACE_JSON=$(for kv in "${REPLACE_ENTRIES[@]}"; do
  key="${kv%%:*}"
  val="${kv#*:}"
  jq -n --arg k "$key" --arg v "$val" '{($k): $v}'
done | jq -s 'add')


echo "--------------------------------"
echo "🧩 修改 composer.json ..."

cp "$COMPOSER_FILE" "$COMPOSER_FILE.bak"

jq \
  --argjson repos "$REPOS_JSON" \
  --argjson autoload "$AUTOLOAD_JSON" \
  --argjson replace "$REPLACE_JSON" '
  .repositories = ($repos + (.repositories // [])) |
  .autoload."psr-4" = (.autoload."psr-4" + $autoload) |
  .replace = (.replace + $replace)
' "$COMPOSER_FILE.bak" > "$COMPOSER_FILE.tmp" && mv "$COMPOSER_FILE.tmp" "$COMPOSER_FILE"

echo "✅ composer.json 已更新完成（已備份為 composer.json.bak）"
echo "--------------------------------"
jq '.repositories | length' "$COMPOSER_FILE" | xargs echo "📦 Repositories 數量："
jq '.autoload."psr-4" | keys' "$COMPOSER_FILE" | xargs echo "📘 Namespace："

echo "🎯 只更新對應 local 的 repo..."
for kv in "${REPLACE_ENTRIES[@]}"; do
  pkg="${kv%%:*}"
  echo "🔄 composer update $pkg"
  composer update "$pkg" --no-interaction
done

echo "--------------------------------"
echo "🧩 重新產生 autoload ..."
composer dump-autoload -o

echo "🎉 composer.json 更新完成，僅更新本地套件，不影響其他依賴！"

echo "--------------------------------"
echo "🧱 Docker Compose volumes 建議掛載區塊："
echo "--------------------------------"
for line in "${VOLUME_LINES[@]}"; do
  echo "$line"
done
echo "--------------------------------"
echo "✅ 已輸出 docker-compose volume 區段，可直接貼到 docker-compose.yml"
