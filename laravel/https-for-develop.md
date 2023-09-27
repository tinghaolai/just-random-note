## Https for develop

Ways to run https for develop when https is required.

### Non docker

* Widows: apache (MAMP)
* Others: nginx (recommended)

### Docker

* php-fpm container + nginx container run static html file
* php artisan serve + nginx container proxy to laravel serve 