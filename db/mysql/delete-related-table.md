<!--HugoNoteFlag-->

---

## MySQL delete related table 

Using `where in` or `exists` depends on table size,
and check index the query using.

```SQL
explain delete from delete_related_table_member_tags relation where tag_id in
                    (select id from delete_related_table_tags tag where tag.type = 'A');

explain delete from delete_related_table_member_tags relation
       where exists(select id from delete_related_table_tags tag where tag.id = relation.tag_id and tag.type = 'A');

explain delete relation from delete_related_table_member_tags relation
inner join delete_related_table_tags tag on relation.tag_id = tag.id
where tag.type = 'A';
```

| id | select\_type | table | partitions | type | possible\_keys | key | key\_len | ref | rows | filtered | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | SIMPLE | tag | null | ref | PRIMARY,type | type | 1022 | const | 2496048 | 100 | Using index |
| 1 | DELETE | relation | null | ref | tag\_id | tag\_id | 4 | test.tag.id | 1 | 100 | null |

## Approaches actual tests

See file in `playground/laravel/app/Console/Commands/MySQLDeleteRelatedTable.php`.

### Results

```php

/**
 * test_type_without_id_type_index
 *
 * ---deleteFromWhereIn start---
run time: 41.261170148849seconds
---deleteFromWhereIn end----
---deleteFroWhereExists start---
run time: 41.044189929962seconds
---deleteFroWhereExists end----
---deleteFromJoin start---
run time: 42.302510023117seconds
---deleteFromJoin end----

 *
 *
 */

/**
 *
 * test_type_with_id_type_index
 *
 * ---deleteFromWhereIn start---
run time: 41.456815004349seconds
---deleteFromWhereIn end----
---deleteFroWhereExists start---
run time: 42.01546216011seconds
---deleteFroWhereExists end----
---deleteFromJoin start---
run time: 39.968888044357seconds
---deleteFromJoin end----

 *
 */

/**
 * test_type_with_id_type_index_and_force_index
 *
 * ---deleteFromWhereIn start---
run time: 44.467664003372seconds
---deleteFromWhereIn end----
---deleteFroWhereExists start---
run time: 39.107469081879seconds
---deleteFroWhereExists end----
---deleteFromJoin start---
run time: 62.701831102371seconds
---deleteFromJoin end----

 */


```






---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## MySQL 刪除相關表格

使用 `where in` 或 `exists` 取決於資料表大小和查詢中的索引檢查。

```SQL
說明從delete_related_table_member_tags關係表中刪除，其標籤ID
在（選擇從delete_related_table_tags標籤中的ID where tag.type = 'A'）

說明從delete_related_table_member_tags刪除關係
在（選擇從delete_related_table_tags標籤中的ID where tag.id = relation.tag_id 和tag.type = 'A'）

說明從delete_related_table_member_tags刪除關係
inner join delete_related_table_tags標籤
where relation.tag_id = tag.id 和tag.type = 'A';
```

| id | select\_type | table | partitions | type | possible\_keys | key | key\_len | ref | rows | filtered | Extra |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| 1 | 簡單 | tag | null | 參考 | 主要,type | type | 1022 | const | 2496048 | 100 | 使用索引 |
| 1 | 刪除 | 關係 | null | 參考 | tag\_id | tag\_id | 4 | test.tag.id | 1 | 100 | 無 |

## 實際考試方法

參見檔案 `playground/laravel/app/Console/Commands/MySQLDeleteRelatedTable.php`。

### 結果

```php

/**
 * test_type_without_id_type_index
 *
 * ---deleteFromWhereIn start---
運行時間：41.261170148849秒
---deleteFromWhereIn end----
---deleteFroWhereExists start---
運行時間：41.044189929962秒
---deleteFroWhereExists end----
---deleteFromJoin start---
運行時間：42.302510023117秒
---deleteFromJoin end----

 *
 *
 */

/**
 *
 * test_type_with_id_type_index
 *
 * ---deleteFromWhereIn start---
運行時間：41.456815004349秒
---deleteFromWhereIn end----
---deleteFroWhereExists start---
運行時間：42.01546216011秒
---deleteFroWhereExists end----
---deleteFromJoin start---
運行時間：39.968888044357秒
---deleteFromJoin end----

 *
 */

/**
 * test_type_with_id_type_index_and_force_index
 *
 * ---deleteFromWhereIn start---
運行時間：44.467664003372秒
---deleteFromWhereIn end----
---deleteFroWhereExists start---
運行時間：39.107469081879秒
---deleteFroWhereExists end----
---deleteFromJoin start---
運行时间：62.701831102371秒
---deleteFromJoin end----

 */


```