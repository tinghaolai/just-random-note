## Add php interface functions parameter

Let's say you have 100 class to extend one same interface, and somehow a function of one class need to a new parameter to implement the function.

It could be a painful thing to modify the interface function and then put parameter to the function that every class extend this interface.

Here's one way you don't need to do so, simply add `$parameter=null` to the function, but in this way, it will lose the meaning of interface, user don't know how to use this function just by interface function, and every class function may have different parameter meaning and parameter class type. 

So right now, my conclusion is that, just modify every class function.