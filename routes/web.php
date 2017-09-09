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

$admin = session('admin', null);
if ($admin) {
	View::share('admin', $admin);
}


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

Route::group(['prefix'=>'/admin', 'as'=>'admin.', 'namespace'=>'Admin'],function(){
	Route::get('/login', 'AdminController@login')->name('login');
	Route::post('/login', 'AdminController@postLogin')->name('postLogin');
	Route::post('/logout', 'AdminController@logout')->name('logout');
	Route::get('/register', 'AdminController@register')->name('register');
	Route::post('/register', 'AdminController@postRegister')->name('postRegister');
	/*
	Route::get('/categories', 'CategoryController@index')->name('categories.index');
	Route::get('/categories/create', 'CategoryController@create')->name('categories.create');
	Route::post('/categories/store', 'CategoryController@store')->name('categories.store');
	Route::get('/categories/{id}', 'CategoryController@show')->name('categories.show');
	Route::get('/categories/{id}/edit/', 'CategoryController@edit')->name('categories.edit');
	Route::patch('/categories/{id}/update', 'CategoryController@update')->name('categories.update');
	Route::delete('/categories/{id}', 'CategoryController@destroy')->name('categories.destroy');
	*/
	Route::get('/categories/search', 'CategoryController@search')->name('categories.search');
	Route::resource('/categories', 'CategoryController');
	Route::resource('/products','ProductController');
});

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
