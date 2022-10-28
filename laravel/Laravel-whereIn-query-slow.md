### Laravel whereIn query slow

This problem occurs when I use a simple query, which like

```php
$memberIds = $this->getMemberIds();
$members = MemberData::whereIn('member_id', $memberIds)->get();
```

Length of `$memberIds` array is `5000`，query will cost around 30 seconds,
but if I query in GUI(datagrip), it only takes in 1 second.

It's the problem of PDO.
https://bugs.php.net/bug.php?id=80027


### Solution

Using raw sql, but cuz of sql injection, better to use integer column.


