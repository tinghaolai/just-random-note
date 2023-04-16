<!--HugoNoteFlag-->

---

## Don't select all columns

Selecting all columns from a table is a bad practice. It is better to select only the columns you need.

## Buy why

In `innoDB`, there are two type of indexes,

primary index and secondary index.

If we ask the columns not in the secondary index, 

event we found the row we want by secondary index,

we still need to read the primary index to get other columns,

that's why if you `explain` the query with `select *` and `select index_columns`,

and why mysql optimizer choose different query plan. 


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 不要選取所有欄位

從資料表選擇所有欄位是一種不良的做法。最好只選擇您需要的欄位。

## 但為什麼呢？

在 `innoDB` 中，有兩種索引類型，即主索引和次要索引。如果我們請求次要索引中沒有的欄位，即使我們通過次要索引找到所需的行，我們仍然需要讀取主索引以獲取其他欄位，這就是為什麼如果您使用 `select *` 和 `select index_columns` 來解釋查詢，MySQL 優化器會選擇不同的查詢計劃的原因。