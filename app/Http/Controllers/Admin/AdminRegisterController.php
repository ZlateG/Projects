<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRegisterRequest;
use App\Mail\WelcomeMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class AdminRegisterController extends Controller
{
    public function create()
    {
        // return view('admin.register');
    }

    public function store(AdminRegisterRequest $request)
    {
        $password = str_shuffle('abcdefghjklmnopqrstuvwxyzABCDEFGHJKLMNOPQRSTUVWXYZ1234567890');
        $password = substr($password, 0, 8);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role_id' => 2, 
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user, $password));

        $user->update(['status' => true]);
        Session::flash('success', 'User registered successfully!');
        return redirect()->route('dashboard'); 
    }
}