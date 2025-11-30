#!/bin/bash
osascript <<'APPLESCRIPT'
if application "Postman" is running then
  tell application "Postman" to activate
else
  tell application "Postman" to launch
end if
APPLESCRIPT
