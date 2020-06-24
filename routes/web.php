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

Route::group(['namespace' => 'Product'], function () {
    Route::resource('product', 'ProductController')->except(['create', 'destroy', 'show']);

    Route::group(['as' => 'product.', 'prefix' => 'product'], function () {
        Route::get('random-products', 'ProductController@generateRandomProducts')->name('generateRandomProducts');
        Route::get('list', 'ProductController@list')->name('list');
        Route::put('product-translation/{product}', 'ProductController@updateTranslation')->name('updateTranslation')->where('product', '[0-9]+');
        Route::get('product-translation/{product}', 'ProductController@listTranslations')->name('listTranslations')->where('product', '[0-9]+');
        Route::get('translatable-columns', 'ProductController@listTranslatableColumns')->name('listTranslatableColumns');
    });
});

Route::group(['namespace' => 'Translation'], function () {

    Route::group(['as' => 'translation.', 'prefix' => 'translation'], function () {
        Route::get('locales', 'TranslationController@listLocales')->name('listLocales');
    });
});

