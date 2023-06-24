<!--HugoNoteFlag-->

---

# Noun

CORS: Cross-Origin Resource Sharing

CSRF: Cross-Site Request Forgery

Same Origin Policy

front-end and back-end separation

## CORS
Even though browsers enforce the same-origin policy, 
preventing the sending of cookies across different domains, 
it is still possible for unintended actions to occur if the backend API does not have any checks in place. 
Therefore, it is necessary to check if the requests are from the same origin. 

In the case of a frontend-backend separation, 
if the host is on a different domain, 
the frontend domain needs to be included in the allow list.

## CSRF
Why do we still need CSRF tokens despite having CORS protection?
Firstly,

CORS only protects against cookie theft. 
If a browser does not support CORS, 
cookie theft can still occur.
Even with CORS protection on the backend, 
the source can be forged, including the referrer.
As mentioned earlier, if the backend does not check cookies, 
unintended actions can still occur and result in damage.

### How does CSRF token work?
The server sends a token to the client.
The client includes this token in the submitted form.
If the token is invalid, the server rejects the request.

### How does Laravel handle CSRF protection?
The CSRF token is rendered on the frontend page and then checked against the session on the backend.

### How can CSRF tokens be protected from being stolen?
It is generally not a major concern. 
If it is stolen, 
it is likely that not only the token but all information has been compromised.

### How to handle CSRF protection in a frontend-backend separation?
The backend encrypts the token and stores it on the frontend. 
When making a request, 
the token is sent back to the backend. 
Due to the browser's same-origin policy, 
the token should not be accessible even in the event of a CSRF attack. 

## Summarize:

If CSRF tokens are implemented, is CORS not necessary?

Although it is recommended to implement both for comprehensive defense, 
theoretically, yes. 
CSRF tokens verify the trusted source,
assuming that premise, CORS 
is not needed. However, CORS still has two risks:

The source can be forged.
Browsers that do not support CORS can still steal cookies.
The backend does not check cookies.
Conclusion:
With proper API design, normal browsers, and framework handling, there is little need to worry about this issue. 
However, for analysis purposes:

* CORS does not guarantee complete security.
* CSRF tokens do not guarantee complete security either, unless the user is using a very poor browser or has installed malicious plugins.
  * SSR token: Generally the most secure option.
  * Frontend-backend separation token: Secure depending on the browser.

---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

# 名詞

CORS: 跨源資源共享

CSRF: 跨站請求偽造

同源策略

前端和後端的分離

## CORS
儘管瀏覽器實施了同源策略，禁止在不同的域之間傳送cookies，但如果後端API沒有設置任何檢查，仍然可能發生意外的動作。因此，有必要檢查請求是否來自同一來源。

如果採用前端-後端分離的方式，且主機在不同的域上，前端域需要包含在允許列表中。

## CSRF
儘管有了CORS保護，為什麼我們仍需要使用CSRF令牌呢？

首先，CORS僅保護免於cookie被盜。如果瀏覽器不支持CORS，仍然可能發生cookie被盜的情況。即使後端具有CORS保護，源還是有可能被偽造，包括引用者。如前所述，如果後端不檢查cookie，還是可能發生意外的動作，造成損害。

### CSRF令牌如何工作？
服務器向客戶端發送令牌。
客戶端在提交的表單中包含此令牌。
如果令牌無效，服務器將拒絕請求。

### Laravel如何處理CSRF保護？
CSRF令牌在前端頁面上呈現，然後與後端的會話進行檢查。

### 如何保護CSRF令牌免於被盜？
這通常不是主要問題。如果被盜，很可能不僅令牌被盜，而所有信息都被泄漏。

### 如何處理前端-後端的CSRF保護？
後端加密令牌並將其存儲在前端。當發出請求時，令牌將被送回後端。由於瀏覽器的同源策略，即使發生CSRF攻擊，令牌也不應該被訪問。

## 總結:

如果實施了CSRF令牌，那麼CORS就不再需要了嗎？

儘管建議綜合使用兩者來進行防御，理論上是的。CSRF令牌驗證受信任的來源，假設這個前提成立，那麼就不需要CORS。但CORS還是存在兩個風險:

源可以被偽造。
不支持CORS的瀏覽器仍然可以盜取cookies。
後端不檢查cookie。
結論：

通過適當的API設計、正常的瀏覽器和框架處理，很少需要擔心這個問題。但是，出於分析目的:

* CORS不能保證完全的安全。
* CSRF令牌也不能保證完全的安全，除非用戶使用非常差的瀏覽器或安裝了惡意插件。
  * SSR令牌：通常是最安全的選擇。
  * 前端-後端分離令牌：根據瀏覽器的不同而安全。