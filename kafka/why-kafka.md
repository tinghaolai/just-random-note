<!--HugoNoteFlag-->

---

## Why Kafka

### Before message queue

* Polling
  * waste - ask if new mission every time (even if no new mission)

### Why message queue

Kafka is kind of message queue, so that's first discuss why using mq.

* persistence / reliability / transactional: prevent data loss
* performance / load balance

### Why kafka compare to other mq

* Performance
  * TPS (Transaction per Second) is high
    *  kafka: million
    *  Rocket MQ: 100k
    *  Active MQ: 10k
  * Zero copy


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 為什麼使用Kafka

### 在討論訊息佇列之前

* 輪詢
  * 浪費 - 每次都詢問是否有新任務（即使沒有新任務）

### 為什麼要使用訊息佇列

Kafka是一種訊息佇列，所以我們首先討論為何使用訊息佇列。

* 永久性 / 可靠性 / 交易：防止資料遺失
* 效能 / 負載平衡

### 為什麼將Kafka與其他訊息佇列進行比較

* 效能
  * TPS（每秒交易數）很高
    * Kafka：百萬
    * Rocket MQ：10萬
    * Active MQ：1萬
  * 零拷貝