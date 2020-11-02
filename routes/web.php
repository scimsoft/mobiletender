<?php


use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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
Auth::routes();
Route::get('/', [OrderController::class, 'order']);
Route::get('/basket/',[OrderController::class, 'showBasket'])->name('basket');

Route::get('/order/table/{id}',[OrderController::class,'orderForTableNr']);
Route::get('/order/', [OrderController::class, 'order'])->name('order');
Route::get('/order/category/{id}',[OrderController::class, 'showProductsFromCategory']);
Route::get('/order/addproduct/{id}',[OrderController::class,'addProduct']);
Route::get('/order/cancelproduct/{id}',[OrderController::class,'cancelProduct']);

Route::post('/order/addAddonProduct',[OrderController::class,'addAddOnProduct']);


Route::get('/checkout/',[CheckOutController::class,'checkout']);
Route::get('/checkout/confirmForTable/{id}',[CheckOutController::class,'confirmForTable']);
Route::get('/checkout/printOrder/{id}',[CheckOutController::class,'printOrder']);


Route::resource('/products', ProductController::class)->middleware('is_admin');;
Route::get('/products/index/{id?}',[ProductController::class,'index'])->middleware('is_admin');;
Route::get('/crop-image/{id}', [ProductController::class,'editImage'])->middleware('is_admin');;
Route::post('crop-image', [ProductController::class,'imageCrop'])->middleware('is_admin');;
Route::post('/products/catalog',[ProductController::class,'toggleCatalog'])->middleware('is_admin');;

Route::post('/addOnProduct/add',[ProductController::class,'addOnProductAdd'])->middleware('is_admin');;
Route::post('/addOnProduct/remove',[ProductController::class,'removeAddOnProductAdd'])->middleware('is_admin');;

Route::get('/dbimage/{id}',[ProductImageController::class, 'getImage']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

