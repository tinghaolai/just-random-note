#!/bin/bash
osascript <<'APPLESCRIPT'
if application "Tabby" is running then
  tell application "Tabby" to activate
else
  tell application "Tabby" to launch
end if
APPLESCRIPT

