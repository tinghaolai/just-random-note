## Mysql data fetching approaches

For real sql execution, see note "Compare data fetching result".

## Normal fetch (without join, condition)

Normally, there's three ways to get table data.

* Select whole table once
  * Not suitable when data amount is huge.
* Chunk data by limit and offset
  * Would be slow when offset is big, because mysql need to calculate offsete position.
  * Usually used in pagination
* Chunk by primary key range
  * Fast to range the chunk data due to key.
  * Can't know chunk size

## Complex condition search and fast condition search

When search query is slow and match data amount is big, it could be very slow to fetch all data by chunk.

> Maybe use "EXPLAIN" to see the query can know why it's slow, because it use primary index, then mysql have to calculate each row if match the conditions. 

### Temporary table

One way prevent using "primary key" index is that create a temporary table to store whole condition result, and then fetch result from temp table.

But this solution only works on specific condition, if data amount is not big enough, or query is actually fast, then temporary table approach could slower thank normal chunk fethcing.