## Nginx reset after ec2 restart

After the restart ec2 engine, nginx always cannot init correctly, here's some commands to try.

### If nginx service fail

see `error.log` if port has been used.

`sudo apachectl stop`

### Reinstall nginx

```bash
apt-get remove nginx nginx-common
apt-get purge nginx nginx-common
apt-get autoremove
apt-get remove nginx-full nginx-common

apt-get install nginx
```

### Check nginx setting

rewrite settings in
```bash
/etc/nginx/sites-enabled
/etc/nginx/sites-available
```

### Restart commands

```bash
sudo pkill -f nginx & wait $!
sudo systemctl start nginx
sudo service nginx restart
```
