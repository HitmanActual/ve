<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Admin;
use App\Models\Reservation;
use App\Models\User;
use App\Notifications\ReservationPlaced;
use App\Traits\ResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ReservationController extends Controller
{
    use ResponseTrait;

    protected $reservation;

    public function __construct()
    {

        $this->reservation = new Reservation();

    }

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

        DB::beginTransaction();
        try {

            $user = Auth::id();


            $admins = Admin::all();

            $reservations = Reservation::where('user_id', $user)->with('unit')->get();


            foreach ($reservations as $reserve){

                $reserve->unit_id;

                if($request->unit_id == $reserve->unit_id){
                    return 'You already have this Unit in your Reservation list';
                }

            }


            $reservation = Reservation::create([

                'user_id' => $user,
                'unit_id' => $request->unit_id,
            ]);
            DB::commit();

           Notification::send($admins, new ReservationPlaced($reservation));

          User::find($user)->notify(new ReservationPlaced($reservation));



            return $this->successResponse($reservation, Response::HTTP_CREATED);

        } catch (ModelNotFoundException $ex) {
            DB::rollBack();
            abort(500, 'could not add unit');
        }


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
