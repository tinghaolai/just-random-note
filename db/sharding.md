# Sharding

## When to shard into multiple databases

To solve concurrency, due to the database connection limit.

For example, spilt data into

* Member database
* Order database
* Product database
* ...


## When to shard into multiple tables

To solve performance issue, due to the table size.