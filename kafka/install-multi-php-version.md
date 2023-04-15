<!--HugoNoteFlag-->

---


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


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 在Debian上為kafka安裝多個php版本

如果您想要為php安裝kafka，您可以執行 `pecl install rdkafka`，並在php.ini中設置庫，但是當您嘗試安裝多個php版本使用kafka時，只有一個版本能夠工作。

例如：

`PHP啟動：無法加載動態庫 'rdkafka.so'（嘗試過：/usr/lib/php/20190902/rdkafka.so（/usr/lib/php/20190902/rdkafka.so：無法打開共享對象文件：沒有此類文件或目錄），/`

> 20190902是php7.4的php庫文件夾，2021/09/02是php8.1

同時，您可以看到在另一個版本的庫文件夾中安裝了 `rdkafka.so`，在我的情況下是 `/usr/lib/php/20210902/rdkafka.so`。

所以您可以做的是：將pecl設置為另一個版本的php

```shell
sudo pecl config-set php_ini /etc/php/7.4/cli/php.ini
sudo pecl config-set ext_dir /usr/lib/php/20190902/
sudo pecl config-set bin_dir /usr/bin/
sudo pecl config-set php_bin /usr/bin/php7.4
sudo pecl config-set php_suffix 7.4
sudo pecl install -f rdkafka
```

> 不確定是否必須切換php版本，但這裡是命令 `sudo update-alternatives --config php`。

安裝完成後，您可以看到 `rdkafka.so` 安裝在正確的文件夾中，但原始文件夾中的庫已經被刪除，這可能是當kafka被重新安裝時由 `pecl` 刪除的。

並不知道正確的做法是什麼，但這是我的解決方案：

1. 將lib和 `php.ini` 中的 `rdkafa.so` 名稱都改為 `{--anything--}.so`。
2. 執行上述命令。