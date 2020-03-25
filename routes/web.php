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
Route::get('/login', 'UserController@showLogin');

Route::get('airport', 'Dbass@airport');
Route::get('flight', 'Dbass@flight');
Route::get('reservation', 'Dbass@reservation');
// Route::get('/', function () {
//     return view('welcome');
// });
