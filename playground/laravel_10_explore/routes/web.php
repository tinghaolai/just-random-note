<?php

use App\Enums\Category;
use App\Exceptions\ErrorRenderViewException;
use App\Exceptions\ErrorRenderViewSelfRegisterException;
use App\Exceptions\TestException;
use App\Exceptions\TestIgnoreException;
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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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

Route::get('/test15-1', function () {
    $session = 'test15' . rand(1, 1000);
    Session::put('test15', $session);
    return 'test15, set session: ' . $session;
});

Route::get('/test15-2', function () {
    $ssoSession = Session::get('test15-sso');
    return 'test15, get session: ' . Session::get('test15') . ' | sso session: ' . $ssoSession;
});

Route::get('/test15-3', function () {
    $ssoSession = Session::get('test15-sso');
    return 'test15, get session: ' . Session::get('test15') . ' | sso session: ' . $ssoSession;
});

Route::get('/test15/ssoCallback', function () {
    $ssoToken = request()->get('token');
    Session::put('test15-sso', $ssoToken);
    return redirect('/abc');
});

// Client: http://127.0.0.1:8000, sso server: http://localhost:8000]
Route::get('/sso/test15', function () {
    $ssoToken = 'test15-sso from sso server' . rand(1, 1000);
    return redirect('http://127.0.0.1:8000/test15/ssoCallback?token=' . $ssoToken);
});

Route::resource('items', ItemController::class);

Route::get('/test16', function () {
    $pathToFile = public_path('test16.jpg');

    return response()->file($pathToFile);
})->name('test16');

// now this api can only be accessed by signed url
// also have `temporarySignedRoute`
Route::get('/test17/equips/{equipID}', function (Equip $equip) {
    return 'test17 response, id: ' . $equip->id . ' | name: ' . $equip->name;
})->name('test17')->middleware('signed');

Route::get('/test17-2', function () {
    return URL::signedRoute('test17', ['equipID' => 1]);
});

Route::get('/test18', function () {
//    check laravel.log and Exceptions/Handler.php
    throw new \Exception('test18 exception');
});


Route::get('/test18-2', function () {
    try {
        throw new \Exception('test18-2 exception');
    } catch (\Exception $e) {
        report($e);
        Log::error($e->getMessage());
    }

    return 'test18-2';
});

Route::get('/test18-3', function () {
//    in laravel.log
//    [2023-07-30 06:28:36] local.CRITICAL: test18-3 exception {"test18-3":"additional context","exception":"[object] (App\\Exceptions\\TestException(code: 0): test18-3 exception at /app/routes/web.php:184)
    try {
        throw new TestException('test18-3 exception');
    } catch (\Exception $e) {
        report($e);
        Log::error($e->getMessage());
    }

    return 'test18-3';
});

Route::get('/test18-4', function () {
    try {
        throw new TestIgnoreException('test18-4 exception');
    } catch (\Exception $e) {
//        won't be logged
        report($e);
        Log::error($e->getMessage());
    }

    return 'test18-4';
});

Route::get('/test19', function () {
    throw new ErrorRenderViewException('test19 exception');
});

Route::get('/test20', function () {
    throw new ErrorRenderViewSelfRegisterException('test20 exception');
});

Route::fallback(function () {
    return 'test12, fallback';
});
