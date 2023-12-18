<!--HugoNoteFlag-->

---

## Why Kafka

### General purpose

Handle stream data.

### Before message queue

* Polling
  * waste - ask if new mission every time (even if no new mission)

### Why message queue

Kafka is kind of message queue, so that's first discuss why using mq.

* persistence / reliability / transactional: prevent data loss
* performance / load balance

### Why kafka compare to other mq (Result)

* Performance
  * TPS (Transaction per Second) is high
    *  kafka: million
    *  Rocket MQ: 100k
    *  Active MQ: 10k
  * Zero copy (will discuss in another note `why-kafka-is-fast.md`)

### Why kafka compare to other mq (Reason)

We can process data using queue,
but the problem is latency.
Kafka is faster than other mq when data is large.

From note: `how-kafka-works.md` and `why-kafka-is-fast.md`,
we can know kafka read data from log file by fast Polling.

But why queue can't do fast Polling in other mq?
Because other mq don't have optimization like kafka,
such as frequent request, lock mechanism, etc.
This could cause many performance and abnormal problems.

### Key difference between kafka and other mq

People thing message system should support complex message search function,
but kafka don't implement this function,
so kafka can
* Have faster performance
* Keep performance when message backlog is large

But in other hand, 
kafka sacrifice some function like message priority.

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 為什麼選擇 Kafka

### 通用性

處理流式數據。

### 在使用訊息佇列之前

* 輪詢
  * 浪費 - 每次都詢問是否有新的任務（即使沒有新任務）

### 為什麼選擇訊息佇列

Kafka 是一種訊息佇列，所以首先討論一下為什麼要使用訊息佇列。

* 持久性/可靠性/事務性：防止數據丟失
* 性能/負載平衡

### Kafka 與其他訊息佇列的比較（結果）

* 性能
  * 每秒交易數（TPS）較高
    * Kafka: 百萬
    * Rocket MQ: 十萬
    * Active MQ: 一萬
  * 零拷貝（在另一個文檔中討論：why-kafka-is-fast.md）

### Kafka 與其他訊息佇列的比較（原因）

我們可以使用佇列來處理數據，
但問題在於延遲。
當數據較大時，Kafka 比其他訊息佇列更快。

從文檔「how-kafka-works.md」和「why-kafka-is-fast.md」中，
我們可以知道 Kafka 通過快速輪詢從日誌文件讀取數據。

但為什麼其他訊息佇列無法進行快速輪詢呢？
因為其他訊息佇列沒有像 Kafka 一樣的優化功能，
例如頻繁請求、鎖定機制等。
這可能會導致許多性能和異常問題。

### Kafka 和其他訊息佇列的關鍵差異

人們認為訊息系統應該支持複雜的訊息搜索功能，
但 Kafka 不實現此功能，
因此 Kafka 可以
* 擁有更快的性能
* 在訊息積壓較大時保持性能

但另一方面，
Kafka 犧牲了一些功能，例如訊息優先級。