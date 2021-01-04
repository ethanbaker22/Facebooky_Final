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



Route::middleware('auth')->group(function () {
    Route::get('/home', 'PostController@index')->name('home');
    Route::post('/posts', 'PostController@store');

    Route::post('/{user:username}/friend', 'FriendsController@store');
    Route::get('/{user:username}/edit', 'ProfilesController@edit');

    Route::patch('/{user:username}', 'ProfilesController@update');
    Route::get('/explore', 'ExploreController@index')->name('explore');
});
Auth::routes();

Route::get('/{user:username}', 'ProfilesController@show')->name('profile');







// Route::get('/home', 'HomeController@index')->name('home');
