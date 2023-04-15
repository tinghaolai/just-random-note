<!--HugoNoteFlag-->

---


## Eloquent relation last of many

In some specific situation, we need to search relation of "only last record", for example, I want to search every customer whom last order price is more than 1000.

If we search like this: 

```php
Member::whereHas('lastOrder', function ($query) {
    $query->where('money', '>', 1000);
})


function lastOrder() {
    return $this->hasOne(Order::class)->orderByDesc('id');
}
```

The relation with condition tells sql to do is search `Last order that money is more than 1000` which is not what we want.


So to achieve this search condition, we can make relation table join itself to select max(id) to use it, and after laravel8, there's a more convenient function called [latestOfMany](https://laravel.com/api/9.x/Illuminate/Database/Eloquent/Relations/Concerns/CanBeOneOfMany.html#method_latestOfMany), which make you don't need to write join yourself.

### Efficient

If you dump the sql how it works, you will realize this solution could be slow when data size is huge, so maybe we can try other solution like modify db schema to store last record id in the main table, although there's lots of things need to consider.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## Eloquent 關聯中的最後一個

在某些情況下，我們需要搜索“只有最後一個記錄”的關聯，例如，我想搜索每位最後一筆訂單價格大於1000元的客戶。

如果我們像這樣搜索：

```php
Member::whereHas('lastOrder', function ($query) {
    $query->where('money', '>', 1000);
})


function lastOrder() {
    return $this->hasOne(Order::class)->orderByDesc('id');
}
```

帶有條件的關聯會告訴sql去搜索`最後一筆訂單的價格大於1000`，這不是我們想要的。

因此，為了實現這個搜索條件，我們可以讓關聯表自己加入自己以選擇最大(id)來使用它，並且在laravel8之後，有一個更方便的功能叫做[latesetOfMany](https://laravel.com/api/9.x/Illuminate/Database/Eloquent/Relations/Concerns/CanBeOneOfMany.html#method_latestOfMany)，這使您不需要自己編寫連接。

### 效率

如果您dump出它的sql如何工作，您會意識到這個解決方案在數據量巨大時可能會很慢，因此也許我們可以嘗試其他解決方案，例如修改db架構以在主表中存儲最後一筆記錄的id，雖然有很多事情需要考慮。