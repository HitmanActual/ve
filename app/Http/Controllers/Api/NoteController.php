<?php

namespace App\Http\Controllers\Api;

use  App\Http\Controllers\Controller;

use App\Models\Note;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
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

        $notes = Note::with('project')->where('user_id', Auth::id())->get();
        return $this->successResponse($notes, Response::HTTP_OK);
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

        $note = Note::create([
            'user_id' => Auth::id(),
            'project_id' => $request->project_id,
            'notes' => $request->notes,
        ]);

        return $note;

        return $this->successResponse($note, Response::HTTP_CREATED);

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function show($note)
    {
        //
        $note = Note::where('user_id')->findOrFail($note);
        return $this->successResponse($note, Response::HTTP_OK);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Note $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        //
    }
}
