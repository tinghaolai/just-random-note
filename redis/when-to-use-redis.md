## When to use redis

* Normal cache - set / get
* Distributed Lock - set key, EX seconds, NX, XX
* Same Session store when multiple servers
* Counter/rate limit - INCRBY
* Bit operation - SETBIT, GETBIT, BITCOUNT, BITOP(AND, OR, XOR, NOT)
* queue - LPUSH, RPUSH, LPOP, RPOP, LLEN, LRANGE
* random - SRANDMEMBER / SPOP
* like/dislike - SADD, SREM, SISMEMBER, SCARD
* ranking - ZINCRYBY, ZADD, ZREM, ZSCORE, ZRANGE, ZREVRANGE, ZRANK, ZREVRANK