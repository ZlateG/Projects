<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\ContactUsAnswerMail;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{


    public function update(Request $request, ContactUs $contact_u)
    {
        $contact_u->update($request->all());

        $user = $contact_u->answeredBy;
        $answer = $request->input('answer');

        \Illuminate\Support\Facades\Mail::to($user->email)
            ->send(new ContactUsAnswerMail($answer));

        return response()->json(['data' => $contact_u]);
    }
    

    public function index()
    {
        $contactUs = ContactUs::all();
        return response()->json(['data' => $contactUs], 200);
    }


    public function store(Request $request)
    {
 
        $contactUs = ContactUs::create($request->all());
        
        return response()->json(['data' => $contactUs], 201);
    }

    public function show($contact_u)
    {
        $contactUs = ContactUs::find($contact_u);
        $contactUs->load('answeredBy');
        if (!$contactUs) {
            return response()->json(['error' => 'Contact not found'], 404);
        }
    
        return response()->json(['data' => $contactUs], 200);
    }


    public function destroy(ContactUs $contactUs)
    {
        $contactUs->delete();
        // Return a success message
        return 'Contact Request deleted successfully';
    }

    public function markAsSorted(Request $request, ContactUs $contactUs)
    {
        $user = Auth::user();

    
        $contactUs->update([
            'answered_by' => $user->id,
        ]);

        return response()->json(['data' => $contactUs], 200);
    }

    public function notAnswered()
    {
        $notAnsweredContactUs = ContactUs::whereNull('answered_by')->get();
        return response()->json(['data' => $notAnsweredContactUs], 200);
    }

    public function answered()
    {
        $answeredContactUs = ContactUs::whereNotNull('answered_by')->get();
        return response()->json(['data' => $answeredContactUs], 200);
    }
}
