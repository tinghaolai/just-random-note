<!--HugoNoteFlag-->

---

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


### Final Solution

#### Implement auto table functionality

##### Migration

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ([1 ,2, 3] as $orgId) {
            $memberTable    = 'org_' . $orgId . '_members';
            $purchasesTable = 'org_' . $orgId . '_purchases';
            Schema::create($memberTable, function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
            });

            Schema::create($purchasesTable, function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('member_id');
                $table->string('product');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
            });

            \Illuminate\Support\Facades\DB::table($memberTable)->insert([
                'name' => 'org_' . $orgId . '_user_1',
            ]);

            \Illuminate\Support\Facades\DB::table($purchasesTable)->insert([
                'member_id' => 1,
                'product'   => 'org_' . $orgId . '_product_1',
            ]);

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_1_members');
        Schema::dropIfExists('org_2_members');
        Schema::dropIfExists('org_3_members');
        Schema::dropIfExists('org_1_purchases');
        Schema::dropIfExists('org_2_purchases');
        Schema::dropIfExists('org_3_purchases');
    }
}

```

##### Models

MemberModel

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\memberLogRecordModel
 *
 * @mixin \Eloquent
 */
class MemberModel extends Model
{
    protected $table = '';

    protected $fillable = [
        'name'
    ];

    public function getTable()
    {
        return 'org_' . config('database.connections.mysql.orgId') . '_members';
    }

    public function lastPurchase()
    {
        return $this->hasOne('App\Models\PurchaseModel', 'member_id', 'id')->orderByDesc('id');
    }
}

```

PurchaseModel

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\memberLogRecordModel
 *
 * @mixin \Eloquent
 */
class PurchaseModel extends Model
{
    protected $table = '';

    protected $fillable = [
        'member_id',
        'product',
    ];

    public function getTable()
    {
        return 'org_' . config('database.connections.mysql.orgId') . '_purchases';
    }
}

```

##### Run code

```php
    $orgId = 2;
//  change the config in middleware
    Config::set('database.connections.mysql.orgId', $orgId);

    $member = MemberModel::with(['lastPurchase'])->first();

    dd([
        'memberName: ' => $member->name,
        'lastProduct: ' => $member->lastPurchase->product,
    ]);

```

> Config setting should changed in middleware, model should use as usual.

Result 

```
^ array:2 [
  "memberName: " => "org_2_user_1"
  "lastProduct: " => "org_2_product_1"
]
```

#### Make code reusable

> Remove function getTable() in model, write in Trait instead.

DynamicTable

```php
<?php
namespace App\Traits;

use App\Helpers\TableNameHelper;

trait DynamicTable {
    public function getTable()
    {
        return TableNameHelper::modelDefaultTable(get_class($this));
    }

    public static function with($relations)
    {
        if (!is_string($relations)) {
            foreach ($relations as $relation => $value) {
                if (is_array($value) && isset($value['table'])) {
                    $relations[$relation] = function ($query) use ($value, $relation) {
                        if (isset($value['closure'])) {
                            $value['closure']($query);
                        }

                        $query->from($value['table'] . ' as ' . (new self())->$relation()->getRelated()->getTable());
                    };
                }
            }
        }

        return static::query()->with(
            is_string($relations) ? func_get_args() : $relations
        );
    }
}

```


MemberModel

```php
<?php

namespace App\Models;

use App\Traits\DynamicTable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\memberLogRecordModel
 *
 * @mixin \Eloquent
 */
class MemberModel extends Model
{
    use DynamicTable;

    protected $table = '';

    protected $fillable = [
        'name'
    ];

    public function lastPurchase()
    {
        return $this->hasOne('App\Models\PurchaseModel', 'member_id', 'id')->orderByDesc('id');
    }
}
```

PurchaseModel

```php
<?php

namespace App\Models;

use App\Traits\DynamicTable;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\memberLogRecordModel
 *
 * @mixin \Eloquent
 */
class PurchaseModel extends Model
{
    use DynamicTable;

    protected $table = '';

    protected $fillable = [
        'member_id',
        'product',
    ];
}
```

TableNameHelper

```php
<?php

namespace App\Helpers;

use App\Models\MemberModel;
use App\Models\PurchaseModel;

class TableNameHelper
{
    public static function memberTable($orgId = null)
    {
        if (is_null($orgId)) {
            $orgId = config('database.connections.mysql.orgId');
        }

        return 'org_' . $orgId . '_members';
    }

    public static function purchaseTable($orgId = null)
    {
        if (is_null($orgId)) {
            $orgId = config('database.connections.mysql.orgId');
        }

        return 'org_' . $orgId . '_purchases';
    }

    public static function modelDefaultTable($class)
    {
        switch ($class) {
            case MemberModel::class:
                return self::memberTable();
            case PurchaseModel::class:
                return self::purchaseTable();
        }

        return '';
    }
}
```



#### Code example

```php
    $orgId = 2;
//  change the config in middleware
    Config::set('database.connections.mysql.orgId', $orgId);

    $aMember = MemberModel::with(['lastPurchase'])->first();
    $bMember = MemberModel::with([
        'lastPurchase' => [
            'table' => TableNameHelper::purchaseTable(1),
        ]
    ])->from(TableNameHelper::memberTable(3))->first();
    $cMember = MemberModel::from(TableNameHelper::memberTable(3))->first();

    dd(
        [
            'a' => [
                [
                    'memberName: ' => $aMember->name,
                    'lastProduct: ' => $aMember->lastPurchase->product,
                ]
            ],
            'b' => [
                [
                    'memberName: ' => $bMember->name,
                    'lastProduct: ' => $bMember->lastPurchase->product,
                ]
            ],
            'c' => [
                [
                    'memberName: ' => $cMember->name,
                    'lastProduct: ' => $cMember->lastPurchase->product,
                ]
            ]
        ]
    );
```

Result

```php
^ array:3 [
  "a" => array:1 [
    0 => array:2 [
      "memberName: " => "org_2_user_1"
      "lastProduct: " => "org_2_product_1"
    ]
  ]
  "b" => array:1 [
    0 => array:2 [
      "memberName: " => "org_3_user_1"
      "lastProduct: " => "org_1_product_1"
    ]
  ]
  "c" => array:1 [
    0 => array:2 [
      "memberName: " => "org_3_user_1"
      "lastProduct: " => "org_2_product_1"
    ]
  ]
]

```


* A member data using default table name
* B member data specify different table name
* C member data test relation data without eager loading

> In trait `DynamicTable` override `with()` function, is because although calling `->from()` to dynamically change table name in relation closure, but due to relation query is call statically, the query table is called static, which get the default table name, not the same as our specify table name, this will cause query error. One way is to let our dynamic table has alias name as default table, but u have to remember every time u use `->from()`, so I let the function automatically handle this problem.


---

<!--HugoNoteZhFlag-->

# Translated by ChatGTP

## 動態表格（Laravel 5.8）

假設我們有以下這些表格：

* org_1_members
* org_2_members
* org_3_members
* org_1_purchases
* org_2_purchases
* org_3_purchases

而這些表格的結構都是相同的：`org_1_members`、`org_2_members`、`org_3_members`、`org_1_purchases`、`org_2_purchases`、`org_3_purchases`。

### 問題

如果我們要讓模型的代碼可以重複使用，就必須在獲取資料時動態更改表格名稱，但是 Laravel 5.8 不支援動態表格。

或許我們可以嘗試擴展擁有重複邏輯的類別，但是當有新組織時，我們就必須創建新的模型，這樣不是一個好辦法，尤其是組織也是動態的。

## 簡單的解決方案

在 `Illuminate\Database\Eloquent\Model` 中有一個 `getTable()` 函數，可以在使用 Eloquent 建構器時獲取表格名稱。

我們可以重寫這個函數來獲取當前使用相關組織表格。

```php
public function getTable()
{
    return 'org_' . config('database.connections.mysql.orgId') . '_members';
}
```

* 動態更改 `orgId` 以使用登入信息
* 在您的模型中覆蓋該函數

> 這個解決方案也適用於 Eloquent 關係，需要在相關模型中編寫類似的函數。

### 不完美之處

如果我想要獲取具有「org_2_purchases」關聯的「org_1_members」，那麼這個使用情況可能永遠不會發生，但是如果我的表格形式如下，會怎麼樣呢？

* org_1_members
* org_1_members_purchase_type_a
* org_1_members_purchase_type_a

其中的類型也是動態的，也許這種情況更有意義，因此可以想像出有 2 個問題。

* 必須在使用之前每次更改配置。
    * 忘記重置配置時也沒有警告，會獲取錯誤的資料。
* 模型同時只能連接到一個表格。

### 其他解決方案

改為從靜態表格改為動態表格，但仍然存在上面提到的問題。

### 最終解決方案

#### 實現自動表格功能

##### 遷移

```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ([1 ,2, 3] as $orgId) {
            $memberTable    = 'org_' . $orgId . '_members';
            $purchasesTable = 'org_' . $orgId . '_purchases';
            Schema::create($memberTable, function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
            });

            Schema::create($purchasesTable, function (Blueprint $table) {
                $table->increments('id');
                $table->unsignedInteger('member_id');
                $table->string('product');
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
            });

            \Illuminate\Support\Facades\DB::table($memberTable)->insert([
                'name' => 'org_' . $orgId . '_user_1',
            ]);

            \Illuminate\Support\Facades\DB::table($purchasesTable)->insert([
                'member_id' => 1,
                'product'   => 'org_' . $orgId . '_product_1',
            ]);

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('org_1_members');
        Schema::dropIfExists('org_2_members');
        Schema::dropIfExists('org_3_members');
        Schema::dropIfExists('org_1_purchases');
        Schema::dropIfExists('org_2_purchases');
        Schema::dropIfExists('org_3_purchases');
    }
}

```

##### 模型

MemberModel

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\memberLogRecordModel
 *
 * @mixin \Eloquent
 */
class MemberModel extends Model
{
    protected $table = '';

    protected $fillable = [
        'name'
    ];

    public function getTable()
    {
        return 'org_' . config('database.connections.mysql.orgId') . '_members';
    }

    public function lastPurchase()
    {
        return $this->hasOne('App\Models\PurchaseModel', 'member_id', 'id')->orderByDesc('id');
    }
}

```

PurchaseModel

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Model\memberLogRecordModel
 *
 * @mixin \Eloquent
 */
class PurchaseModel extends Model
{
    protected $table = '';

    protected $fillable = [
        'member_id',
        'product',
    ];

    public function getTable()
    {
        return 'org_' . config('database.connections.mysql.orgId') . '_purchases';
    }
}

```

##### 執行代碼

```php
    $orgId = 2;
//  在 middleware 中更改配置
    Config::set('database.connections.mysql.orgId', $orgId);

    $member = MemberModel::with(['lastPurchase'])->first();

    dd([
        'memberName: ' => $member->name,
        'lastProduct: ' => $member->lastPurchase->product,
    ]);

```

> 設置配置應在 middleware 中更改，模型應像往常一樣使用。

結果

```
^ array:2 [
  "memberName: " => "org_2_user_1"
  "lastProduct: " => "org_2_product_1"
]
```

#### 使代碼可重複使用

> 在 Trait 中刪除 `getTable()` 函