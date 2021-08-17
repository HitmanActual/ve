<?php
namespace App\Traits;

use Illuminate\Http\Response;

trait ResponseTrait
{

    public function errorResponse($message,$code){
        return response()->json(['error'=>$message,'code'=>$code],$code);
    }


    public function successResponse($data,$code=Response::HTTP_OK){

        return response()->json(['data'=>$data,'messages'=>['success']],$code);
    }

}