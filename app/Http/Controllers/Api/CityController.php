<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CityController extends Controller
{
    //
    use ResponseTrait;
    public function getCityByStateId($id){
        $cities = City::where('state_id',$id)->get();
        return $this->successResponse($cities, Response::HTTP_OK);
    }


}
