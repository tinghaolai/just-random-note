<?php

use App\Enums\Category;
use App\Facades\BindFacade;
use App\Http\Controllers\ContextualBindingAController;
use App\Http\Controllers\ContextualBindingBController;
use App\Http\Controllers\ItemController;
use App\Models\Equip;
use App\Services\BindExtendService;
use App\Services\BindService;
use App\Services\TestZeroConfiguration;
use Facades\App\Services\BindService as DynamicBindFacadeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('test');
});

Route::get('/test1', function (TestZeroConfiguration $service) {
    die(get_class($service));
});

Route::get('/test2', function (BindService $service) {
    die($service->get());
});

Route::get('/test2-2', function (BindExtendService $service) {
    die($service->get());
});

Route::get('/test3-1', ContextualBindingAController::class);
Route::get('/test3-2', ContextualBindingBController::class);

Route::get('/test4', function (BindService $service) {
    $service->setValue('test4');
    die($service->get() . ' | ' . app()->call([$service, 'callSelf']));
});

Route::get('/test5', function () {
    app()->resolving(BindService::class, function (BindService $service) {
        $service->setValue('from test5');
    });

    $service = app()->make(BindService::class);

    die($service->get());
});

Route::get('/test6', function () {
// Class not found, but not file not committed, it's actually App\Services\BindService
    die('dynamic facade: ' . DynamicBindFacadeService::get());
});

Route::get('/test7', function () {
    die('facade: ' . BindFacade::get());
});

Route::get('/test8', function (Request $request) {
    if ($request->wantsJson()) {
        return response()->json(['message' => 'test8']);
    }

    return view('csrf');
});

Route::post('/test8', function () {
    return response()->json(['message' => 'test8 from web route']);
});

// RouteServiceProvider: Route::pattern('id', '[0-9]+');
Route::post('/test9/{id}', function ($id) {
    return response()->json(['message' => 'id: ' . $id]);
});

Route::get('/test10/{category}', function (Category $category) {
    return $category->value;
});

Route::post('/test11', function () {
    Equip::create(['name' => 'test11']);

    return 'success';
});

Route::get('/test11/{equip}', function (Equip $equip) {
    return 'id: ' . $equip->id . ' | name: ' . $equip->name;
});

Route::middleware('test:contextTest13')->get('/test13', function () {
    Log::info('test13 - in api handle');
    return 'test13';
});

// test in browser, remember do not use `Disable cache` in devtools
Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::get('/test14', function () {
        $random = rand(1, 1000);
        return 'test14 - random: ' . $random;
    });
});

Route::resource('items', ItemController::class);

Route::fallback(function () {
    return 'test12, fallback';
});
