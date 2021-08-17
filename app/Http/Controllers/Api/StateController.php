<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\State;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
class StateController extends Controller
{
    //

    use ResponseTrait;

    public function getStateByCountryId($id)
    {
        $states = State::where('country_id', $id)->get();

        return $this->successResponse($states, Response::HTTP_OK);
    }

}
