<!--HugoNoteFlag-->

---

## Start container after reboot

* `vim etc/systemd/system/sentry.service`
  * ```yaml
    [Unit]
    Description=Start sentry_line_notify_webhook_app container
    Requires=docker.service
    After=docker.service
    
    [Service]
    Restart=always
    ExecStart=/usr/bin/docker start -a sentry_line_notify_webhook_app_1
    
    [Install]
    WantedBy=multi-user.target
    ``` 
* `sudo systemctl daemon-reload`
* `sudo systemctl enable sentry`
* `sudo systemctl start sentry`

Then you can check by `docker ps` after reboot.

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 在重新啟動後啟動容器

* `vim etc/systemd/system/sentry.service`
  * ```yaml
    [Unit]
    Description=啟動 sentry_line_notify_webhook_app 容器
    Requires=docker.service
    After=docker.service
    
    [Service]
    Restart=always
    ExecStart=/usr/bin/docker start -a sentry_line_notify_webhook_app_1
    
    [Install]
    WantedBy=multi-user.target
    ``` 
* `sudo systemctl daemon-reload`
* `sudo systemctl enable sentry`
* `sudo systemctl start sentry`

然後您可以在重新啟動後使用 `docker ps` 進行檢查。