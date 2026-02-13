#!/bin/bash
osascript <<'APPLESCRIPT'
tell application "Tabby"
    if not running then
        launch
    end if
    activate
    try
        reopen
    end try
end tell
APPLESCRIPT

