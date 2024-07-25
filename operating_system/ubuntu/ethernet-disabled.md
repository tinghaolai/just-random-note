Ubuntu 22.04

Somehow after I rebooted my computer, 

I can't connect to the internet.


Step 1.

check status `lshw -C network`

if my case, ethernet is disabled.

Step 2.

There are plenty of solutions on the internet,

but the one that works for me is:

* vim `/usr/lib/NetworkManager/conf.d/10-globally-managed-devices.conf`
* append `,except:type:ethernet`

file will look like this:

```conf
[keyfile]
unmanaged-devices=*,except:type:ethernet,except:type:wifi,except:type:wwan
```


Step 3.

systemctl restart NetworkManager
