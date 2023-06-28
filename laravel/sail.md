<!--HugoNoteFlag-->

---

## Permission issue

run `./vendor/bin/sail test` and got

> PHP Warning:  file_put_contents(/var/www/html/.phpunit.result.cache): Failed to open stream: Permission denied in /var/www/html/vendor/phpunit/phpunit/src/Runner/ResultCache/DefaultResultCache.php on line 143

* Enter container through exec -it or `./vendor/bin/sail root-shell`
* chown -R sail:sail {laravel_project_dir}



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 權限問題

執行 `./vendor/bin/sail test` 後出現以下錯誤：

> PHP 警告: 在 /var/www/html/vendor/phpunit/phpunit/src/Runner/ResultCache/DefaultResultCache.php 的第 143 行中，寫入檔案 /var/www/html/.phpunit.result.cache 時發生權限拒絕的錯誤。

* 使用 `exec -it` 或 `./vendor/bin/sail root-shell` 進入容器
* 使用 `chown -R sail:sail {laravel_project_dir}` 更改目錄權限。