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

/*
Route::get('/', function () {
    return view('welcome');
});
*/

Auth::routes();

Route::get('/{page?}', 'HomeController@index')
    ->where('page', '[0-9]+')
    ->name('home');

Route::get('/search/{page?}', 'HomeController@code')
    ->where('search', '[0-9]+')
    ->where('operation', '[<>=]')
    ->where('page', '[0-9]+')
    ->name('search');

Route::get('/computing/{id}', 'ComputingController@index')
    ->where('id', '[0-9]+')
    ->name('post');

Route::get('/computing/editor',
    //function() { return view('editor'); } ) //
    'ComputingController@editor')
    ->name('editor');

Route::post('computing/save', 'ComputingController@save')
    ->name('post_save');
