<?php

use App\Facades\BindFacade;
use App\Http\Controllers\ContextualBindingAController;
use App\Http\Controllers\ContextualBindingBController;
use App\Services\BindExtendService;
use App\Services\BindService;
use App\Services\TestZeroConfiguration;
use Facades\App\Services\BindService as DynamicBindFacadeService;
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
    return view('welcome');
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
    die('dynamic facade: ' . DynamicBindFacadeService::get());
});

Route::get('/test7', function () {
    die('facade: ' . BindFacade::get());
});
