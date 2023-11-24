## Eloquent chunk

If you want to double modify table through `chunk`.

Let's say find any `members` whose location is `null`

```php

Member::whereNull('location')
    ->chunk(100, function ($members) {
        foreach ($members as $member) {
            // some business logic
            $location = convertLocation($member);
            $member->update(['location' => $location]);
        }
    });

```

What problem will cause? The offset of chunk will be modified!

Let's say chunk number is 100, we have 500 rows with null location.

1. first query offset 0, fetch 1~100
2. we modify member's location not to be null
3. second query 100, fetch 100~200
4. but for DB, there's 100 null location rows dispersed, so for the original's 500 rows,
where actually fetching 200~300 rows.
5. so after the query down, you can see there's still `null` location rows

Solution: `chunkById`