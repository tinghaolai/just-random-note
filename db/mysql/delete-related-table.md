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




