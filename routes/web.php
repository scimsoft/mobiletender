<?php


use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\CheckOutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProductImageController;

use App\Http\Controllers\Web\WebController;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register Web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "Web" middleware group. Now create something great!
|
*/

Route::get('/web', [WebController::class, 'web']);
Route::get('/web/products', [WebController::class, 'products']);
Route::get('/web/products/simple', [WebController::class, 'simple']);
Route::get('/web/products/standard', [WebController::class, 'standard']);
Route::get('/web/products/premium', [WebController::class, 'premium']);
Route::get('/web/prices', [WebController::class, 'prices']);
Route::get('/web/products/printer', [WebController::class, 'printer']);

Auth::routes();
Route::get('/', [OrderController::class, 'order']);
Route::get('/menu', [OrderController::class, 'menu']);
Route::get('/basket/',[OrderController::class, 'showBasket'])->name('basket');

Route::get('/order/table/{id}',[OrderController::class,'orderForTableNr']);
Route::get('/order/', [OrderController::class, 'order'])->name('order');
Route::get('/order/category/{id}',[OrderController::class, 'showProductsFromCategory']);
Route::get('/menu/category/{id}',[OrderController::class, 'showProductsFromCategoryForMenu']);

Route::get('/order/addproduct/{id}',[OrderController::class,'addProduct']);
Route::get('/order/cancelproduct/{id}',[OrderController::class,'cancelProduct']);
Route::post('/order/addAddonProduct',[OrderController::class,'addAddOnProduct']);


Route::get('/checkout/',[CheckOutController::class,'checkout']);
Route::get('/checkout/confirmForTable/{id}',[CheckOutController::class,'confirmForTable']);
Route::get('/checkout/printOrder/{id}',[CheckOutController::class,'printOrder']);


Route::get('/admin',[AdminHomeController::class,'index'])->name('admin')->middleware('is_manager');
Route::get('/appconfig',[AdminHomeController::class,'appconfig'])->middleware('is_admin');
Route::post('/appconfig',[AdminHomeController::class,'updateconfig'])->middleware('is_admin');
Route::get('/openorders',[AdminOrderController::class,'index'])->middleware('is_manager');
Route::get('/openorders/delete/{id}',[AdminOrderController::class,'delete'])->middleware('is_manager');
Route::get('/admintable/{id}',[AdminOrderController::class,'admintable'])->middleware('is_manager');
Route::get('/bill/{id}',[AdminOrderController::class,'send_bill'])->middleware('is_manager');

Route::resource('/products', ProductController::class)->middleware('is_manager');;
Route::get('/products/index/{id?}',[ProductController::class,'index'])->middleware('is_manager');;
Route::get('/crop-image/{id}', [ProductController::class,'editImage'])->middleware('is_manager');;
Route::post('crop-image', [ProductController::class,'imageCrop'])->middleware('is_manager');;
Route::post('/products/catalog',[ProductController::class,'toggleCatalog'])->middleware('is_manager');;
Route::post('/addOnProduct/add',[ProductController::class,'addOnProductAdd'])->middleware('is_manager');;
Route::post('/addOnProduct/remove',[ProductController::class,'removeAddOnProductAdd'])->middleware('is_manager');;
Route::get('/dbimage/{id}',[ProductImageController::class, 'getImage']);



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


