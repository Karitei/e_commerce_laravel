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

//Products Routes

Route::get('/produits', 'productsController@index')->name('products.index');
Route::get('/produits/{slug}', 'productsController@show')->name('product.show');
Route::get('/search', 'productsController@search')->name('products.search');

//Carts Routes

Route::group(['middleware' => ['auth']], function (){
    Route::get('panier/mon-panier','CartController@index')->name('carts.index');
    Route::post('/panier/ajouter','CartController@store')->name('cart.store');
    Route::patch('/panier/{rowId}','CartController@update')->name('cart.update');
    Route::delete('/panier/{rowId}','CartController@destroy')->name('cart.destroy');

});




//Payments routes
Route::group(['middleware' => ['auth']], function(){

    Route::get('/paiement', 'paymentController@index')->name('payment.index');
    Route::post('/paiement', 'paymentController@store')->name('payment.store');
    Route::get('/merci', 'paymentController@thankYou')->name('payment.thankYou');
});

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

Route::get('/videpanier',function (){
    Cart::destroy();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
