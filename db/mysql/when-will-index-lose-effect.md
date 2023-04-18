<!--HugoNoteFlag-->

---

## When will index column lose effect

### Operations on index column

`explain select * from target_tag where CONCAT('t', name) = 'etname';`

#### Fuzzy searching at beginning

`explain select * from target_tag where name like '%etnam%';`

> All

`explain select * from target_tag where name like 'tetnam%';`

> key type: `range`

### Using `OR` Condition

Not using index column in one of `OR` condition

### MySQL think scan all table is faster than using index

* searching result amount is relatively close to the whole table amount
    * using index need extra time to get data from index, which is I/O reading.

### Using not equal / is not null / not in / not exists

`explain select * from target_tag where name != 'testname';`



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 當索引欄位失效時

### 索引欄位的操作

`explain select * from target_tag where CONCAT('t', name) = 'etname';`

#### 在開頭進行模糊搜尋

`explain select * from target_tag where name like '%etnam%';`

> 全部的

`explain select * from target_tag where name like 'tetnam%';`

> 鍵值類型：`range`

### 使用 `OR` 條件

在一個 `OR` 條件中不使用索引欄位

### MySQL 認為掃描整個表比使用索引更快

* 搜尋結果的數量與整個表的數量相對接近
    * 使用索引需要額外的時間來從索引中獲取數據，這是 I/O 讀取。

### 使用不等於 / 不為空 / 不包含 / 不存在

`explain select * from target_tag where name != 'testname';`