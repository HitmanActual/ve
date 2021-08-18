<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Reservation;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    use ResponseTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //get all reservations for specific user
        $user = Auth::id();
        $reservations = Reservation::where('user_id', $user)->with('unit')->get();
        return $this->successResponse($reservations, Response::HTTP_OK);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::id();
        $reservation = Reservation::create([

            'user_id' => $user,
            'unit_id' => $request->unit_id,
        ]);
        return $this->successResponse($reservation, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public function show($reservation)
    {
        //
        try {
            $user = Auth::id();
            $reservation = Reservation::where('user_id', $user)->with('unit')->findOrFail($reservation);
            return $this->successResponse($reservation, Response::HTTP_OK);
        } catch (ModelNotFoundException $ex) {

            return "could find unit with this id";
        }

    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Reservation $reservation)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Reservation $reservation
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Reservation $reservation)
    {
        //
    }
}
