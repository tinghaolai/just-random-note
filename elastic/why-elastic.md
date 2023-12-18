# Why Elastic

Let's say we're using MySQL as our database,
and we have a very complex Business Logic to search data from database.

## Relational Database

### Join
So what can we do,
we join tables cross multiple tables,
but the performance is bad.

scenario to use join is `Small table driving big table`,
but when data is huge,
join will cause performance issue.

### Sub query

When using sub query,
MYSQL need to create temporary table,
delete temporary table after query,
so the speed is effected.

## Elasticsearch

Relational database is to store data and index it,
but Elasticsearch is an engine that index data and store it.

### Long story short
Elasticsearch is fast for searching.

### Searching columns

**MySql**

When we want to search data from multiple columns,
Instead of join in MySQL,
what if we put all data in one table,
then we can search data from that table.

If our Business Logic is super complex,
need to search data from multiple columns,
such as 20 columns,
in MySQL,
we need to design complex index to optimize performance,
it's hard to maintain.


**Elasticsearch**

Elasticsearch is designed for searching,
so it's easy and fast to search data from multiple columns,
and it's automatically mapping data to index,
so it's easy to maintain.
