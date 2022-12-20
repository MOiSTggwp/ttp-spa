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
    //=== Main
    //Auth User
    Route::get('/main/resource', 'Main\ResourceController'); // +_+_+_+_- user_profile_loveGames_contacts_ads

    //=== Games
    //All Games
    Route::get('/games/{count?}', 'Games\IndexController'); // +_+_- allGames_pagination_filters
    //One Game
    Route::get('/games/get/{id}', 'Games\ShowController');

    //=== Game Mods TODO: режимы должны подгружаться с играми (для каждой игры свой набор режимов)
    Route::get('/main_mods', 'Mod\MainModController');
    Route::get('/mods', 'Mod\ModController');

    //=== User + Profile
    //Show
    Route::get('/users/{id}', 'Users\ShowController'); // +
    //Edit
    Route::patch('/users/{id}/edit', 'Profile\Edit\EditController'); // +

    //=== Elements, Colors, User Avatar Edit Options
    Route::get('/avatar/{id}', 'Avatar\ShowController'); // +

    //=== Adverts
    //All User Adverts
//    Route::get('/adverts/{count?}', 'Adverts\IndexController');
    //One User Advert
//    Route::get('/adverts/{id}', 'Adverts\ShowController');
    //Auth User Advert Update or Create
//    Route::get('/adverts/{id}', 'Adverts\UpdateOrCreateController');



    Route::get('/admin/users', 'Users\IndexController');
    //UserAvatar
//    Route::get('/avatar/{id}', 'Avatar\ShowController');

    //--- ADMIN ---
    //Role
    Route::post('/admin/roles', 'Admin\Role\CreateController');
    Route::get('/roles', 'Admin\Role\IndexController');
    Route::patch('/admin/roles/{id}/update', 'Admin\Role\UpdateController');
    Route::delete('/admin/roles/{id}', 'Admin\Role\DeleteController');
    //Game
    Route::get('/admin/games', 'Admin\Game\IndexController');


//    Route::patch('/users/p/{id}/edit', 'Profile\ShowController');
});
