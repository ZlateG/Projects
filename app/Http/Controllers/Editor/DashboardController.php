<?php

namespace App\Http\Controllers\Editor;

use App\Http\Controllers\Controller;
use App\Models\AirplaneTicket;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $airplaneTickets = AirplaneTicket::all();
        $contactUs = ContactUs::all();
        $users = User::all();

        return view('editor-dash', compact('airplaneTickets', 'contactUs', 'users'));
    }
}
