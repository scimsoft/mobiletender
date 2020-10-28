<?php

use App\Http\Controllers\BasketController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductImageController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [OrderController::class, 'order']);
Route::get('/basket/',[OrderController::class, 'showBasket'])->name('basket');
Route::get('/order/', [OrderController::class, 'order'])->name('order');
Route::get('/order/category/{id}',[OrderController::class, 'showProductsFromCategory']);
Route::get('/order/addproduct/{id}',[OrderController::class,'addProduct']);
Route::get('/order/cancelproduct/{id}',[OrderController::class,'cancelProduct']);


Route::get('/checkout/',[CheckOutController::class,'checkout']);
Route::get('/checkout/confirmForTable/{id}',[CheckOutController::class,'confirmForTable']);
Route::get('/checkout/printOrder/{id}',[CheckOutController::class,'printOrder']);



Route::get('/dbimage/{id}',[ProductImageController::class, 'getImage']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

