<!--HugoNoteFlag-->

---

## Conclusion

Use less joins as you can, use max 2 joins, 

check if small table drive big table is better than big table drive small table.

also check index used in the join relation. 

Don't join the tables they're having different responsibility.

## But why?

### Performance issue

More join use usage, more data scan, 

causing performance issue,

and operation like this need lots of memory,

will cause other data memory cache been deleted,

which will influence other business.

#### Mainly issue

* Hard to optimize query
* Hard to modify query if one of the table changed into such as: `table-split`, `database-split`, `table-structure-modify`


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 結論

使用更少的連接，最多使用兩個連接，

檢查小表驅動大表是否比大表驅動小表更好。

還要檢查連接關係中使用的索引。

不要連接負責不同任務的表格。

## 但為什麼?

### 效能問題

更多的連接使用導致更多的數據掃描，

引起效能問題，

這樣的操作需要大量的內存，

將會刪除其他數據內存緩存，

這將影響其他業務。

#### 主要問題

* 很難優化查詢
* 如果其中一個表格更改為“表格分割”，“數據庫分割”，“表格結構修改”之類的，很難修改查詢。