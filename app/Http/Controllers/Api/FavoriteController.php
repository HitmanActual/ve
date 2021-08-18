<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Favorite;
use App\Models\Reservation;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
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
        //get all reservations for specific user
        $user = Auth::id();
        $favorites = Favorite::where('user_id', $user)->with('unit')->get();
        return $this->successResponse($favorites, Response::HTTP_OK);
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

        DB::beginTransaction();
        try {

            $user = Auth::id();
            $favorite = Favorite::create([

                'user_id' => $user,
                'unit_id' => $request->unit_id,
            ]);
            DB::commit();
            return $this->successResponse($favorite, Response::HTTP_CREATED);

        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            abort(500, 'could add project');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Favorite $favorite
     * @return \Illuminate\Http\Response
     */
    public function show($favorite)
    {
        //
        try {
            $user = Auth::id();
            $favorite = Favorite::where('user_id', $user)->with('unit')->findOrFail($favorite);
            return $this->successResponse($favorite, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {

            return "could find unit with this id";
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Favorite $favorite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Favorite $favorite
     * @return \Illuminate\Http\Response
     */
    public function destroy($favorite)
    {
        //
        try {

            $user = Auth::id();
            $favorite = Favorite::where('user_id', $user)->findOrFail($favorite);
            $favorite->delete();
            return $this->successResponse($favorite, Response::HTTP_OK);

        } catch (ModelNotFoundException $ex) {
            return "could find unit with this id";
        }
    }
}
