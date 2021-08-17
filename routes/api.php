<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CityController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\StateController;


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




//---
Route::group(['prefix'=>'countries'],function(){

    Route::get('/',[CountryController::class,'index']);

    Route::get('/states/{country_id}', [StateController::class,'getStateByCountryId']);
    Route::get('/cities/{state_id}', [CityController::class,'getCityByStateId']);

});
