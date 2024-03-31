## Error

Cannot declare class because the name is already in use in ....

## Solution

add 

```php
/**
 * @runInSeparateProcess
 * @preserveGlobalState disabled
 */
 public function testSomething()
 {
     // test code
 }

```
