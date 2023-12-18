## Crontab zombie process

If a lot or crontab output to stdout, it will cause zombie process.

### Solution

Redirect output to /dev/null

```bash
* * * * * /usr/bin/php /var/www/html/artisan schedule:run >> /dev/null 2>&1
```