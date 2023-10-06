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