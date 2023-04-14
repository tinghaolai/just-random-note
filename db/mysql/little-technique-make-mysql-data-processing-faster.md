
<!--HugoNoteFlag-->

---

## Static Data Calculation

Let's say we have a table called `raw`. 

We want to calculate some static data from the `raw` table,

and write the result into the `result` table every day at midnight.

During the calculation process, 

if some result is reusable, 

we can store the intermediate result in the `temp` table,

so that we can calculate the result faster the next time.

## Synchronization Diff Problem

Every time we recalculate the result, 

we need to sync the difference from the `raw` table to the `temp` table,

and then continue to calculate the result. 

However, the `diff sync` may be very slow if there is a lot of data in the `raw` table 

when there is an index in the `temp` table. 

Because every operation will cause the index to be updated, 

and it will update the record one by one.

## Solution

Before syncing the diff, 

we can drop the index in the `temp` table, 

sync the diff, 

and then recreate the index again after syncing. 

In this way, we can calculate the new index much faster.

> This approach is not suitable for all situations, 
> 
> it fits in this situation since only this feature is using the table.
> 
> If there is another feature using the table,
> 
> we can't drop the index in the table, 
> 
> or the searching speed will be very slow.

---

<!--HugoNoteZhFlag-->

## Static Data Calculation (Translated by ChatGTP)

假設我們有一個名為 `raw` 的資料表。

我們想從 `raw` 資料表中計算一些靜態數據，

並在午夜每天將結果寫入 `result` 資料表。

在計算過程中，

如果有些結果是可重複使用的，

我們可以將中間結果存儲在 `temp` 資料表中，

這樣下次計算結果時就可以更快速地進行計算。

## 同步差異問題

每次重新計算結果時，

我們需要將 `raw` 資料表中的差異同步到 `temp` 資料表中，

然後繼續計算結果。

但是，如果 `raw` 資料表中有大量數據並且 `temp` 資料表中有索引，

則同步過程可能會非常緩慢。

因為每個操作都會導致索引更新，

並且它會逐一更新記錄。

## 解決方案

在同步差異之前，

我們可以在 `temp` 資料表中刪除索引，

同步差異，

然後在同步後重新創建索引。

這樣，我們可以更快速地計算新索引。

> 這種方法不適用於所有情況，
> 
> 因為只有此功能使用了資料表，所以適用於此情況。
> 
> 如果還有其他功能使用資料表，
> 
> 我們就不能在資料表中刪除索引，
> 
> 否則查詢速度會非常慢。