<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Traits\ResponseTrait;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    //
    use ResponseTrait;
    public function index(){

        $countries = Country::all();
        return $this->successResponse($countries, Response::HTTP_OK);


    }
}
