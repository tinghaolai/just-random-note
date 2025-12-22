#!/bin/bash

###############################################
#  Cyberpunk Battery + Volume + VPN Indicator
###############################################

COLOR_YELLOW="0xffd7ff00"
COLOR_CYAN="0xff00ffff"
COLOR_RED="0xffff5555"

# -----------------------------------------------
# Battery
# -----------------------------------------------
PERCENTAGE="$(pmset -g batt | grep -Eo "\d+%" | cut -d% -f1)"
CHARGING="$(pmset -g batt | grep 'AC Power')"

if [ -n "$CHARGING" ]; then
  BAT_ICON="󰂄"
else
  case $PERCENTAGE in
    9[0-9]|100) BAT_ICON="󰁹" ;;
    [6-8][0-9]) BAT_ICON="󰁽" ;;
    [3-5][0-9]) BAT_ICON="󰁼" ;;
    [1-2][0-9]) BAT_ICON="󰁻" ;;
    *)          BAT_ICON="󰁺" ;;
  esac
fi

sketchybar --set battery icon="$BAT_ICON" label="${PERCENTAGE}%"


# -----------------------------------------------
# Volume (percentage)
# -----------------------------------------------
VOLUME=$(osascript -e 'output volume of (get volume settings)')
VOL_ICON="󰕾"

sketchybar --set volume \
  icon="$VOL_ICON" \
  label="${VOLUME}%" \
  icon.color=$COLOR_YELLOW \
  label.color=$COLOR_YELLOW


# -----------------------------------------------
# VPN Status
# -----------------------------------------------
VPN_PROCESS="Harmony SASE"

if pgrep -f "$VPN_PROCESS" >/dev/null 2>&1; then
  VPN_ICON="󰯄"
  VPN_LABEL="[ACTIVE]"
  VPN_COLOR=$COLOR_CYAN
else
  VPN_ICON="󰯄"
  VPN_LABEL="[OFF]"
  VPN_COLOR=$COLOR_RED
fi

sketchybar --set vpn \
  icon="$VPN_ICON" \
  label="$VPN_LABEL" \
  icon.color="$VPN_COLOR" \
  label.color="$VPN_COLOR"
