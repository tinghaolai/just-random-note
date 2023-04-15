<!--HugoNoteFlag-->

---


### Check open port
netstat -ap tcp | grep -i "listen"


### mysql restart
mysql.server restart

### check if ssh on
sudo systemsetup -getremotelogin

### Find local Ip
ifconfig | grep "inet " | grep -Fv 127.0.0.1 | awk '{print $2}'

### su
sudo su

### nginx restart

sudo pkill nginx && sudo nginx


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

### 檢查開啟的埠口
netstat -ap tcp | grep -i "listen"

### 重啟 MySQL
mysql.server restart

### 檢查 SSH 是否開啟
sudo systemsetup -getremotelogin

### 查找本地 IP
ifconfig | grep "inet " | grep -Fv 127.0.0.1 | awk '{print $2}'

### 切換為超級使用者
sudo su

### 重啟 Nginx
sudo pkill nginx && sudo nginx