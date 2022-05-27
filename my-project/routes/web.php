<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\screenshot;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::controller(screenshot::class)->group(function(){
    $prefix = "/screenshot";
    Route::get($prefix, "index")->name('screenshot.list');
    Route::post($prefix, "index")->name('screenshot.capture');
});
