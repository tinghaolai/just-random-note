<?php

use App\Services\BindService;
use App\Services\TestZeroConfiguration;
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
