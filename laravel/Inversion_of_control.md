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
