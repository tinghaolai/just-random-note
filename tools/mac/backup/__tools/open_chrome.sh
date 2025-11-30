osascript -e '
if application "Google Chrome" is running then
  tell application "Google Chrome" to activate
else
  tell application "Google Chrome" to launch
end if
'
