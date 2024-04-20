Let's say we're using these settings:

`php artisan queue:work database --timeout=10`

in `config/queue.php`

```php
'connections' => [
    'database' => [
        'driver' => 'database',
        'table' => 'jobs',
        'queue' => 'default',
        'retry_after' => 20,
    ],
],
```

current minute/second is `00:00` and executed job which tries = 3

1. 00:00 - job executed
2. 00:10 - job timeout (stopped)
3. 00:20 - job retry


but if we set `retry_after` to `5` in `config/queue.php`

1. 00:00 - first job executed
2. 00:05 - second job executed

---- two jobs executed at the same time-----

4. 00:10 - first job timeout (stopped)
