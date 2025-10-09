There's are several problems if your repository works with lots of other self-hosted repositories.

* Can't see the git blame info in IDE
* Can't detect the changes in IDE (manually modify vendor library file)
* Since index excluded from IDE
  * Can't search the code in vendor library, unless opened once and IDE cached
  * Can't link other class that use this class/function

So we can clone these repositories locally, 
and use path repository in composer.json to make them work locally.

But if we have too many repositories, it could be a pain to set them up.

So, here's a bash script to do these things automatically.

* create soft link
* update composer.json
* update composer lock only the local repository needed
* composer dump-autoload -o

Prepare:

* Download libraries you need to a folder, and modify variables in the script (`GITREPO`)

script:

```bash
#!/usr/bin/env bash
set -e

# -------user 設定區 start-------
GITREPO="$HOME/git"
LOCAL_LIB_FOLDER="local-libs"
COMPOSER_FILE="composer.json"
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

for repo in $KKBOX_REPOS; do
  folder_name=$(basename "$repo")
  repo_path="$GITREPO/$folder_name"
  local_path="$LOCAL_LIB_FOLDER/$folder_name"

  if [ ! -d "$repo_path" ]; then
    echo "❌ 缺少 $repo_path"
    continue
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

  repo_json=$(jq -n \
    --arg path "$LOCAL_LIB_FOLDER/$folder_name" \
    '{type:"path", url:$path, options:{symlink:true}}')
  PATH_REPOS_JSON+=("$repo_json")

  AUTOLOAD_ENTRIES+=("$(jq -n --arg ns "$ns" --arg path "$LOCAL_LIB_FOLDER/$folder_name/src/" \
    '{($ns): [$path]}')")

  REPLACE_ENTRIES+=("$repo:$version")
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
```

