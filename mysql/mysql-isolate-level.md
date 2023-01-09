## MySQL isolate level

### Find current isolate level

5.7 
> select @@tx_isolation;

8.0
> SELECT @@TRANSACTION_ISOLATION;

default value
> REPEATABLE-READ

### Transaction operations

```sql
begin;
select * from test.members where id = 3;
update test.members set type = 9999 where id = 3;
rollback;
commit;
```


### Test transaction level

```sql
set session transaction isolation level read uncommitted;
```

### Isolate levels

* read uncommitted
  * Can see data change on another session when data not commit/rollback.
  * Need to change isolate level on the session that read data, not session that update data.
* read committed
  * Can read data, but data would be unchanged.
* repeatable read
  * Can read data only when transaction begin, can not read data change even other session commit the update.

> All of them can not solve un-synchronized data manipulate problem.

* serializable
  * Lock other session data change even just selecting data.

> Can solve the un-synchronize operations problem, but could cause lots of lock waiting.


