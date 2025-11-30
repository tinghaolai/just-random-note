#!/bin/bash
osascript <<'APPLESCRIPT'
if application "ChatGPT" is running then
  tell application "ChatGPT" to activate
else
  tell application "ChatGPT" to launch
end if
APPLESCRIPT
