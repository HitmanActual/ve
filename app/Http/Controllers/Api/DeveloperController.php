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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

            $developer = Unit::with('project')->findOrFail($developer);
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
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'phone' => 'required|regex:/(01)[0-9]{9}/',


        ]);

        $validateData['password'] = bcrypt($request->password);

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
