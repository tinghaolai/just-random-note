## ACID

### Atomicity
All manipulate in a transaction must be done or all failed, consider all operations as a atom, which is inseparable.

### Consistency
* Do not fucking break the database, the only thing I can understand.
* If service break during the operation such as transaction, after restart, have to remain correction.

### Isolation
Had to lock if manipulates has related, otherwise the inconsistency could cause wrong result.

### Durability
It's storage, not cache like redis.
