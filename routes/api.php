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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('user-find/{id}', function ($id) {
    return \App\User::find($id);
})->name('user.find');


Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
	Route::resource('users', 'UserController');
});

Route::namespace('API')->name('api.')->group(function () {
	Route::put('user-like-images/{imageId}/{isLike}', 'UserImageController@likeOrDislike');
	Route::get('user-like-images-count', 'UserImageController@countImages');
	Route::get('user-like-images', 'UserImageController@getImages');
});