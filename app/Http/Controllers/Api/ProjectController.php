<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Project\ProjectCollection;
use App\Models\Project;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
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

        $projects = Project::with('developer', 'city')->get();
        return $this->successResponse($projects, Response::HTTP_OK);
        //ProjectCollection::collection(Project::with('developer')->get());

    }


    /**
     * Store a newly created resource in storage only for Admins.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validateDate = $request->validate([
            'title' => 'required|max:255',
            'city_id' => 'required|max:255',
            'developer_id' => 'required|max:255',
            'tod' => 'max:255',
        ]);
        DB::beginTransaction();
        try {
            $project = Project:: create($validateDate);


            DB::commit();
            return $this->successResponse($project, Response::HTTP_CREATED);
        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            abort(500, 'could add project');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show($project)
    {
        //
        $project = Project::with(['developer', 'city'])->findOrFail($project);
        return $this->successResponse($project, Response::HTTP_OK);
    }


    /**
     * only for Admin use
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $project)
    {
        //
        DB::beginTransaction();
        try {


            $project = Project::findOrFail($project);
            $project->fill([
                'title' => $request->title,
                'city_id' => $request->city_id,
                'developer_id' => $request->developer_id,
                'tod' => $request->tod,
            ]);
            if ($project->isClean()) {
                return $this->errorResponse('at least one value must be changed', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $project->save();
            DB::commit();
            return $this->successResponse($project, Response::HTTP_OK);
        } catch (ModelNotFoundException $exception) {
            DB::rollBack();
            abort(500, "couldn't update the project");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy($project)
    {
        //
        try {

            $project = Project::findOrFail($project);
            $project->delete();
            return $this->successResponse($project, Response::HTTP_OK);

        } catch (ModelNotFoundException $exception) {
            abort(500, "couldn't delete the project");

        }

    }
}
