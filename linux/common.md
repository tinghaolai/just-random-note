## Linux common note

## High cpu usage

Sometimes can not find high CPU usage by `htop`.

Try `ps -eo pcpu,pid,user,args | tail -n +2 | sort -k1 -r -n | head -10`

