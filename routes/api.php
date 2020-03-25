<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('login', [ 'as' => 'login', 'uses' => 'UserController@showLogin']);
//Route::get('/login', 'UserController@showLogin')->name('login');
Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'UserController@login')->name('login');
Route::get("/profile-pic", 'UserController@getProfilePic');
Route::post('/register','UserController@register');
Route::get("/get-user", 'UserController@details');
Route::get("/get-details", 'UserController@getUser');
Route::get("/placeholder", 'UserController@placeholder');
Route::get('/meter-code', 'UserController@generateId');
Route::post('/know-more', 'UserController@knowMore');
Route::post('/update-details', 'UserController@update');
Route::post("/add-image", 'UserController@addImage');
//Route::get('/sms', 'SmsController@getUserNumber')->name('send-sms');
Route::post('/sms', 'SmsController@getUserNumber')->name('send-sms');
//Route::get('/encode/{id}', 'Encrypter@decode')->name('encode');
Route::middleware('auth:api')->group(function () {
    Route::get("/get-user", 'UserController@details');
    Route::get('/articles','ArticleController@index');
    Route::get('/article/{id}','ArticleController@show');
    Route::post('/articles','ArticleController@store');
    Route::put('/articles','ArticleController@store');
    Route::delete('/articles','ArticleController@destroy');
    //return $request->user();
});

//Display articles

