<!--HugoNoteFlag-->

---

## JWT

### Compare to session

> Shorter answer: compare to access database or redis, using algorithm to validate token is faster and more secure.

### Asked from chatGPT

Q: I remember that Laravel stores session data in a database. Is this a traditional session mechanism? What are the advantages of JWT compared to traditional session mechanism like this?

A: Yes, in Laravel, session data is usually stored in a database, and each time a request is made, the server needs to query the session record in the database to confirm the user's identity. In contrast, JWT uses encryption algorithms to verify the authenticity of the token, avoiding the need to query the database and improving the performance of the server.

In addition, Laravel's session mechanism has some security issues, such as Session Fixation and Session Hijacking, which require special handling to ensure security. JWT, on the other hand, ensures the authenticity and integrity of the token through encryption algorithms, which is more secure and reliable.

Overall, the advantages of JWT are reducing server overhead, improving performance, and being more secure and reliable, and it is not easily attacked. The traditional session mechanism needs to query the database for record, has lower performance, and has some security issues, which require special handling.

---

<!--HugoNoteZhFlag-->


## JWT (Translated by ChatGTP)

### 與 session 的比較

> 簡短的回答：與訪問數據庫或 redis 相比，使用算法驗證 token 更快更安全。

### ChatGPT 的問題

問：我記得在 Laravel 中，會將 session 數據存儲在數據庫中。這是一種傳統的 session 機制嗎？與傳統的 session 機制相比，JWT 的優點是什麼？

答：是的，在 Laravel 中，通常會將 session 數據存儲在數據庫中，每次發送請求時，服務器需要查詢數據庫中的 session 記錄以確認用戶的身份。相比之下，JWT 使用加密算法來驗證 token 的真實性，避免了需要查詢數據庫的情況，提高了服務器的性能。

此外，Laravel 的 session 機制存在一些安全問題，例如會話固定和會話劫持，需要進行特殊處理以確保安全。而 JWT 通過加密算法保證了 token 的真實性和完整性，更加安全可靠。

總體而言，JWT 的優點是減少了服務器的負擔，提高了性能，更加安全可靠，不易受到攻擊。傳統的 session 機制需要查詢數據庫記錄，性能較低，存在一些安全問題，需要進行特殊處理。