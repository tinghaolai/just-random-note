## JWT

### Compare to session

> Shorter answer: compare to access database or redis, using algorithm to validate token is faster and more secure.

### Asked from chatGPT

Q: I remember that Laravel stores session data in a database. Is this a traditional session mechanism? What are the advantages of JWT compared to traditional session mechanism like this?

A: Yes, in Laravel, session data is usually stored in a database, and each time a request is made, the server needs to query the session record in the database to confirm the user's identity. In contrast, JWT uses encryption algorithms to verify the authenticity of the token, avoiding the need to query the database and improving the performance of the server.

In addition, Laravel's session mechanism has some security issues, such as Session Fixation and Session Hijacking, which require special handling to ensure security. JWT, on the other hand, ensures the authenticity and integrity of the token through encryption algorithms, which is more secure and reliable.

Overall, the advantages of JWT are reducing server overhead, improving performance, and being more secure and reliable, and it is not easily attacked. The traditional session mechanism needs to query the database for record, has lower performance, and has some security issues, which require special handling.