<!--HugoNoteFlag-->

---

## Group by time range

Let's say we have a table called `target_table`,

and we want to calculate the total records of different time range from the `target_table` table,

What we want to group by is the `created_at` column (which is store the unix time), 

and convert to its own group.

For example,

if we want to every 10 minutes into one group and count the total records,

`10:00:00` to `10:09:59` is one group,

`10:10:00` to `10:19:59` is another group,

What to do is that we can do something like this

`floor(created_at / 60 / 10) * 60 * 10)`

which `10` to be the minutes we want to group by.

you can also calculate the whole day,

for example,

`floor(created_at / 60 / 1440) * 60 * 1440)`

## Timezone problem

If your system have multiple timezone,

for example,

this customer's data is in `+8:00` timezone,

and another customer's data is in `+0:00` timezone,

What's the problem if we use all the same query?

Let's say we want to count the total records of all the day,

and there's two table,

`custom_1.target_table`, 

`custom_2.target_table`,

the timezone of `custom_1.target_table` is `+8:00`,

and the timezone of `custom_2.target_table` is `+0:00`,

At the `0` of unix time, 

`+0:00` is `1970-01-01 00:00:00`,

`+8:00` is `1970-01-01 08:00:00`,

so in this query,

`floor(created_at / 60 / 1440) * 60 * 1440)`

the time range we calculate for timezone in `+0:00` is 

`1970-01-01 00:00:00` to `1970-01-01 23:59:59`,

but for timezone in `+8:00` is 

`1970-01-01 08:00:00` to `1970-01-01 23:59:59`,

That's not what we want.

## Solution

Add bias base on timezone,

in query below,

`28800` is the bias of `+8:00` timezone,

and '+8:00' is the timezone we want to convert to.


```sql
SELECT 
created_at as origin,
date_format(
    CONVERT_TZ(
        FROM_UNIXTIME(
    floor((created_at + 28800) / 60 / 1440) * 60 * 1440), 
        '+8:00', '+0:00'), 
    '%Y-%m-%d %H:%i:%s') 
as range_start,
FROM target_table
order by id ;
```


---

<!--HugoNoteZhFlag-->


## 時間區間分組 (Translated by ChatGTP)

假設我們有一個名為 `target_table` 的資料表，

我們想要計算 `target_table` 資料表中不同時間區間的總記錄數，

我們要以 `created_at` 欄位（儲存 Unix 時間）作為分組依據，

並將其轉換為它自己的分組。

舉例來說，

如果我們想要將每 10 分鐘分為一個組並計算總記錄數，

`10:00:00` 至 `10:09:59` 為一組，

`10:10:00` 至 `10:19:59` 為另一組，

我們可以做像這樣的事情：

`floor(created_at / 60 / 10) * 60 * 10)`

其中 `10` 是我們想要分組的分鐘數。

你也可以計算整天的時間，

例如，

`floor(created_at / 60 / 1440) * 60 * 1440)`

## 時區問題

如果您的系統有多個時區，

例如，

這個客戶的數據位於 `+8:00` 時區，

而另一個客戶的數據位於 `+0:00` 時區，

如果我們使用完全相同的查詢，會有什麼問題？

假設我們想要計算整天的總記錄數，

並且有兩個資料表，

`custom_1.target_table`，

`custom_2.target_table`，

`custom_1.target_table` 的時區是 `+8:00`，

`custom_2.target_table` 的時區是 `+0:00`，

在 Unix 時間的 `0` 時，

`+0:00` 為 `1970-01-01 00:00:00`，

`+8:00` 為 `1970-01-01 08:00:00`，

因此在此查詢中，

`floor(created_at / 60 / 1440) * 60 * 1440)`

我們計算 `+0:00` 時區的時間範圍是

`1970-01-01 00:00:00` 至 `1970-01-01 23:59:59`，

但對於 `+8:00` 時區，

則是 `1970-01-01 08:00:00` 至 `1970-01-01 23:59:59`，

這不是我們想要的。

## 解決方案

根據時區添加偏移量，

在以下查詢中，

28800 是 +8:00 時區的偏移量，

而 '+8:00' 是我們想要轉換的時區。

```sql
SELECT 
created_at as origin,
date_format(
    CONVERT_TZ(
        FROM_UNIXTIME(
    floor((created_at + 28800) / 60 / 1440) * 60 * 1440), 
        '+8:00', '+0:00'), 
    '%Y-%m-%d %H:%i:%s') 
as range_start,
FROM target_table
order by id ;
```
