## Swoole vs php-fpm

|   | Swoole | php-fpm                                               |
|---| --- |-------------------------------------------------------|
| Process | Multi-process | Multi-process                                         |
| Request handle | Async | Sync (each process will only handle current request)  |
| Code memory | Init once | Init for every request, after request, release memory |


### Conclusion

Swoole has better performance and better ability to handle concurrent request.