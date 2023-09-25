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