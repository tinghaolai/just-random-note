## unix:///var/run/supervisor.sock refused connection

* sudo vim supervisord.conf
* edit
    ```
  [unix_http_server]
  file=/var/run/supervisor.sock   ; (the path to the socket file)
  chmod=0770                       ; try 0700 or 0770
    ```
* systemctl restart supervisor.service 