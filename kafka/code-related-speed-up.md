<!--HugoNoteFlag-->

---

## Kafka code speed up (code related)

### Multiple payload transition

Sometimes you need to send lots of data to kafka, but latency of kafka payload sending would slow down the process.

Solution is that you can set multiple payload into one to kafka, and consumer parse this multiple type payload into several payloads, then you can handle these payloads with loop, in loop, handle each payload as same as origin logic.

### Multiple payload handle

Cache the payloads until count match limit or cache time limit, and handle all these payload at the same time.

Simple example: A payload will insert one row to database, if collect until 500 payloads, and bulk insert 500 rows into database, which will must faster other than insert row one by one.

Not conflict with solution above, can use simultaneously.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## Kafka 代碼加速 (代碼相關)

### 多種有效載荷轉換

有時候你需要將大量數據發送到 Kafka，但是 Kafka 載荷發送的延遲會減慢整個過程的進度。

解決方法是可以將多個有效載荷設置為單一載荷發送到 Kafka，消費者解析這多種類型的載荷並拆分成多個載荷，接著你可以使用循環處理這些載荷，在循環中，處理每個載荷與原邏輯相同。

### 多個有效載荷處理

將載荷緩存直到數量匹配限制或緩存時間限制，並一次處理所有這些有效載荷。

簡單的例子：一個有效載荷將插入一行到數據庫中，如果收集到 500 個有效載荷，則批量插入 500 行到數據庫中，這肯定比逐個插入行更快。

不與上面的解決方法衝突，可以同時使用。