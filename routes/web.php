<?php

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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/createProduct', 'HomeController@create_product')->name('createProduct');
Route::post('/addNewProduct', 'HomeController@add_new_product')->name('addNewProduct');
Route::get('/editProduct/{id}', 'HomeController@edit_product')->name('editProduct');
Route::post('/saveEditProduct/{id}', 'HomeController@save_edit_product')->name('saveEditProduct');
Route::get('/addToCart/{id}', 'HomeController@add_cart')->name('addToCart');
Route::get('/deleteProduct/{id}', 'HomeController@delete_product')->name('deleteProduct');

Route::get('/orders', 'OrderController@index')->name('orders');
Route::get('/cartPage', 'OrderController@cart_page')->name('cartPage');
Route::get('/removeProduct/{id}', 'OrderController@remove_product')->name('removeProduct');
Route::post('/addNewOrder', 'OrderController@checkout_order')->name('addNewOrder');
Route::get('/checkout', 'OrderController@checkout_form')->name('checkout');


Route::get('/editOrder/{id}', 'OrderController@edit_order')->name('editOrder');
Route::get('/viewOrder/{id}', 'OrderController@view_order')->name('viewOrder');
Route::get('/deleteOrder/{id}', 'OrderController@delete_order')->name('deleteOrder');
Route::get('/removeProductOrder/{oid}/{pid}', 'OrderController@remove_product_order')->name('removeProductOrder');