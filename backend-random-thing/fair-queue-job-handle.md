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

## More thoughts

Other than this approach, 

which have only one machine,

there might be other better ways to handle this,

for example: horizontal scaling.

And what is the better way?

I think it depends on your system,

maybe it's totally not necessary to worry about in your system,

but can you handle it if it happens?



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

### 佇列作業

假設有一種作業，

可能非常耗時，

需要依靠特定作業，

因此我們可以將其放入佇列中，

稍後再處理。

### 工作者處理作業

工作者將處理佇列中的作業，

假設我們有三個工作者，

有一名成員呼叫100個耗時的作業，

然後其他成員呼叫作業，

即使該作業很小，

不需要花太多時間，

仍然需要等待前100個作業完成。

## 公平處理作業

將作業分為小塊，

再次放入佇列中。

所以在這種情況下，

其他成員的工作只需等待前100個作業的一小塊作業即可。

我們可以通過多種方式改善機制，

取決於您的系統，

但這是核心概念。

## 更多想法

除此方法外，

假如只有一台機器，

可能有其他更好的方法來處理這個問題，

例如：水平擴展。

什麼是更好的方法？

我認為這取決於您的系統，

也許在您的系統中完全不需要擔心，

但如果發生了，您能處理嗎？