## Cache penetration

Code: find item by id,
if item not found in cache, 
find it in database.

But what if the item not exist in database?
And the attacker keep sending request with fake id,
and the request will always go to database.

Finally, the database will be down.

### Solution

* Cache empty value
* IP blacklist
* Parameter verification
* Bloom Filter - todo

