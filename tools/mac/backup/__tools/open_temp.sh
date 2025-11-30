#!/bin/bash
osascript <<'APPLESCRIPT'
if application "GoLand" is running then
  tell application "GoLand" to activate
else
  tell application "GoLand" to launch
end if
APPLESCRIPT

