#!/bin/bash
osascript <<'APPLESCRIPT'
if application "PhpStorm" is running then
  tell application "PhpStorm" to activate
else
  tell application "PhpStorm" to launch
end if
APPLESCRIPT

