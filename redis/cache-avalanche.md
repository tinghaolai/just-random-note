## Cache avalanche

Lots of keys expire at the same time,
request couldn't find data in cache.

So request will go find data from database,
and there's a lot of requests like this.

A lots of request to database will cause database down,
and finally the service is down.

### Solution

* Cache key random expire time
* Cluster cache - put keys in different cache server

