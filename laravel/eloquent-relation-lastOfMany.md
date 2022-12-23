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
