<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UnitController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $units = Unit::with('project', 'developer')->get();
        return $this->successResponse($units, Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $validatedData = $request->validate([
            'project_id' => 'required|max:255',
            'developer_id' => 'required',
            'usage'=>'required',
            'unit_type'=>'required',
            'floor_space'=>'required',
            'bedroom'=>'required',
            'bathroom'=>'required',
        ]);

        DB::beginTransaction();
        try {
            $unit = Unit::create($validatedData);


            DB::commit();
            return $this->successResponse($unit, Response::HTTP_CREATED);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            abort(500, 'could add unit');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function show($unit)
    {
        try {

            $unit = Unit::with('developer', 'project')->findOrFail($unit);
            return $this->successResponse($unit, Response::HTTP_OK);

        } catch (ModelNotFoundException $ex) {

            return "could find unit with this id";
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $unit)
    {
        //
        $validateData = $request->validate([
            'project_id' => 'max:255',
            'developer_id' => 'max:255',
            'usage'=>'max:255',
            'unit_type'=>'max:255',
            'floor_space'=>'max:255',
            'bedroom'=>'max:255',
            'bathroom'=>'max:255',

        ]);
        DB::beginTransaction();
        try {


            $project = Unit::findOrFail($unit);
            $project->fill($validateData);
            if ($project->isClean()) {
                return $this->errorResponse('at least one value must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $project->save();
            DB::commit();
            return $this->successResponse($project, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            abort(500, "couldn't update the unit");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Unit $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy($unit)
    {
        //
        try {

            $unit = Unit::findOrFail($unit);
            $unit->delete();
            return $this->successResponse($unit, Response::HTTP_OK);

        } catch (ModelNotFoundException $exception) {
            abort(500, "couldn't delete the project");

        }


    }
}
