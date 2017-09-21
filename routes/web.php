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

Route::get('/', 'UserController@homepage');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/************Apis*************/
Route::post('auth', 'UserController@checkAuth');
Route::post('signup', 'UserController@signup');

Route::post('language', array(
    'before'    => 'csrf',
    'as'        => 'language-chooser',
    'uses'      => 'LanguageController@chooser'
    ));

Route::group(['middleware' => 'prevent-back-history'],function(){
    Route::group(['middleware' => ['auth']], function () { 
        Route::group(['prefix' => 'admin'], function () {
            Route::get('dashboard', 'AdminController@dashboard');
        });
    });
});
