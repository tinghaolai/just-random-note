#!/bin/bash

# items
# bashrc
# bashrc.d
# stylus
# espanso
# karabiner
# codex
# sketch bar  / plugin
# aerospace
# tabby
# tools script



awk '
# 任何行都可能是 block 開頭
{
    block = $0

    # 若 block 以反斜線結尾 → 持續往下收集
    while (block ~ /\\$/) {
        getline nextline
        block = block "\n" nextline
    }

    # 如果 block 含有 # hide → 進行隱藏替換
    if (block ~ /# hide/) {

        # 從 block 第一行抽出 key 名稱（= 號前 or 第一個 token）
        split(block, lines, "\n")
        firstline = lines[1]

        # 移除前後空白
        sub(/^[[:space:]]+/, "", firstline)
        sub(/[[:space:]]+$/, "", firstline)

        # 如果包含 = → 用 = 前面的字串當名稱
        name = firstline
        if (index(firstline, "=") > 0) {
            sub(/=.*/, "", name)
        } else {
            # 沒有 =，例如 command → 用第一個 token
            split(firstline, parts, /[[:space:]]+/)
            name = parts[1]
        }

        print name "=\"hidden content\""
        next
    }

    # 普通行 → 原樣輸出
    print block
}
' ~/.zshrc > ~/git/personal/just-random-note/tools/mac/backup/zshrc/.zshrc

cp  -r ~/.zshrc.d  ~/git/personal/just-random-note/tools/mac/backup/zshrc/.zshrc.d
cp ~/Library/Application\ Support/espanso/match/base.yml ~/git/personal/just-random-note/tools/mac/backup/espanso/base.yml
cp ~/.config/karabiner/karabiner.json ~/git/personal/just-random-note/tools/mac/backup/karabiner/karabiner.json
cp ~/.hammerspoon/init.lua ~/git/personal/just-random-note/tools/mac/backup/hammerspoon/init.lua
cp ~/.codex/AGENTS.md ~/git/personal/just-random-note/tools/mac/backup/codex/AGENTS.md
cp ~/.config/sketchybar/sketchybarrc ~/git/personal/just-random-note/tools/mac/backup/sketchybar/sketchybarrc
cp -r ~/.config/sketchybar/plugins ~/git/personal/just-random-note/tools/mac/backup/sketchybar/plugins
cp ~/.config/aerospace/aerospace.toml ~/git/personal/just-random-note/tools/mac/backup/aerospace/aerospace.toml
cp ~/__tools/*.sh ~/git/personal/just-random-note/tools/mac/backup/__tools/
#cp ~/Library/Application\ Support/tabby/config.yaml ~/git/personal/just-random-note/tools/mac/backup/tabby/config.yaml

# final
echo "手動更新 stylus, 點擊匯出, 之後執行 afterstylusdownload"
echo "tabby 含有敏感資訊，請手動備份"
echo "cp ~/Library/Application\ Support/tabby/config.yaml ~/git/personal/just-random-note/tools/mac/backup/tabby/config.yaml"

echo "vial 含有密碼資料, 手動下載 json 之後請修改"

echo "-------"
echo "最後執行 codex"
echo "如果 tools/mac/backup 裡面的資訊都沒有包含敏感資訊，就幫我 commit tools/mac/backup 裡面的所有內容, commit 內容要有修改內容"