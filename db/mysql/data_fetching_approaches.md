<!--HugoNoteFlag-->

---

## Mysql data fetching approaches

For real sql execution, see note "Compare data fetching result".

## Normal fetch (without join, condition)

Normally, there's three ways to get table data.

* Select whole table once
  * Not suitable when data amount is huge.
* Chunk data by limit and offset
  * Would be slow when offset is big, because mysql need to calculate offsete position.
  * Usually used in pagination
* Chunk by primary key range
  * Fast to range the chunk data due to key.
  * Can't know chunk size

## Complex condition search and fast condition search

When search query is slow and match data amount is big, it could be very slow to fetch all data by chunk.

> Maybe use "EXPLAIN" to see the query can know why it's slow, because it use primary index, then mysql have to calculate each row if match the conditions. 

### Temporary table

One way prevent using "primary key" index is that create a temporary table to store whole condition result, and then fetch result from temp table.

But this solution only works on specific condition, if data amount is not big enough, or query is actually fast, then temporary table approach could slower thank normal chunk fetching.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## Mysql 數據抓取方式

有關真正的 sql 執行，請參閱“比較數據抓取結果”注。

## 正常抓取（沒有連接、條件）

通常有三種方法來獲取表格數據。

* 一次選擇整個表格
  * 當數據量巨大時不適用。
* 根據 limit 和 offset 分段數據
  * 當 offset 很大時會很慢，因為 MySQL 需要計算 offset 位置。
  * 通常用於分頁。
* 根據主鍵範圍進行分段
  * 由於鍵，快速排序的分塊數據。
  * 不能知道分塊大小。

## 複雜條件搜索和快速條件搜索

當搜索查詢緩慢且匹配的數據量很大時，按塊抓取所有數據可能會非常緩慢。

> 可以使用“EXPLAIN”來查看查詢是否知道為什麼慢，因為它使用主索引，然後 MySQL 必須計算每行是否匹配條件。

### 臨時表

一種防止使用“主索引”的方法是創建一個臨時表來存儲整個條件結果，然後從臨時表中獲取結果。

但這種解決方案只適用於特定條件，如果數據量不夠大，或者查詢實際上很快，那麼臨時表方法可能比正常的分塊抓取方法更慢。