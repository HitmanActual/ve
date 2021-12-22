<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Models\Developer;
use App\Models\Unit;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DeveloperController extends Controller
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
        $developers = Developer::with('project')->get();
        return $this->successResponse($developers, Response::HTTP_OK);

    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function show($developer)
    {
        //

        try{

            $developer = Developer::with(['project','project.image','project.city','project.city.state.country'])->findOrFail($developer);
            return $this->successResponse($developer, Response::HTTP_OK);

        }catch(ModelNotFoundException $ex){

            return "could'nt find developer with this id";
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Developer $developer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Developer  $developer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Developer $developer)
    {
        //
    }



    //----credintails

    public function register(Request $request)
    {

        $validateData = $request->validate([
            'commercial_name' => 'required|max:55',
            'contact_person' => 'required|max:55',
            'email' => 'email|required|unique:developers',
            'password' => 'required|confirmed',
            'phone' => 'required|regex:/(01)[0-9]{9}/',
            'image_path'=>'',


        ]);

            $imagePath  = uploadImage('developers',$request->image_path);

        $validateData['password'] = bcrypt($request->password);
        $validateData['image_path'] = $imagePath;





        $user = Developer::create($validateData);
        $accessToken = $user->createToken('authToken')->accessToken;

        return response(['user' => $user, 'access_token' => $accessToken]);

        return $this->successResponse($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {


        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required',
        ]);



        if (!Auth::guard('developer')->attempt($loginData)) {

            return $this->errorResponse('invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = auth('developer')->user()->createToken('authToken')->accessToken;
        return response(['user' => auth('developer')->user(), 'access_token' => $accessToken]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return $this->successResponse('successfully logged out', Response::HTTP_OK);
    }
}
