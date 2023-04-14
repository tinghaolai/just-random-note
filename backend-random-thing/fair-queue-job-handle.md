<!--HugoNoteFlag-->

---


### Queue jobs

Let's say one kind of job, 

that may very time-consuming, 

depend on that specific job,

so we can put it into a queue, 

and handle it later.

### Worker handle jobs

Worker will handle the jobs in the queue,

that's say we have three worker,

and one member calling 100 jobs that are time-consuming,

then other member calling jobs,

even the job is small, 

won't take much time,

but still need to wait for the first 100 jobs finished.

## Fair job handle

Split the jobs into small pieces,

and put them into the queue again.

So in this case,

the other member's job only need to wait for little slice job of the first 100 jobs.

We can improve the mechanism by many ways,

depends on your system,

but any this is the core concept.

---

<!--HugoNoteZhFlag-->


### 佇列任務 (Translated by ChatGTP)

假設有一種耗時的任務，

依賴於該特定的任務，

我們可以將它放入佇列中，

稍後再處理。

### 工作處理程序

工作處理程序將處理佇列中的任務，

假設有三個工作處理程序，

一個成員呼叫了 100 個耗時的任務，

然後其他成員呼叫任務，

即使工作量較小，

也需要等待前 100 個任務完成。

### 公平的任務處理

將任務拆分成小塊，

然後再次將它們放入佇列中。

因此，在這種情況下，

其他成員的任務只需等待前 100 個任務的一小部分。

我們可以通過多種方式改進機制，

取決於您的系統，

但這是核心概念。 