<!--HugoNoteFlag-->

---

### Laravel with https

```Dockerfile
FROM php:7.4-fpm

# Add docker php extension installer script
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# Install Composer
RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions @composer \
    calendar \
    exif \
    ffi \
    gd \
    gettext \
    imagick \
    imap \
    intl \
    mysqli \
    pcntl \
    pdo \
    pdo_mysql \
    rdkafka \
    redis \
    shmop \
    soap \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    xmlrpc \
    xsl \
    zip \
    mongodb

WORKDIR /var/www/html
ENTRYPOINT php-fpm -D && php artisan serve --host 0.0.0.0

```

docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - 8090:8000
    volumes:
      - .:/var/www/html
    tty: true
    networks:
      - cdp
  nginx:
    image: nginx
    ports:
      - 7774:443
    volumes:
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
      - .:/var/www/html
    networks:
      - cdp
networks:
    cdp:
        driver: bridge

```

nginx.conf
```
  server {
    listen      80;
    listen 443 ssl;

    ssl_certificate /var/www/html/XXX.crt;
    ssl_certificate_key /var/www/html/XXX.key;

    root /var/www/html/public;

    location / {
      index index.php;
      try_files $uri $uri/ /index.php?$args;
    }

    rewrite ^(.*)/index.html$ $1 permanent;

    location ~ \.php$ {
        try_files $uri index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_read_timeout 300;
        client_body_buffer_size     20M;
        client_max_body_size        20M;
        fastcgi_max_temp_file_size 0;
        include fastcgi_params;
    }

    location ~* \.(jpg|jpeg|png|gif|svg|ico|css|js)$ {
        expires epoch;
    }
  }
```


### Specify Debian and php 8.2

```Dockerfile
FROM debian:stable-slim

RUN apt-get update && \
    apt-get install -y wget gnupg2 && \
    wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add - && \
    dpkg -l | grep php | tee packages.txt && \
    apt install apt-transport-https lsb-release ca-certificates wget -y && \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' && \
    apt update && \
    apt install -y php8.2 php8.2-cli \
      php8.2-fpm \
      php8.2-cli \
      php8.2-dev \
      php8.2-sqlite3 \
      php8.2-gd \
      php8.2-curl \
      php8.2-imap \
      php8.2-mysql \
      php8.2-mbstring \
      php8.2-xml  \
      php8.2-zip  \
      php8.2-bcmath \
      php8.2-intl  \
      php8.2-readline \
      php8.2-ldap \
      php8.2-msgpack  \
      php8.2-igbinary  \
      php8.2-redis \
      php8.2-memcached \
      php8.2-pcov \
      php8.2-xdebug \
      php8.2-mongodb

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
```



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

### Laravel 和 https

```Dockerfile
FROM php:7.4-fpm

# 添加 docker php extension installer 腳本
ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

# 安裝 Composer
RUN chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions @composer \
    calendar \
    exif \
    ffi \
    gd \
    gettext \
    imagick \
    imap \
    intl \
    mysqli \
    pcntl \
    pdo \
    pdo_mysql \
    rdkafka \
    redis \
    shmop \
    soap \
    sockets \
    sysvmsg \
    sysvsem \
    sysvshm \
    xmlrpc \
    xsl \
    zip \
    mongodb

WORKDIR /var/www/html
ENTRYPOINT php-fpm -D && php artisan serve --host 0.0.0.0

```

docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    ports:
      - 8090:8000
    volumes:
      - .:/var/www/html
    tty: true
    networks:
      - cdp
  nginx:
    image: nginx
    ports:
      - 7774:443
    volumes:
      - ./nginx.conf:/etc/nginx/conf.d/default.conf
      - .:/var/www/html
    networks:
      - cdp
networks:
    cdp:
        driver: bridge

```

nginx.conf
```
  server {
    listen      80;
    listen 443 ssl;

    ssl_certificate /var/www/html/XXX.crt;
    ssl_certificate_key /var/www/html/XXX.key;

    root /var/www/html/public;

    location / {
      index index.php;
      try_files $uri $uri/ /index.php?$args;
    }

    rewrite ^(.*)/index.html$ $1 permanent;

    location ~ \.php$ {
        try_files $uri index.php =404;
        fastcgi_split_path_info ^(.+\.php)(/.+)$;
        fastcgi_pass app:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_read_timeout 300;
        client_body_buffer_size     20M;
        client_max_body_size        20M;
        fastcgi_max_temp_file_size 0;
        include fastcgi_params;
    }

    location ~* \.(jpg|jpeg|png|gif|svg|ico|css|js)$ {
        expires epoch;
    }
  }
```


### 指定 Debian 和 php 8.2

```Dockerfile
FROM debian:stable-slim

RUN apt-get update && \
    apt-get install -y wget gnupg2 && \
    wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add - && \
    dpkg -l | grep php | tee packages.txt && \
    apt install apt-transport-https lsb-release ca-certificates wget -y && \
    wget -O /etc/apt/trusted.gpg.d/php.gpg https://packages.sury.org/php/apt.gpg && \
    sh -c 'echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list' && \
    apt update && \
    apt install -y php8.2 php8.2-cli \
      php8.2-fpm \
      php8.2-cli \
      php8.2-dev \
      php8.2-sqlite3 \
      php8.2-gd \
      php8.2-curl \
      php8.2-imap \
      php8.2-mysql \
      php8.2-mbstring \
      php8.2-xml  \
      php8.2-zip  \
      php8.2-bcmath \
      php8.2-intl  \
      php8.2-readline \
      php8.2-ldap \
      php8.2-msgpack  \
      php8.2-igbinary  \
      php8.2-redis \
      php8.2-memcached \
      php8.2-pcov \
      php8.2-xdebug \
      php8.2-mongodb

RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
```