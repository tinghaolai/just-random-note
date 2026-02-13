#!/usr/bin/env bash

OUT_FILE="$HOME/appId.txt"

while true; do
  APP_ID=$(osascript -e 'tell application "System Events" to get bundle identifier of (first application process whose frontmost is true)' 2>/dev/null)

  printf "[%s] %s\n" "$(date '+%Y-%m-%d %H:%M:%S')" "$APP_ID" >> "$OUT_FILE"

  sleep 2
done

