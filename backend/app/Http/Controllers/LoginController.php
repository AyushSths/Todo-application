<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Hash;

class LoginController extends Controller
{
    public function check(Request $request)
    {
        // Validate the request
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials)) {

            $user = Auth::user(); 

            $userName = $user->name; 
            $userId = $user->id; 
            $userEmail=$user->email; 

            return response()->json([
                'status' => true,
                'message' => 'Login successful!!!',
                'name' => $userName,
                'user_id' => $userId,
                'email'=>$userEmail
            ]);
        }

        // Authentication failed
        return response()->json([
            'status' => false,
            'message' => 'Invalid email or password.'
        ]);
    }
}
