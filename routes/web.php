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
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('admin/home', 'HomeController@index')->name('home');
Route::get('/verify', 'ShopifyController@index')->name('verify');
Route::get('/authenticate', 'ShopifyController@redirect');
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::group(['prefix'=>'admin','as'=>'admin.'], function(){
    Route::post('/upload', 'ProductController@upload')->name('upload');
    Route::get('/products', 'ProductController@index')->name('products');
    Route::get('/products/get', 'ProductController@get')->name('getproducts');
    Route::post('/product/singleget', 'ProductController@singleget')->name('singleget');
    Route::get('/products/edit/{pid}/{vid}', 'ProductController@edit')->name('editproducts');
    Route::post('/product/update', 'ProductController@update')->name('updateproduct');

});