<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Developer;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class AdminController extends Controller
{
    use ResponseTrait;

    public function register(Request $request)
    {

        $validateData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',



        ]);

        $validateData['password'] = bcrypt($request->password);

        $user = Admin::create($validateData);
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



        if (!Auth::guard('admin')->attempt($loginData)) {

            return $this->errorResponse('invalid credentials', Response::HTTP_UNAUTHORIZED);
        }

        $accessToken = auth('admin')->user()->createToken('authToken')->accessToken;
        return response(['user' => auth('admin')->user(), 'access_token' => $accessToken]);

    }

    public function logout(Request $request)
    {
        Auth::logout();
        return $this->successResponse('successfully logged out', Response::HTTP_OK);
    }
}
