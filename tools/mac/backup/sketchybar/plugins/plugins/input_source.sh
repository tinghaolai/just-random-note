#!/bin/bash

plist=~/Library/Preferences/com.apple.HIToolbox.plist

# 讀取目前 Input Source 列表
info=$(defaults read "$plist" AppleSelectedInputSources 2>/dev/null)

# 第二筆才是目前輸入法
current=$(echo "$info" | sed -n '5,30p')

label="?"

#######################################
# 判斷 ABC（英文）
#######################################
# 三種方式都支援：
# KeyboardLayout Name = ABC;
# "KeyboardLayout Name" = "ABC";
# Bundle ID = com.apple.keylayout.ABC
if echo "$current" | grep -qi 'KeyboardLayout Name = ABC'; then
  label="eng"
elif echo "$current" | grep -qi 'com.apple.keylayout.ABC'; then
  label="eng"
fi

#######################################
# 判斷 注音
#######################################
if echo "$current" | grep -q 'com.apple.inputmethod.TCIM.Zhuyin'; then
  label="TW"
fi

#######################################
# 判斷 拼音
#######################################
if echo "$current" | grep -q 'com.apple.inputmethod.TCIM.Pinyin'; then
  label="pin"
fi

#######################################
# 判斷 RIME
#######################################
if echo "$current" | grep -q 'im.rime.inputmethod.Squirrel'; then
  rime_state=~/Library/Rime/squirrel.yaml
  if [[ -f "$rime_state" ]]; then
    ascii=$(grep 'ascii_mode:' "$rime_state" | awk '{print $2}')
    if [[ "$ascii" == "true" ]]; then
      label="ABC"
    else
      label="ㄅㄆㄇ"
    fi
  else
    label="RIME"
  fi
fi

#######################################
# fallback：如果 label 還是空，就顯示 Input Mode 字串
#######################################
if [[ -z "$label" || "$label" == "?" ]]; then
  fallback=$(echo "$current" | grep 'Input Mode' | sed 's/.*= "\(.*\)";/\1/')
  if [[ -z "$fallback" ]]; then
    fallback=$(echo "$current" | grep 'KeyboardLayout Name' | sed 's/.*= //;s/;//')
  fi
  label="$fallback"
fi

sketchybar --set input_source label="$label"

