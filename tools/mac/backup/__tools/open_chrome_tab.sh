#!/bin/bash
osascript <<'APPLESCRIPT'
tell application "Google Chrome"
    if it is not running then
        launch
        return
    end if

    set winCount to count of windows
    if winCount is 0 then
        activate
        return
    end if

    set frontWinIndex to 0
    repeat with i from 1 to winCount
        if front window is window i then
            set frontWinIndex to i
            exit repeat
        end if
    end repeat

    if frontWinIndex < winCount then
        set nextIndex to frontWinIndex + 1
    else
        set nextIndex to 1
    end if

    set index of window nextIndex to 1
    activate
end tell
APPLESCRIPT

