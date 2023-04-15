<!--HugoNoteFlag-->

---


## Inversion Of Control

### Why

Reduce dependency, in my own experience, u'be fucked up when u need to change class bug it used in everywhere, such when model change or SMS service change.

### Laravel solution 

* Interface binding - Register container in service provider.
* `$app->make('name')`
* Dependency injection
    * Instance as parameter instead of init in class.

### Other solution but not recommended

* using constants
    * The reason this is bad I think it's becuz it still has dependency, can use only this value for this class.
* registered in construct
    * Have to change class code if need to modify, not good operate if this class to be a library, I guess.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 控制反轉

### 為什麼要使用

減少相依性。以我自己的經驗來說，當需要更改已被用在多處的類別時，很容易出問題。例如，當模型更改或是簡訊服務更改時。

### Laravel 解決方案

* 介面綁定 - 在服務提供者中註冊容器。
* `$app->make('name')`
* 依賴注入
    * 將實例作為參數傳入，而非在類別中初始化。

### 其他解決方案但不建議使用

* 使用常數
    * 我認為這種方式不好是因為它仍具有相依性，且此值只能用於此類別。
* 在建構函式中註冊
    * 如果需要修改，就必須更改類別程式碼，且如果這個類別是一個庫，那麼這種操作就不是很好。