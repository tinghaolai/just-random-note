## Install multiple php version for kafka (Debian)

If you want to install kafka for php, you can do `pecl install rdkafka` and set library in php.ini, 
but when you try to install multiple php version using kafka, only one version can work.

Such as:

`PHP Startup: Unable to load dynamic library 'rdkafka.so' (tried: /usr/lib/php/20190902/rdkafka.so (/usr/lib/php/20190902/rdkafka.so: cannot open shared object file: No such file or directory), /`

> 20190902 is php library folder of php7.4, and 2021/09/02 is php8.1

At the same time, you can see `rdkafka.so` is installed in another version of library folder, 
which in my case is `/usr/lib/php/20210902/rdkafka.so` 

So what u can do is: set pecl for another version of php

```shell
sudo pecl config-set php_ini /etc/php/7.4/cli/php.ini
sudo pecl config-set ext_dir /usr/lib/php/20190902/
sudo pecl config-set bin_dir /usr/bin/
sudo pecl config-set php_bin /usr/bin/php7.4
sudo pecl config-set php_suffix 7.4
sudo pecl install -f rdkafka
```

> Doesn't really sure if switching php version is necessary, 
> but here's the command  `sudo update-alternatives --config php`.

After installed, u can see `rdkafka.so` is installed in correct folder, but origin folder's library is gone,
which could removed by `pecl` when kafka is re-installed.

Don't really know the correct way to do this, but here's mine solution:

1. Rename both `rdkafa.so` name to be `{--anything--}.so` in lib and `php.ini`.
2. Execute commands above.
