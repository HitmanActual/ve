<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AssetBundleController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\UnitController;
use App\Http\Controllers\Api\DeveloperController;
use App\Http\Controllers\Api\NoteController;
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


Route::group(['prefix' => 'countries'], function () {

    Route::get('/', [CountryController::class, 'index']);

    Route::get('/states/{country_id}', [StateController::class, 'getStateByCountryId']);
    Route::get('/cities/{state_id}', [CityController::class, 'getCityByStateId']);


    //-----admin city routes----
    Route::post('/add', [CityController::class, 'store'])->middleware('auth:admin-api');
    Route::patch('/{city}', [CityController::class, 'update'])->middleware('auth:admin-api');
    Route::put('/{city}', [CityController::class, 'update'])->middleware('auth:admin-api');
    Route::delete('/{city}', [CityController::class, 'destroy'])->middleware('auth:admin-api');

});


Route::group(['prefix' => 'cities'], function () {

    Route::get('/', [CityController::class, 'index']);
    Route::get('/{city}', [CityController::class, 'show']);

});


Route::group(['prefix' => 'projects'], function () {

    Route::get('/', [ProjectController::class, 'index']);
    Route::get('/{project}', [ProjectController::class, 'show']);


    //---- admin routes ------
    Route::post('/add', [ProjectController::class, 'store'])->middleware('auth:admin-api');
    Route::patch('/{project}', [ProjectController::class, 'update'])->middleware('auth:admin-api');
    Route::put('/{project}', [ProjectController::class, 'update'])->middleware('auth:admin-api');
    Route::delete('/{project}', [ProjectController::class, 'destroy'])->middleware('auth:admin-api');


});

Route::group(['prefix' => 'units'], function () {

    Route::get('/', [UnitController::class, 'index']);
    Route::get('/{unit}', [UnitController::class, 'show']);


    //---admin units---

    Route::post('/add', [UnitController::class, 'store'])->middleware('auth:admin-api');
    Route::patch('/{unit}', [UnitController::class, 'update'])->middleware('auth:admin-api');
    Route::put('/{unit}', [UnitController::class, 'update'])->middleware('auth:admin-api');
    Route::delete('/{unit}', [UnitController::class, 'destroy'])->middleware('auth:admin-api');


});

Route::group(['prefix' => 'developers'], function () {

    Route::get('/', [DeveloperController::class, 'index']);
    Route::get('/{developer}', [DeveloperController::class, 'show']);


    Route::post('/register', [DeveloperController::class, 'register']);
    Route::post('/login', [DeveloperController::class, 'login']);


});

Route::group(['prefix' => 'reservations', 'middleware' => 'auth:api'], function () {

    Route::get('/', [ReservationController::class, 'index']);
    Route::get('/{reservation}', [ReservationController::class, 'show']);
    Route::post('/', [ReservationController::class, 'store']);




});


Route::group(['prefix' => 'favorites', 'middleware' => 'auth:api'], function () {

    Route::get('/', [FavoriteController::class, 'index']);
    Route::get('/{favorite}', [FavoriteController::class, 'show']);
    Route::post('/', [FavoriteController::class, 'store']);
    Route::delete('/{favorite}', [FavoriteController::class, 'destroy']);

});


Route::group(['prefix' => 'users'], function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);



    //-----notifications

    Route::get('/notifications',[AuthController::class,'notifications']);
    Route::get('/markasread/{notification_id}',[AuthController::class,'markasread']);


});


//--------admins
Route::group(['prefix' => 'admins'], function () {

    Route::post('/register', [AdminController::class, 'register']);
    Route::post('/login', [AdminController::class, 'login']);



   Route::get('/notifications',[AdminController::class,'notifications']);
   Route::get('/notifications/all',[AdminController::class,'all_notifications']);
   Route::get('/markasread/{notification_id}',[AdminController::class,'markasread']);


});


Route::group(['prefix' => 'bundles'], function () {

    Route::get('/assets', [AssetBundleController::class, 'index']);
    Route::get('/assets/{asset}', [AssetBundleController::class, 'show']);

    Route::post('/asset', [AssetBundleController::class, 'store']);


    Route::get('/get-value', [AssetBundleController::class, 'getAssetBundle']);

});


Route::group(['prefix' => 'notes', 'middleware' => 'auth:api'], function () {

    Route::get('/', [NoteController::class, 'index']);
    Route::get('/{note}', [NoteController::class, 'show']);
    Route::post('/note', [NoteController::class, 'store']);
});








