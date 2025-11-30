#!/bin/bash

# Read current AeroSpace workspace
ws=$(aerospace list-workspaces --focused 2>/dev/null)

# Safety fallback
if [ -z "$ws" ]; then
  ws="?"
fi

sketchybar --set $NAME label="WS $ws"

