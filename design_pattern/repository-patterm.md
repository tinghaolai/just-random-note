## Repository Pattern

We have to a model to fetch secret data.

```php
<?php

namespace App\Models;

class SecretModel
{
    public function find($id)
    {
        return [
            'id'      => $id,
            'title'   => 'my_secret',
            'content' => 'testName',
            'own'     => 'secret_owner',
        ];
    }
}

```

And we use a service to get user secret from model.

```php

<?php

namespace App\Services;

use App\Models\SecretModel;
use Illuminate\Support\Facades\Log;

class SecretService
{
    public function getSecret($id, $userType)
    {
        return (new SecretModel())->find($id);
    }
}
```


If there's three types of user which could be paid user, normal user and guest user.

* Normal user and guest user can't get secret content.
* Have to log event if a guest want a secret

We can modify the function like this.


```php
    public function getSecret($id, $userType)
    {
        $secret = (new SecretModel())->find($id);
        if ($userType === 'guest' || $userType === 'normal') {
            $secret['content'] = '***';
        }

        if ($userType === 'guest') {
            Log::info('guest want secret' . $id);
        }

        return $secret;
    }
```

There's two problem with this code
* Hard to maintain if logic being more and more complex.
* Not just getting user data, have to read code to know what will happen.

So maybe I can try this way.

```php
    public function getSecret($id, $hideSensitive, $logEvent)
    {
        $secret = (new SecretModel())->find($id);
        if ($hideSensitive) {
            $secret['content'] = '***';
        }

        if ($logEvent) {
            Log::info('guest want secret' . $id);
        }

        return $secret;
    }

    public function guestGetSecret($id)
    {
        return $this->getSecret($id, true, true);
    }
```

* I can know what happen through parameter naming, but still hard to read, especially if this function getting bigger like 50 parameters.
* This function still doing more things than only getting secret.

Let split the condition logic to user type functions.

```php
<?php

namespace App\Services;

use App\Models\SecretModel;
use Illuminate\Support\Facades\Log;

class SecretService
{
    public function getSecret($id)
    {
        return (new SecretModel())->find($id);
    }

    public function convertSensitive($secret)
    {
        $secret['content'] = '***';

        return $secret;
    }

    public function logEvent($id, $userType)
    {
        Log::info($userType . ' want secret ' . $id);
    }

    public function paidUserGetSecret($id)
    {
        return $this->getSecret($id);
    }

    public function normalUserGetSecret($id)
    {
        $secret = $this->getSecret($id);

        return $this->convertSensitive($secret);
    }

    public function guestGetSecret($id)
    {
        $this->logEvent($id, 'guest');
        $secret = $this->getSecret($id);

        return $this->convertSensitive($secret);
    }
}
```
 
 In this way, I can easily know in what case, what things will be executed.
 
 The difference of these functions
 * condition logic (business logic) - to know what to do
    * `paidUserGetSecret`, `normalUserGetSecret`, `guestGetSecret`
 * repository - what code actually does
    * others

Sure, I can mix repository and business logic together, but I think like way of coding style is more easier to maintain.

Final step 
* Split functions to be repository class and service class
* Implement interface make repository replaceable (functions be used in service)
* Reduce dependency
    * Code in repository, e.g, SecretModel
    * Create repository
    
```php
    public function register()
    {
        $this->app->bind(SecretInterface::class, function($app)
        {
            return new SecretRepository(new SecretModel());
        });
    }
```


## Wrong Example

This is a service function using repository, but in a wrong way.

```php
public function index($memberId, $perPage)
{
        $collectionCondition = $this->feeRepository->subjectCondition('allArrangeDeposit');
        $fee = $this->feeRepository->depositQuery()
            ->validDeposit()
            ->search([
                'memberId' => $memberId,
            ])
            ->search($collectionCondition);

        $fees = $this->paymentRepository->depositQuery()
                    ->search($this->paymentRepository->searchCondition('arrangeDeposit'))
                    ->search([
                        'memberId' => $memberId,
                    ])
                    ->unionAll($fee)
                    ->where('member_id', $memberId)
                    ->orderByDesc('created_at')
                    ->paginate($perPage);

        $fees->getCollection()->transform(function ($fee) {
            $repository = ($fee->unionType === 'payment') ? $this->paymentRepository : $this->feeRepository;
            return $repository->convertApiFormat($fee);
        });

        return $fees;
}
```

#### Dependency problem

```php
        $fee = $this->feeRepository->depositQuery() // Get query builder
            ->validDeposit()                 // call model function (scope) in service
```


* You don't know what function can use in this model through repository interface
* Model have dependency with this repository, once switch repository, the repository have to return the object have same function

> Solution - `depositQuery()` return self, store model in self instance, call `validDeposit()` to manipulate model

#### Not splitting business logic

```php
    ->validDeposit()
```

* I know what it means, but I don't know what it does
* How to I determine a deposit is valid
* How do I change if valid deposit determine is changed?

Solution

```php

//Service function
public function validDeposit()
{
// maybe get a search condition, callback function, or perhaps best way is search the model in repository 
    return $this->feeRepository->successStatus();
}

```

> Business logic as a function, all this do is just search `where('status', 'success')`, but it's important to concentrate the business logic to a function, so the function name is the business logic, and have to know  what actually do in this logic, in this case, it's search success status, but service call repository don't need to know how to write code, just calling.


#### Also not splitting business logic
```php
    return $repository->convertApiFormat($fee);
```

* A repository should't know what api format is

Solution
* `convertApiFormat()` should be service function
* Write `convertFullInfo()` or `getPayerName()` functions, and service call these functions to combine api info.


