## Hotspot Invalid

Let is the item with cache,
and its popular,
lots of request to it.

Suddenly, the cache of this item is expired,
and all request go to database.

This will cause database down.

### Solution

* Distributed Lock - only one request can fetch data from database,
and write data to cache, after that, other request can read data from cache.