<!--HugoNoteFlag-->

---

## Docker with https

### Test outside of container

Curl to check response and error.

> 8183 is port of container exposed to host

`-k` is for ignore ssl cert error 

 * `curl 127.0.0.1:8183` for http
 * `curl https://127.0.0.1:8183` https
 * `curl -k https://127.0.0.1:8183` https


### Test from nginx container

* `app` - your service name
* `cdp_v3_nginx_1` - your nginx container name

`docker exec cdp_v3_nginx_1 curl app`


Test static file for checking nginx config and ssl cert.

> Change service to be static file server

* `docker exec test-nginx_nginx_1 curl https://127.0.0.1:443`

### Docker-compose example

```yaml
version: '3'
services:
    app:
        build:
            context: ./docker/8.1
            dockerfile: Dockerfile
        ports:
            - '8583:80'
        volumes:
            - '.:/var/www/html'
        networks:
            - test-network
    nginx:
        image: nginx
        ports:
          - 8183:443
        volumes:
          - ./nginx.conf:/etc/nginx/nginx.conf
          - .:/var/www/html
        networks:
          - test-network
        depends_on:
            - app
networks:
    test-network:
        driver: bridge
```

nginx.conf

```yaml
events {}

http {
  server {
    listen      80;
    listen 443 ssl;

    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_certificate /var/www/html/cert.crt;
    ssl_certificate_key /var/www/html/cert.key;

    server_name _;

    location / {
        proxy_http_version 1.1;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Real-PORT $remote_port;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header Server-Protocol $server_protocol;
        proxy_set_header Server-Name $server_name;
        proxy_set_header Server-Addr $server_addr;
        proxy_set_header Server-Port $server_port;
        proxy_set_header Upgrade $http_upgrade;
        proxy_pass http://app:80;
    }
  }
}
```

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 使用 https 的 Docker

### 在容器外進行測試

使用 Curl 檢查回應和錯誤。

> 8183 是容器對外開放的通訊埠

`-k` 表示忽略 SSL 證書錯誤 

 * `curl 127.0.0.1:8183` 即 http
 * `curl https://127.0.0.1:8183` 即 https
 * `curl -k https://127.0.0.1:8183` 即 https


### 從 nginx 容器進行測試

* `app` - 你的服務名稱
* `cdp_v3_nginx_1` - 你的 nginx 容器名稱

`docker exec cdp_v3_nginx_1 curl app`


測試靜態檔案以檢查 nginx 設定和 SSL 證書。

> 修改服務為靜態檔案伺服器

* `docker exec test-nginx_nginx_1 curl https://127.0.0.1:443`

### Docker-compose 範例

```yaml
version: '3'
services:
    app:
        build:
            context: ./docker/8.1
            dockerfile: Dockerfile
        ports:
            - '8583:80'
        volumes:
            - '.:/var/www/html'
        networks:
            - test-network
    nginx:
        image: nginx
        ports:
          - 8183:443
        volumes:
          - ./nginx.conf:/etc/nginx/nginx.conf
          - .:/var/www/html
        networks:
          - test-network
        depends_on:
            - app
networks:
    test-network:
        driver: bridge
```

nginx.conf

```yaml
events {}

http {
  server {
    listen      80;
    listen 443 ssl;

    ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
    ssl_certificate /var/www/html/cert.crt;
    ssl_certificate_key /var/www/html/cert.key;

    server_name _;

    location / {
        proxy_http_version 1.1;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Real-PORT $remote_port;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header Host $http_host;
        proxy_set_header Scheme $scheme;
        proxy_set_header Server-Protocol $server_protocol;
        proxy_set_header Server-Name $server_name;
        proxy_set_header Server-Addr $server_addr;
        proxy_set_header Server-Port $server_port;
        proxy_set_header Upgrade $http_upgrade;
        proxy_pass http://app:80;
    }
  }
}
```