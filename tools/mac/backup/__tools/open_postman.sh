#!/bin/bash
osascript <<'APPLESCRIPT'
tell application "Postman"
    if not running then
        launch
    end if
    activate
    try
        reopen
    end try
end tell
APPLESCRIPT


