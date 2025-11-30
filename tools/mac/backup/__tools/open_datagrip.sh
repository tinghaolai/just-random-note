#!/bin/bash
osascript <<'APPLESCRIPT'
if application "DataGrip" is running then
  tell application "DataGrip" to activate
else
  tell application "DataGrip" to launch
end if
APPLESCRIPT

