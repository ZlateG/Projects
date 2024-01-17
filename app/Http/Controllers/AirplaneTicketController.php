<?php

namespace App\Http\Controllers;

use App\Http\Requests\AirplaneTicketRequest;
use App\Mail\AirplaneTicketAnswerMail;
use App\Models\AirplaneTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AirplaneTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tickets = AirplaneTicket::all();
        return response()->json(['data' => $tickets]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AirplaneTicketRequest $request)
    {
        $ticket = AirplaneTicket::create($request->all());
        return response()->json(['data' => $ticket], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AirplaneTicket  $airplaneTicket
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(AirplaneTicket $airplaneTicket)
    {
        $airplaneTicket->load('answeredBy');
        return response()->json(['data' => $airplaneTicket]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AirplaneTicket  $airplaneTicket
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request, AirplaneTicket $airplaneTicket)
    {
        $airplaneTicket->update($request->all());
    
        $user = $airplaneTicket->answeredBy;
        $answer = $request->input('answer');
    
        \Illuminate\Support\Facades\Mail::to($user->email)
            ->send(new AirplaneTicketAnswerMail($answer));
    
        return response()->json(['data' => $airplaneTicket]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AirplaneTicket  $airplaneTicket
     * @return \Illuminate\Http\JsonResponse
     */


    public function destroy(AirplaneTicket $airplaneTicket)
    {
        $airplaneTicket->delete();
        return response()->json(null, 204);
    }

    public function permDelete(Request $request, $id)
    {
        $testemonial = AirplaneTicket::findOrFail($id);
     
        $testemonial->forceDelete();

        return redirect()->route('editor.dashboard');
    }

    public function markAsSorted(Request $request, AirplaneTicket $airplaneTicket)
    {
        $user = Auth::user();
        $airplaneTicket->update([
            'answered_by' => $user->id,
        ]);

        return response()->json(['data' => $airplaneTicket], 200);
    }

    public function notAnswered()
    {
        $notAnsweredAirplaneTicket = AirplaneTicket::whereNull('answered_by')->get();
        return response()->json(['data' => $notAnsweredAirplaneTicket], 200);
    }

    public function answered()
    {
        $answeredAirplaneTicket = AirplaneTicket::whereNotNull('answered_by')->get();
        return response()->json(['data' => $answeredAirplaneTicket], 200);
    }
}
