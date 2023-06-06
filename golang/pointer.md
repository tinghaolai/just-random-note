<!--HugoNoteFlag-->

---

## Pointer

```go
package main

import (
	"jd_workout_golang/app/models"
	"jd_workout_golang/lib/database"
	db "jd_workout_golang/lib/database"
	"jd_workout_golang/lib/file"
	"jd_workout_golang/lib/redis"
)

func init() {
	file.LoadConfigAndEnv()
	database.InitDatabase()
	redis.InitRedis()

}

func main() {
	println("test go")
	var user models.User
	db.Connection.Where("id = ?", 1).Last(&user)
	println(user.Username)
	userToBeLastUser(&user)
	println(user.Username)
}

// both in/out function, can't print out id = 2
func userToBeLastUser_v1(user *models.User) {
	db.Connection.Where("id = ?", 2).Last(&user)
	println("in function,  user name is " + user.Username)
}

// can only print out id = 2 in function
func userToBeLastUser_v2(user *models.User) {
	var newUser models.User
	db.Connection.Where("id = ?", 2).Last(&newUser)
	user = &newUser
	println("in function,  user name is " + user.Username)
}

// can print out id = 2 in/out function
func userToBeLastUser(user *models.User) {
	var newUser models.User
	db.Connection.Where("id = ?", 2).Last(&newUser)
	*user = newUser
	println("In function, user name is " + (*user).Username)
}
```



---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 指針

```go
package main

import (
    "jd_workout_golang/app/models"
    "jd_workout_golang/lib/database"
    db "jd_workout_golang/lib/database"
    "jd_workout_golang/lib/file"
    "jd_workout_golang/lib/redis"
)

func init() {
    file.LoadConfigAndEnv()
    database.InitDatabase()
    redis.InitRedis()

}

func main() {
    println("測試 go")
    var user models.User
    db.Connection.Where("id = ?", 1).Last(&user)
    println(user.Username)
    userToBeLastUser(&user)
    println(user.Username)
}

// 這個方法不管哪個地方, 都print 不出 id = 2
func userToBeLastUser_v1(user *models.User) {
    db.Connection.Where("id = ?", 2).Last(&user)
    println("在函數內, 用戶姓名是 " + user.Username)
}

// 這方法, 只能讓 function 內的 function print 出 id = 2
func userToBeLastUser_v2(user *models.User) {
    var newUser models.User
    db.Connection.Where("id = ?", 2).Last(&newUser)
    user = &newUser
    println("在函數內, 用戶姓名是 " + user.Username)
}

// 這方法, 可以讓 function 內外都 print 出 id = 2
func userToBeLastUser(user *models.User) {
    var newUser models.User
    db.Connection.Where("id = ?", 2).Last(&newUser)
    *user = newUser
    println("在函數內, 用戶姓名是 " + (*user).Username)
}
```