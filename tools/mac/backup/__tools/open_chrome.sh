#!/bin/bash
osascript <<'APPLESCRIPT'
tell application "Google Chrome"
    if not running then
        launch
    end if
    activate
    try
        reopen
    end try
end tell
APPLESCRIPT


