## Launchctl

* `sudo launchctl list`
* Load `sudo launchctl load -w ~/Library/LaunchAgents/frpc.plist`
* Remove `sudo launchctl remove -w ~/Library/LaunchAgents/frpc.plist`
* Restart `sudo launchctl kickstart -k {service_name}`
