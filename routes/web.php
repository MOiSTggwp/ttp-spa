<?php

use Illuminate\Support\Facades\Route;

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

Auth::routes();

Route::get('/auth/discord', 'Auth\Discord\IndexController')->middleware('auth:web');
Route::get('/auth/discord/callback', 'Auth\Discord\CallbackController')->middleware('auth:web');

Route::get('{page}', 'MainController')->where('page', '.*');
