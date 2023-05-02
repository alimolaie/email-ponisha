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

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/send-mail-list', 'EmailController@listSendEmail')->name('list.send.email');
Route::get('/send-mail-details/{id}', 'EmailController@showDetailsSend')->name('list.send.email.details');
Route::post('/send-mail', 'EmailController@sendMail')->name('send.mail');
