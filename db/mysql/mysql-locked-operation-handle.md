## MySQL locked operation handle

sql stuck? why?
use `show processlist;`
it shows `Waiting for table metadata lock`
and what causing the lock?

use `select trx_state, trx_started, trx_mysql_thread_id, trx_query from information_schema.innodb_trx;`

and kill the process

but if the state of process is `ROLLING BACK`, there's nothing you can do about it due to ACID.




