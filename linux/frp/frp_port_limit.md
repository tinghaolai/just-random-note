<!--HugoNoteFlag-->

---

## Port binding limit

Without root, you can only bind ports above 1024. 

## Solution

* `vim /etc/systemd/system/frps.service`
* `systemctl daemon-reload`
* check port binding in dashboard


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 端口绑定限制

如果没有超级用户权限，只能绑定大于1024的端口。

## 解决方案

* `vim /etc/systemd/system/frps.service`
* `systemctl daemon-reload`
* 在仪表盘中检查端口绑定情况