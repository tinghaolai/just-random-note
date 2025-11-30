#!/bin/bash
# ~/.config/sketchybar/plugins/clock.sh

TIME=$(date "+%H:%M")
sketchybar --set "$NAME" label="$TIME"