## Port binding limit

Without root, you can only bind ports above 1024. 

## Solution

* `vim /etc/systemd/system/frps.service`
* `systemctl daemon-reload`
* check port binding in dashboard
