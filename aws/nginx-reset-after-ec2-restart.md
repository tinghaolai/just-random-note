<!--HugoNoteFlag-->

---

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

---

<!--HugoNoteZhFlag-->


## EC2 重啟後 Nginx 無法正常啟動  (Translated by ChatGTP)

在 EC2 引擎重啟後，Nginx 經常無法正確初始化。這裡提供一些嘗試的命令。

### 如果 Nginx 服務啟動失敗

查看 `error.log` 是否有端口被佔用。

```
sudo apachectl stop
```

### 重新安裝 Nginx

```
apt-get remove nginx nginx-common
apt-get purge nginx nginx-common
apt-get autoremove
apt-get remove nginx-full nginx-common

apt-get install nginx
```

### 檢查 Nginx 設定

檢查以下目錄中的 rewrite 設定：

```
/etc/nginx/sites-enabled
/etc/nginx/sites-available
```

### 重啟命令

```
sudo pkill -f nginx & wait $!
sudo systemctl start nginx
sudo service nginx restart
```

