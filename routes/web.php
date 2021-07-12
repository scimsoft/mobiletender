<?php


use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminOrderController;

use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminStockController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

use App\Http\Controllers\ProductImageController;

use App\Http\Controllers\TimeReportController;
use App\Http\Controllers\Web\WebController;
use App\Models\TimeReport;
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

//Route::get('/web', [WebController::class, 'web']);
//Route::get('/web/products', [WebController::class, 'products']);
//Route::get('/web/products/simple', [WebController::class, 'simple']);
//Route::get('/web/products/standard', [WebController::class, 'standard']);
//Route::get('/web/products/premium', [WebController::class, 'premium']);
//Route::get('/web/prices', [WebController::class, 'prices']);
//Route::get('/web/subscription', [WebController::class, 'subscription']);
//Route::get('/web/products/printer', [WebController::class, 'printer']);

Auth::routes();
Route::group(['middleware' => ['web']], function () {
    Route::get('/', [OrderController::class, 'order']);
    Route::get('/menu', [OrderController::class, 'menu']);
    Route::get('/basket/', [OrderController::class, 'showBasket'])->name('basket');

    Route::get('/order/table/{id}', [OrderController::class, 'orderForTableNr']);
    Route::get('/order/', [OrderController::class, 'order'])->name('order');
    Route::get('/order/category/{id}', [OrderController::class, 'showProductsFromCategory']);
    Route::get('/menu/category/{id}', [OrderController::class, 'showProductsFromCategoryForMenu']);

    Route::get('/order/addproduct/{id}', [OrderController::class, 'addProduct']);
    Route::get('/order/cancelproduct/{id}', [OrderController::class, 'cancelProduct']);
    Route::post('/order/addAddonProduct', [OrderController::class, 'addAddOnProduct']);

    Route::get('/order/admincancelproduct/{id}', [OrderController::class, 'admincancelproduct']);


    Route::get('/checkout/', [BasketController::class, 'checkout'])->name('checkout');
    Route::get('/checkout/pickup', [BasketController::class, 'setPickUpId']);
    Route::get('/checkout/pay', [BasketController::class, 'pay'])->name('pay');
    Route::get('/checkout/payed', [BasketController::class, 'payed'])->name('payed');
    Route::get('/checkout/confirmForTable/{id}', [BasketController::class, 'confirmForTable']);
    Route::get('/checkout/printOrder/{id}', [BasketController::class, 'sendOrder']);
    Route::get('/checkout/printOrderEfectivo/{id}', [BasketController::class, 'printOrderEfectivo']);
    Route::get('/checkout/printOrderTarjeta/{id}', [BasketController::class, 'printOrderTarjeta']);
    Route::get('/checkout/printOrderOnline/{id}', [BasketController::class, 'printOrderOnline']);
    Route::get('/checkout/printOrderPagado/{id}', [BasketController::class, 'printOrderPagado']);
    Route::get('/checkout/printOrderTicket/{id}', [BasketController::class, 'printTicketfromPayment']);

    Route::get('/timereport',[TimeReportController::class,'index'])->middleware('is_employee');
    Route::get('/timereport/enter',[TimeReportController::class,'enter'])->middleware('is_employee');
    Route::get('/timereport/exit',[TimeReportController::class,'exit'])->middleware('is_employee');





    Route::get('/admin', [AdminHomeController::class, 'index'])->name('admin')->middleware('is_employee');
    Route::get('/appconfig', [AdminHomeController::class, 'appconfig'])->middleware('is_admin');
    Route::post('/appconfig', [AdminHomeController::class, 'updateconfig'])->middleware('is_admin');
    Route::get('/openorders', [AdminOrderController::class, 'index'])->middleware('is_manager');
    Route::get('/openorders/delete/{id}', [AdminOrderController::class, 'delete'])->middleware('is_manager')->name('deleteorder');
    Route::get('/openorders/deleteTable/{id}', [AdminOrderController::class, 'deleteTable'])->middleware('is_manager')->name('deleteTable');
    Route::get('/showusers',[AdminOrderController::class, 'showusers'])->middleware('is_admin');
    Route::get('/deletuser/{id}',[AdminOrderController::class, 'deleteuser'])->middleware('is_admin');
    Route::get('/changeusertype/{id}/{type}',[AdminOrderController::class, 'changeUserType'])->middleware('is_admin');


    Route::get('/adminvertable/{id}', [AdminOrderController::class, 'admintable'])->middleware('is_manager');
    Route::get('/printbill/{id}', [AdminOrderController::class, 'send_bill'])->middleware('is_manager');
    Route::get('/selecttable',[AdminHomeController::class, 'selectTableNr'])->middleware('is_waiter');
    Route::resource('/products', ProductController::class)->middleware('is_manager');;
    Route::get('/products/list/{id}',[ProductController::class,'getProductList'])->middleware('is_manager');
    Route::get('/products/index/{id?}', [ProductController::class, 'index'])->middleware('is_manager');;
    Route::get('/crop-image/{id}', [ProductController::class, 'editImage'])->middleware('is_manager');;
    Route::post('crop-image', [ProductController::class, 'imageCrop'])->middleware('is_manager');;
    Route::post('/products/catalog', [ProductController::class, 'toggleCatalog'])->middleware('is_manager');;
    Route::post('/addOnProduct/add', [ProductController::class, 'addOnProductAdd'])->middleware('is_manager');;
    Route::post('/addOnProduct/remove', [ProductController::class, 'removeAddOnProductAdd'])->middleware('is_manager');;
    Route::get('/dbimage/{id}', [ProductImageController::class, 'getImage']);
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->middleware('is_manager');

    Route::post('/categories/setparent',[CategoryController::class,'setParentId'])->middleware('is_manager');
    Route::post('/categories/toggleactive',[CategoryController::class,'toggleActive'])->middleware('is_manager');

    Route::get('/payments/{id}',[AdminPaymentController::class,'pay'])->middleware('is_manager');
    Route::get('/payed/{id}/{mode}',[AdminPaymentController::class,'payed'])->middleware('is_manager');
    Route::get('/paypanel',[AdminPaymentController::class,'paypanel'])->middleware('is_manager')->name('paypanel');
    Route::get('/moveto/{from}/{to}',[AdminPaymentController::class,'moveto'])->middleware('is_finance')->name('moveto');
    Route::get('/movefrom/{from}',[AdminPaymentController::class,'movefrom'])->middleware('is_finance')->name('movefrom');

    Route::get('/opendrawer',[AdminPaymentController::class,'openDrawer']) ->middleware('is_finance');
    Route::get('/closecash',[AdminPaymentController::class,'closecash'])->middleware('is_manager')->name('closecash');
    Route::get('/printmoney',[AdminPaymentController::class,'printmoney'])->middleware('is_manager')->name('printmoney');
    Route::get('/closemoney',[AdminPaymentController::class,'closemoney'])->middleware('is_manager')->name('closemoney');
    Route::get('/movements',[AdminPaymentController::class,'movementsIndex'])->middleware('is_manager')->name('movementsIndex');
    Route::post('/addmovement',[AdminPaymentController::class,'addmovement'])->middleware('is_manager')->name('addmovement');

    Route::get('/stockindex/{cat?}',[AdminStockController::class,'currentStockIndex'])->middleware('is_admin')->name('stockIndex');
    Route::post('/stock/add',[AdminStockController::class,'addStock'])->middleware('is_admin');


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

