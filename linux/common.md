## Linux common note

## High cpu usage

Sometimes can not find high CPU usage by `htop`.

Try `ps -eo pcpu,pid,user,args | tail -n +2 | sort -k1 -r -n | head -10`

## Turn off laptop monitor when openSSH

When you run linux server on the laptop, you don't need the monitor, but server shut down if you close the laptop monitor.

### Solution

* `sudo vim /etc/systemd/logind.conf`
* Add line
    * HandleLidSwitch=ignore
* Run `sudo systemctl restart systemd-logind`
