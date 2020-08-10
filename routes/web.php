<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads','ThreadsController@index')->name('threads.index');
Route::post('/threads','ThreadsController@store')->name('threads.store');
Route::get('/threads/{thread}','ThreadsController@show')->name('threads.show');
Route::get('/threads/{thread}/edit','ThreadsController@edit')->name('threads.edit');
Route::put('/threads/{thread}', 'ThreadsController@update')->name('threads.update');

Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('replies.store');
