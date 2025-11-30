#!/bin/sh

PERCENTAGE="$(pmset -g batt | grep -Eo "\d+%" | cut -d% -f1)"
CHARGING="$(pmset -g batt | grep 'AC Power')"

if [ "$PERCENTAGE" = "" ]; then
  exit 0
fi

# Nerd Font 電池圖示（SketchyBar 100% 支援）
if [ "$CHARGING" != "" ]; then
  ICON="󰂄"   # Charging icon
else
  case "${PERCENTAGE}" in
    9[0-9]|100) ICON="󰁹" ;;   # full
    [6-8][0-9]) ICON="󰁽" ;;   # 75%
    [3-5][0-9]) ICON="󰁼" ;;   # 50%
    [1-2][0-9]) ICON="󰁻" ;;   # 25%
    *)          ICON="󰁺" ;;   # 0%
  esac
fi

sketchybar --set "$NAME" icon="$ICON" label="${PERCENTAGE}%"
