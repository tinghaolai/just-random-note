<!--HugoNoteFlag-->

---

## Add php interface functions parameter

Let's say you have 100 class to extend one same interface, and somehow a function of one class need to a new parameter to implement the function.

It could be a painful thing to modify the interface function and then put parameter to the function that every class extend this interface.

Here's one way you don't need to do so, simply add `$parameter=null` to the function, but in this way, it will lose the meaning of interface, user don't know how to use this function just by interface function, and every class function may have different parameter meaning and parameter class type. 

So right now, my conclusion is that, just modify every class function.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 新增php接口函數參數

假設您有100個類別擴展同一個接口，某個類別的函數需要新增參數以實現該函數，這可能是一件很痛苦的事情，因為您需要修改接口函數並向每個類別擴展該接口的函數添加參數。

這裡有一種解決方法，您只需要在函數中添加 `$parameter=null` 參數即可，但是這樣做會失去接口的意義，使用者不知道如何僅通過接口函數使用此函數，每個類別函數的參數含義和參數類型可能不同。

因此，我的結論是，只需修改每個類別的函數。