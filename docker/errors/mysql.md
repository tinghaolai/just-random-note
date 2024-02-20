## Laravel error

case 1: 

`Doctrine\DBAL\Driver\PDO\Exception::("SQLSTATE[HY000] [2054] The server requested authentication method unknown to the client")`

solution: 

with root or account has permission: 
`ALTER USER 'dave'@'%' IDENTIFIED WITH mysql_native_password BY 'password';`
