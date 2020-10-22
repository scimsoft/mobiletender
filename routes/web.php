<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\Route;

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

Route::get('/order/category/{id}',[OrderController::class, 'showProductsFromCategory']);

Route::get('/order/{id?}', [OrderController::class, 'order']);
Route::get('/order/addproduct/{id}',[OrderController::class,'addProduct']);


Route::get('/dbimage/{id}',[ProductImageController::class, 'getImage']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
