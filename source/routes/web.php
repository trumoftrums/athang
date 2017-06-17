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

Route::get('/', 'Frontend\HomeController@index');
Route::get('/trang-chu', 'Frontend\HomeController@index');
Route::get('/nong-nghiep', 'Frontend\HomeController@Nongnghiep');
Route::get('/chan-nuoi', 'Frontend\HomeController@Channuoi');
Route::get('/lien-he', 'Frontend\HomeController@Lienhe');
Route::get('/nong-nghiep/{id}/{name}', 'Frontend\HomeController@Nongnghiepdetail');
Route::get('/chan-nuoi/{id}/{name}', 'Frontend\HomeController@Channuoidetail');



