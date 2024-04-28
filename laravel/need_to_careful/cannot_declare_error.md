## Problem

The command I run: `docker exec -t kkday-b2b-api-laravel.test-1 ./vendor/bin/phpunit tests/Feature/Http/Controllers/Product/ProductSyncControllerTest.php --coverage-html coverage-report`

The error: `Generating code coverage report in HTML format ... PHP Fatal error:  Cannot declare class App\Http\Controllers\Api\v1\Product\ProductSyncController, because the name is already in use in /var/www/html/app/Http/Controllers/Api/v1/Product/ProductSyncController.php on line 50`


## What I have tried

* clear the cache
* simplify the test file and controller file only something like `echo 'hello';` and `$this->assertTrue(true);`
* search any file might has same class name
  * use `grep -r 'ProductSyncController' .` in the project root directory
* echo include files from `CodeCoverage.php`
    ```php
    foreach ($uncoveredFiles as $uncoveredFile) {
        if ($this->filter->isFile($uncoveredFile)) {
            if ($uncoveredFile === '/var/www/html/app/Http/Controllers/Api/v1/Product/ProductSyncController.php') {
                echo 'continue' . PHP_EOL;
    //                    continue;
            }
            echo $uncoveredFile . PHP_EOL;
    
            include_once $uncoveredFile;
        }
    }
    ```

But there's no any file has same class name,
just the `ProductSyncController.php` file.

## Strangeness

But if I change file name to `ProductSyncController1.php` or change any namespace, 
it won't have this error.

## Reason

The real reason is in `routes/api.php` file

```php
    Route::group(['namespace' => 'product', 'prefix' => 'product'], static function () {
        Route::post('/sync/{supplierOid}', 'ProductSyncController')
            ->where('supplierOid', '[0-9]+')
            ->name('product.sync');
    });
```

Its namespace is `product`, but the controller file is in `Api\v1\Product` namespace,
fix it to `Product` will solve this problem.

```php
    Route::group(['namespace' => 'Product', 'prefix' => 'product'], static function () {
        Route::post('/sync/{supplierOid}', 'ProductSyncController')
            ->where('supplierOid', '[0-9]+')
            ->name('product.sync');
    });
```
