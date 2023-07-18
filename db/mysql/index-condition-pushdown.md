<!--HugoNoteFlag-->

---

## Index Condition Pushdown (ICP)

ICP opened automatically

## What does ICP do?

example:

Table:
```sql
create table t(
    a int,
    b int,
    key(a,b)
);
```

Query: 
```sql
select * from t where a like 'A%' and b=2;
```

### Without ICP
MySQL scan rows match `a like 'A%'` first using `secondary index`,
then scan rows match `b=2` using `primary index`.

### With ICP
MySQL scan rows match `a like 'A%' and b=2` using `secondary index`,
since `b` is the second column of `key(a,b)`.

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

ICP指標條件推送（Index Condition Pushdown）

ICP自動打開了

ICP做了什麼？

範例：

表格：
```sql
create table t(
    a int,
    b int,
    key(a,b)
);
```

查詢：
```sql
select * from t where a like 'A%' and b=2;
```

### 沒有使用ICP
MySQL首先使用`次要索引`掃描符合`a like 'A%'`的行，然後使用`主要索引`掃描符合`b=2`的行。

### 使用ICP
MySQL使用`次要索引`掃描符合`a like 'A%' and b=2`的行，因為`b`是`key(a,b)`的第二個欄位。