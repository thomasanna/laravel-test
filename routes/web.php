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

Route::get('/', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');

Auth::routes();
Route::group(['middleware' =>  'auth',['role:superadmin']], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('users/lists', 'HomeController@lists');
    Route::get('users/create', 'HomeController@create');
    Route::post('users/store', 'HomeController@store');
    Route::get('users/{user}/edit', 'HomeController@edit');
    Route::put('users/update/{user}', 'HomeController@update');
    Route::delete('users/{user}', 'HomeController@destroy');


});

