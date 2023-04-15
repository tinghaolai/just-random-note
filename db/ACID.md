<!--HugoNoteFlag-->

---


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


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## ACID

### 原子性
所有在一個交易中的操作必須全部完成或全部失敗，把所有操作看作一個不可分割的原子。

### 一致性
* 千萬不要打破資料庫，這是我唯一能理解的事情。
* 如果服務在操作（例如交易）時中斷，重新啟動後必須保持正確性。

### 隔離性
如果操作有關聯，就必須鎖定，否則不一致性可能導致錯誤結果。

### 持久性
這是儲存，而不是像 Redis 一樣的快取。