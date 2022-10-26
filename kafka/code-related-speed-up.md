## Kafka code speed up (code related)

### Multiple payload transition

Sometimes you need to send lots of data to kafka, but latency of kafka payload sending would slow down the process.

Solution is that you can set multiple payload into one to kafka, and consumer parse this multiple type payload into several payloads, then you can handle these payloads with loop, in loop, handle each payload as same as origin logic.

### Multiple payload handle

Cache the payloads until count match limit or cache time limit, and handle all these payload at the same time.

Simple example: A payload will insert one row to database, if collect until 500 payloads, and bulk insert 500 rows into database, which will must faster other than insert row one by one.

Not conflict with solution above, can use simultaneously.