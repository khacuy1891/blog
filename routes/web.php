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

//$user = Auth::user();
//View::share('user', $user);

/*
Route::get('/categories', 'CategoryController@index')->name('categories.index');
Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
Route::get('/categories/store', 'CategoryController@store')->name('categories.store');
Route::get('/categories/edit/{category}', 'CategoryController@edit')->name('categories.edit');
Route::get('/categories/{category}', 'CategoryController@show')->name('categories.show');
Route::patch('/categories/update', 'CategoryController@update')->name('categories.update');

Route::delete('categories/{category}/delete', 'CategoryController@destroy')->name('categories.destroy');
*/

Route::get('/categories/search', 'CategoryController@search')->name('categories.search');
Route::resource('categories', 'CategoryController');


Route::resource('products','ProductController');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
