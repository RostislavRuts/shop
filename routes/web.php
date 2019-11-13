<?php

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

Auth::routes();// Auth::routes()

Route::get('/', 'HomeController@index')->name('home');

Route::get('/product/{slug}', 'HomeController@showProduct');

Route::post('/cart/add-to-cart', 'CartController@add');
Route::post('/cart/clear-cart', 'CartController@removeAll');
Route::post('/cart/remove-product', 'CartController@removeProduct');
Route::get('/checkout', 'CartController@checkout');
Route::post('/buy', 'CartController@buy');
Route::get('/users/{id}/orders-on-main', 'Admin\UserController@userOrders')->name('orderHistory');

Route::group([
	'prefix' => 'admin',
	'namespace' => 'Admin',
	'middleware' => ['auth', 'admin'],

], function(){//
		Route::get('/', 'AdminController@index');
		Route::resource('/users', 'UserController');
		Route::resource('/categories', 'CategoryController');
		Route::resource('/products', 'ProductController');
		Route::post('/products/edit-recommended', 'ProductController@editRecommended');
		Route::resource('/orders', 'OrderController');
		Route::post('/orders/{id}/change-status', 'OrderController@changeStatus');
		Route::get('/users/{id}/orders', 'UserController@userOrders');
		Route::resource('/sales', 'SaleController');

	}
);




