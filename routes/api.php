<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/main/resource', 'Main\ResourceController');

    Route::get('/users/{id}', 'Users\ShowController');
    Route::patch('/users/{id}/edit', 'Profile\Edit\EditController');

//    Route::patch('/users/p/{id}/edit', 'Profile\ShowController');
});
