<!--HugoNoteFlag-->

---

## Https for develop

Ways to run https for develop when https is required.

### Non docker

* Widows: apache (MAMP)
* Others: nginx (recommended)

### Docker

* php-fpm container + nginx container run static html file
* php artisan serve + nginx container proxy to laravel serve 

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 開發時使用 HTTPS

需要使用 HTTPS 時的開發中 HTTPS 的執行方式。

### 非 Docker

* Windows: Apache (MAMP)
* 其他: Nginx (推薦)

### Docker

* 使用 php-fpm 容器 + Nginx 容器執行靜態 HTML 檔案
* 使用 php artisan serve + Nginx 容器代理到 Laravel Serve