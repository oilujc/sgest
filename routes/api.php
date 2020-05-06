<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('contact/', 'ApiController@getAllContacts');
Route::post('contact/', 'ApiController@createContact');
Route::get('contact/{id}', 'ApiController@getContact');
Route::put('contact/{id}', 'ApiController@updateContact');
Route::delete('contact/{id}', 'ApiController@deleteContact');
