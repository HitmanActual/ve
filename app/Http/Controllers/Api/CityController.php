<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CityController extends Controller
{
    //
    use ResponseTrait;


    public function index()
    {
        $cities = City::with('project', 'project.image', 'project.developer')->has('project')->get();

        return $this->successResponse($cities, Response::HTTP_OK);
    }

    public function getCityByStateId($id)
    {
        $cities = City::where('state_id', $id)->get();
        return $this->successResponse($cities, Response::HTTP_OK);
    }


    //getProjectsByCity

    public function show($city)
    {

        $city = City::with('project', 'project.developer', 'project.image')->findOrFail($city);
        return $this->successResponse($city, Response::HTTP_OK);

    }





    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $city = City::create([

                'name' => $request->name,
                'state_id' => $request->state_id,
            ]);


            DB::commit();
            return $this->successResponse($city, Response::HTTP_CREATED);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            abort(500, 'could not add city');
        }
    }


    public function update(Request $request, $city)
    {
        //
        DB::beginTransaction();
        try {


            $city = City::findOrFail($city);
            $city->fill([
                'name' => $request->name,
                'state_id' => $request->state_id,

            ]);
            if ($city->isClean()) {
                return $this->errorResponse('at least one value must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $city->save();
            DB::commit();
            return $this->successResponse($city, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            abort(500, "couldn't update the order");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($city)
    {
        //
        try {

            $city = City::findOrFail($city);
            $city->delete();
            return $this->successResponse($city, Response::HTTP_OK);

        } catch (ModelNotFoundException $exception) {
            abort(500, "couldn't delete the project");

        }

    }


}
