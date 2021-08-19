<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\DeveloperController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\StateController;
use App\Http\Controllers\Api\AuthController;


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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});




//---
Route::group(['prefix'=>'countries'],function(){

    Route::get('/',[CountryController::class,'index']);

    Route::get('/states/{country_id}', [StateController::class,'getStateByCountryId']);
    Route::get('/cities/{state_id}', [CityController::class,'getCityByStateId']);

});


Route::group(['prefix'=>'projects'],function (){

    Route::get('/',[ProjectController::class,'index']);
    Route::get('/{project}',[ProjectController::class,'show']);
    Route::post('/',[ProjectController::class,'store']);

});

Route::group(['prefix'=>'units'],function (){

    Route::get('/',[UnitController::class,'index']);
    Route::get('/{unit}',[UnitController::class,'show']);

});

Route::group(['prefix'=>'developers'],function (){

    Route::get('/',[DeveloperController::class,'index']);
    Route::get('/{developer}',[DeveloperController::class,'show']);

});

Route::group(['prefix'=>'reservations','middleware'=>'auth:api'],function (){

    Route::get('/',[ReservationController::class,'index']);
    Route::get('/{reservation}',[ReservationController::class,'show']);
    Route::post('/',[ReservationController::class,'store']);

});


Route::group(['prefix'=>'favorites','middleware'=>'auth:api'],function (){

    Route::get('/',[FavoriteController::class,'index']);
    Route::get('/{favorite}',[FavoriteController::class,'show']);
    Route::post('/',[FavoriteController::class,'store']);
    Route::delete('/{favorite}',[FavoriteController::class,'destroy']);

});



Route::group(['prefix'=>'users'],function (){

    Route::post('/register',[AuthController::class,'register']);
    Route::post('/login',[AuthController::class,'login']);

});


//--------admins
Route::group(['prefix'=>'admins'],function (){

    Route::post('/register',[AdminController::class,'register']);
    Route::post('/login',[AdminController::class,'login']);

});


//--------developers
Route::group(['prefix'=>'developers'],function (){

    Route::post('/register',[DeveloperController::class,'register']);
    Route::post('/login',[DeveloperController::class,'login']);

});





