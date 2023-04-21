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

## Paginate

There's a problem with common pagination using limit and offset,

if size of offset is too large,

it will cause performance issue,

since it will scan all the rows before the offset.

One of solution is to use last of `id` to paginate.





---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 空值

總之，在 `MySQL` 數據庫中不建議使用 `NULL` 值。

`NULL` 值存在許多問題，在不同版本/情況下存在不同的問題，可能會導致以下問題：

* 引起性能問題
* 導致排序錯誤
* 導致計算結果錯誤，比如 `count()`、`max()`、`min()`

## 終止執行時間過長的進程

運行 `Show processlist;` 命令，然後使用 `kill {processID}` 終止執行

## count(*) vs count(1) 速度比較

在 `innodb` 中相同

## 分頁

常見的分頁使用 `limit` 和 `offset` 存在問題，如果偏移量太大，它會導致性能問題，因為它會在偏移之前掃描所有行。其中一個解決方案是使用 `id` 的最後一個值進行分頁。