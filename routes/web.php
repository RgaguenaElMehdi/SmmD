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
    return view('newcustomer');

});

Route::get('apishow', 'MailController@apishow');



Route::get('newclient', ['uses' => 'MailController@addco']);
Route::POST('newco', ['uses' => 'MailController@create', 'as' => 'newco']);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
