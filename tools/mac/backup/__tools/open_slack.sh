#!/bin/bash
osascript <<'APPLESCRIPT'
if application "Slack" is running then
  tell application "Slack" to activate
else
  tell application "Slack" to launch
end if
APPLESCRIPT

