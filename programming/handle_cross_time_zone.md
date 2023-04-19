<!--HugoNoteFlag-->

---

## Handle cross time zone

### Solution

If we have clients in different timezone, 
how should we store the time data?

I think the best way is that client side way convert to timestamp, 
or give timezone info in API.

### Other approach

But what if another team member suggest just store origin datetime or timestamp?

Would that cause problems? and how to prove that?

### Store datetime

If current time is `GTM +0 2023-02-09 00:00:00`,
and we have two client in two timezones, 
which are `GMT +2` and `GMT +3`.

If we just store the datetime from client-side,
We will store two different datetime even both of them are the same time.

### Store timestamp by serverside

If current time is `GMT +0 2023-02-09 00:00:00`, which timestamp is `1675900800`

The client timezone is `GMT +2 2023-02-09 02:00:00`, which timestamp is also `1675900800`

And the server timezone is `GMT +8 2023-02-09 08:00:00`, which timestamp is also `1675900800`

If we convert the client-side to timestamp, in GMT + 0 would be `1675908000`, and GMT + 8 would be `1675879200`

When the client send another API want to get data stored in `GMT +2 2023-02-09 02:00:00`,
In server parse this datetime with GMT +8,

example: php 
```php
dd(Carbon::parse('2023-02-09 02:00:00')->timestamp);
```

Result timestamp would be `1675879200`, which is correct timestamp stored.

But, we'll still have two problems,
1. We can't display the correct datetime unless we know both server and client timezone and how data stored. It can be complex.
2. Still have wrong time if client have multiple timezones.
   * if we have another client with GMT + 3, the timestamp would be `1675882800`, which timestamp won't match if get data API called from GMT + 2.







---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 處理跨時區

### 解決方案

如果我們有來自不同時區的客戶端，我們應該如何存儲時間數據？

我認為最好的方法是由客戶端將時間轉換為時間戳，或在 API 中提供時區信息。

### 其他方法

但如果另一個團隊成員建議只存儲原始日期時間或時間戳呢？

這會導致問題嗎？如何證明呢？

### 存儲日期時間

如果當前時間是 `GTM +0 2023-02-09 00:00:00`，並且我們有兩個客戶端在兩個時區，分別是 `GMT +2` 和 `GMT +3`。

如果我們只是從客戶端存儲日期時間，即使它們都是相同的時間，我們也會存儲兩個不同的日期時間。

### 由服務器端存儲時間戳

如果當前時間是 `GMT +0 2023-02-09 00:00:00`，時間戳是 `1675900800`

客戶端的時區是 `GMT +2 2023-02-09 02:00:00`，時間戳也是 `1675900800`

服務器的時區是 `GMT +8 2023-02-09 08:00:00`，時間戳也是 `1675900800`

如果我們將客戶端轉換為時間戳，在 GMT +0 的時間戳為 `1675908000`，而在 GMT +8 為 `1675879200`

當客戶端發送另一個 API 請求以獲取存儲在 `GMT +2 2023-02-09 02:00:00` 的數據時，服務器將其解析為 GMT +8，

例如：PHP
```php
dd(Carbon::parse('2023-02-09 02:00:00')->timestamp);
```

結果的時間戳將是 `1675879200`，這是正確的時間戳。

但是，我們仍然有兩個問題，
1. 我們除非知道服務器和客戶端的時區以及數據如何存儲，否則無法顯示正確的日期時間。這可能很複雜。
2. 如果客戶端有多個時區，時間仍會有錯誤。
   * 如果我們有另一個 GMT +3 的客戶端，則時間戳將是 `1675882800`，如果從 GMT +2 調用獲取數據 API，則時間戳將不匹配。