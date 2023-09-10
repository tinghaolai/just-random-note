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
