<!--HugoNoteFlag-->

---

## Why

If the size of table is too large,

the performance will be bad,

and one of solution is to split the table.

## How to split table

* Base on the different data type
* split by id

## Split by id

But how to find which database/table to get the row.

For example: If we have too many users, 

and we want to split it into multiple table.

And we have a user_id: `559342`,

how do we know which table `user_id:559342` in?

### Solution

* Using hash to know which table to store / read.
* Hash methods
  * Snowflake

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 為什麼

如果表格的大小太大，

性能會變差，

其中一種解決方法是將表格分割。

## 如何分割表格

* 基於不同的數據類型
* 按 id 分割

## 按 id 分割

但如何找到需要獲取行的數據庫/表格。

例如：如果我們有太多用戶，

我們想將其分割成多個表格。

並且有一個用戶 ID：`559342`，

我們如何知道 `user_id:559342` 在哪個表中？

### 解決方案

* 使用哈希來知道要存儲/讀取哪個表。
* 哈希方法
  * Snowflake