<!--HugoNoteFlag-->

---

## Replace into vs insert on duplicate

There's several ways the to bulk insert or update data.

* Delete duplicate and bulk insert
    * Can't know what to delete first if insertion is calculated and size is big, not able to put in RAM.
* Replace into
* Bulk Insert into and bulk on duplicate

There's one problem with `replace into` is that it actually delete duplicate data first and insert new data, and it will trigger delete casade, which may not the sql originally want to do.

> Base on this, I didn't compare performance, besides, should be about the same.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## Replace into vs insert on duplicate

有幾種方式可以大量插入或更新資料。

* 刪除重複並批量插入
    * 如果插入是計算的且大小很大，無法放入 RAM，則無法知道要先刪除什麼。
* Replace into
* 批量插入和“批量重複”

使用 `replace into` 的一個問題是它實際上首先刪除重複的資料並插入新的資料，這將觸發刪除角落，可能不是原本想要執行的 SQL。

> 基於此，我沒有比較效能，除此之外，應該差不多。