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

// Route::get('email-test', function(){
//     $detalles['email'] = 'davidragarenteria@gmail.com';
//     dispatch(new App\Jobs\EmailJob($detalles));
//     dd('done');
// });

Route::group(['middleware' => 'auth'], function () {
    Route::get('/users', 'UserController@index');
    Route::get('/getComplemento', 'UserController@getComplemento');
    Route::get('/users/table', 'UserController@table');
    Route::get('/users/delete/{id}', 'UserController@delete');
    Route::post('/users/set', 'UserController@setUser');
    Route::post('/users/put', 'UserController@putUser');
    Route::get('/getPais', 'UserController@getPais');


    Route::get('/emails', 'EmailController@index');
    Route::get('/emails/table', 'EmailController@table');
    Route::post('/emails/set', 'EmailController@setEmail');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
