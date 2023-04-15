<!--HugoNoteFlag-->

---

## Volume to Absolute folder

```yaml
version: '3'
services:
  php-fpm:
    image: php:8-fpm
    ports:
      - 9004:9000
    volumes:
      - "C:/git:/var/www/html"
    container_name: personal-git
```


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 將卷轉換為絕對文件夾

```yaml
version: '3'
services:
  php-fpm:
    image: php:8-fpm
    ports:
      - 9004:9000
    volumes:
      - "C:/git:/var/www/html"
    container_name: personal-git
```