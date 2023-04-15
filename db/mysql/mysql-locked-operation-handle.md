<!--HugoNoteFlag-->

---


## MySQL locked operation handle

sql stuck? why?
use `show processlist;`
it shows `Waiting for table metadata lock`
and what causing the lock?

use `select trx_state, trx_started, trx_mysql_thread_id, trx_query from information_schema.innodb_trx;`

and kill the process

but if the state of process is `ROLLING BACK`, there's nothing you can do about it due to ACID.






---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## MySQL 鎖定操作處理

SQL 卡住了？為什麼呢？
使用 `show processlist;`
它會顯示 `Waiting for table metadata lock`
是什麼導致了這個鎖定？

使用 `select trx_state, trx_started, trx_mysql_thread_id, trx_query from information_schema.innodb_trx;`

然後殺掉進程

但是如果進程狀態是 `ROLLING BACK`，由於 ACID，你什麼也做不了。