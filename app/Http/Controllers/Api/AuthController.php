<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ResponseTrait;
   public function register(Request $request){

       $validateData = $request->validate([
           'name' => 'required|max:55',
           'email' => 'email|required|unique:users',
           'password' => 'required|confirmed|min:6',
           'password_confirmation' => 'required ',
           'phone'=>'required|regex:/(01)[0-9]{9}/',


       ]);

       $validateData['password'] = bcrypt($request->password);

       $user = User::create($validateData);
       $accessToken = $user->createToken('authToken')->accessToken;

       return response(['user'=>$user,'access_token'=>$accessToken]);

       return $this->successResponse($user, Response::HTTP_CREATED);
   }

   public function login(Request $request){


       $loginData = $request->validate([
           'email' => 'email|required',
           'password' => 'required',
       ]);


       if (!auth()->attempt($loginData)) {
           return $this->errorResponse('invalid credentials', Response::HTTP_UNAUTHORIZED);
       }

      $accessToken = auth()->user()->createToken('authToken')->accessToken;
       return response(['user' => auth()->user(), 'access_token' => $accessToken]);

   }

    public function logout(Request $request) {
        Auth::logout();
        return $this->successResponse('successfully logged out',Response::HTTP_OK);
    }


    //----notifications
    public function notifications()
    {

        if (!Auth::guard('api')->check()){

            return 'you are not Authorized';
        }


        $notifications  = auth('api')->user()->unreadNotifications()->limit(5)->get()->toArray();
        return $this->successResponse($notifications,Response::HTTP_OK);

    }

    public function all_notifications()
    {

        if (!Auth::guard('api')->check()){

            return 'you are not Authorized';
        }

        $notifications = auth('api')->user()->unreadNotifications()->get()->toArray();
        return $this->successResponse($notifications,Response::HTTP_OK);
    }


    public function markasread($id)
    {

        if (!Auth::guard('api')->check()){

            return 'you are not Authorized';
        }


        auth('api')->user();
        $notification = auth('api')->user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
        }
    }
}
