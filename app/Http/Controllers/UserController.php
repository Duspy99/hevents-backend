<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function getUsers()
    {
        return User::all();
    }

    public function getUser(Request $request)
    {
        return User::where('id',$request->id)->firstOrFail();
    }

    public function getModerators()
    {
        return User::where('role','1')->get();
    }

    public function getAdministrators()
    {
        return User::where('role','99')->get();
    }

    public function getMe(Request $request)
    {
        $user = auth('api')->user();
        if(!$user)
        {
            return response()->json(['error' => 'Unauthorized.'], 401);
        }

        return response()->json($user, 200);
    }

    public function editUser(Request $request)
    {

        $user = User::where('id',$request->id)->firstOrFail();
        $user->update(['role' => $request->role]);

        return response()->json(['success' => 'User role updated'], 201);

    }
}
