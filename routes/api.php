<?php

use Illuminate\Http\Request;
use App\Comment;
use App\Http\Controllers\Api\CommentController;

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

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::post('register', 'API\UserController@register');
Route::post('login', 'API\UserController@login');
// Route::post('logout', 'API\UserController@logout');

 Route::get('/comments', 'Api\CommentController@index');
 Route::get('/comments/{id}', 'Api\CommentController@show');

//  Route::middleware('auth:api')->group(function(){
//     Route::post('/comments', 'Api\CommentController@store');
//     Route::put('/comments/{id}', 'Api\CommentController@update');
//     Route::delete('/comments/{id}', 'Api\CommentController@destroy');
//  });

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('/comments', 'Api\CommentController@store');
    Route::put('/comments/{id}', 'Api\CommentController@update');
    Route::delete('/comments/{id}', 'Api\CommentController@destroy');
  
});

