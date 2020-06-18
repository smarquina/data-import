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

Route::get('/', 'PublicController@index')->name('index');
Route::post('language', 'PublicController@setLang')->name('setLang');

Route::group(['as' => 'product.', 'prefix' => 'product', 'namespace' => 'Product'], function () {

    Route::get('random-products', 'productController@generateRandomProducts')->name('generateRandomProducts');
    Route::post('store', 'productController@store')->name('store');
    Route::get('index', 'productController@index')->name('index');
    Route::get('list', 'productController@list')->name('list');
});

