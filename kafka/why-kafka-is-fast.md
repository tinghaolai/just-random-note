## Log system optimize

### Segment
Partition is composed of segment.

Pros
* Can delete segment directly instead of delete one by one.

## Indexes

### Index - log file
Segment is composed of .log(data) and .index(index).
Use index to locate data quickly.
Part of index will be put in memory to speed up.

### Index - timestamp
Search by timestamp to get relativeOffset index.

### Index - offset
Search by offset to get relativeOffset index.

When consumer read data, it will use offset to get relativeOffset index.
Then use relativeOffset index to get data.

## What is fast about kafka

Answer: throughout - transfer large amount data from producer to consumer.

## Why throughput is high

**Storage**

Data store in kafka is sequential, 
so it can use sequential read to get data,
which is faster than random read. (track seek)

**Zero copy**

Without zero copy, 
how to transfer data from log to consumer?

* disk 
* operating system(OS buffer) 
* kafka application 
* socket buffer
* network (NIC buffer)

With zero copy,

DMA (direct memory access) - transfer data from OS buffer directly to NIC buffer.

* disk
* operating system(OS buffer)
* network (NIC buffer)
