## Dynamic tables (Laravel 5.8)

Lets say we have table like this

* org_1_members
* org_2_members
* org_3_members
* org_1_purchases
* org_2_purchases
* org_3_purchases

And structure of `org_1_members, org_2_members, org_3_members` and `org_1_purchases, org_2_purchases, org_3_purchases` are the sames.

### Problem

If we want the model code to be reusable, we have to dynamically change table name when fetching data, but laravel 5.8 not support dynamic table table.

Maybe we can try extend class which has duplicate logic in this model, but we have to create a new model when there's a new organization, so this is a bad idea especially organization is also dynamic.


## Simple solution

There's a function `getTable()` in `Illuminate\Database\Eloquent\Model`, which get table name when using eloquent builder.

What we can do is override this function to get current use related organization table.

```php
public function getTable()
{
    return 'org_' . config('database.connections.mysql.orgId') . '_members';
}
```

* Dynamic change `orgId` from use login info
* override function  in your model


> This solution works also for eloquent relations, need to write similar function in relation models 


### Not perfect

This solution is not perfect if I want to get `org_1_members` with relation `org_2_purchases`, maybe this use case will be never happen, but what if I have tables like this.

* org_1_members
* org_1_members_purchase_type_a
* org_1_members_purchase_type_a

The type in there is also dynamic, may be this case makes more sense, so u can image there will be 2 problems.

* Have to change config when ever before using it.
    * Also no warning if forget reset config, will fetching wrong data
* The model can only connect to one table at the same time.

### Other solution

Change static table from table, works but still have the problems mention above.





