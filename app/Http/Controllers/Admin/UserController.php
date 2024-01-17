<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard', compact('users'));
    }

    public function getUsers()
    {
        $users = User::with('role')->get();
        return response()->json($users);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

   
        $user->update($request->all());
        return redirect()->route('dashboard')->with('success', 'User updated successfully');
        
    }
    
    

    public function destroy(User $user)
    {
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function getUserDetails($userId)
    {
        try {
            // Fetch the user details by ID
            $user = User::findOrFail($userId);

         
            $userData = [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'role' => $user->role->name,
                'role_id' => $user->role_id,
                'statusOptions' => ['Active', 'Not Active'],
                
            ];

            return Response::json($userData);
        } catch (\Exception $e) {
            
            return Response::json(['error' => 'User not found'], 404);
        }
    }

    public function getRoles()
    {
        $roles = Role::all(['id', 'name']);
        return response()->json($roles);
    }

    public function getStatusOptions()
    {
        $statusOptions = [1 => 'Active', 0 => 'Not Active'];

        return response()->json($statusOptions);
    }
}