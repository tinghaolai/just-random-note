<!--HugoNoteFlag-->

---

## Null value

In conclusion, don't recommend to use `NULL` in `MySQL` database.

There's a lot of problem with `NULL` value,

but various in different version/situation.

There are some problems might happen.


* Causing performance issue
* Causing wrong sort
* Causing wrong result for calculation such as `count()`, `max()`, `min()`

## Kill process that execute too long

run `Show processlist;` and `kill {processID}`

## count(*) vs count(1) speed

same in `innodb`




---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 空值

結論是不建議在 `MySQL` 數據庫中使用 `NULL`。

使用 `NULL` 值存在著很多問題，而且在不同的版本/情況下會有各種不同的問題。

可能會出現以下一些問題：

* 導致性能問題
* 導致排序錯誤
* 導致計算結果錯誤，例如 `count()`、`max()` 和 `min()`

## 終止運行時間過長的進程

運行 `Show processlist;` 並執行 `kill {processID}`。

## count(*) vs count(1) 的速度

在 `innodb` 中相同。