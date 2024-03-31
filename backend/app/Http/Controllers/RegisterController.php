<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\User;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use  Hash;

class RegisterController extends Controller
{
    public function store(Request $request){
        // $input = $request->all();
        $input = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        // Check if the user already exists
        $existingUser = User::where('email', $input['email'])->first();
        if ($existingUser) {
            return response()->json(['status' => false, 'message' => 'User with same email already exists'],422);
        }
        else{
            User::create([
                'name' => $input['name'],
                'email'=>$input['email'],
                'password'=>Hash::make($input['password']),
            ]);
            // return redirect()->route('login');
            return response()->json(['status'=>true,
                                    'message'=>"Registration success!!!"]);
         }
                                 
    }

    public function fetch(Request $request) {
        
        if ($request->id) {
            
            $user=User::find($request->id);
            
            if (!$user) {
                return response()->json(['status'=>false,'message'=>"No user found"],404);
            } else {
                return response()->json(['status'=>true,'data'=>$user]);
            }
        }else{
            return response()->json(['status'=>false,
                                     'message'=>"Please provide an id",
                                      'errors'=>'Id required']);  
        }
      
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.',
            ], 404);
        }

        // Name validation
        if ($request->has('name')) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->input('name') === $user->name) {
                return response()->json([
                    'status' => false,
                    'message' => 'New name must be different from the old name.',
                ], 400);
            }
            $user->name = $request->input('name');
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Name updated successfully.',
                'data' => $user,
            ], 200);
        }

        //Email validation
        if ($request->has('email')) {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . $id,
            ],
            [
                'email.unique' => "The email has already been taken."
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }

            if ($request->input('email') === $user->email) {
                return response()->json([
                    'status' => false,
                    'message' => 'New email must be different from the old email.',
                ], 400);
            }
            $user->email = $request->input('email');
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Email updated successfully.',
                'data' => $user,
            ], 200);
        }

        // Password validation
        if ($request->has('old_password') && $request->has('new_password') && $request->has('confirm_password')) {
            $validator = Validator::make($request->all(), [
                'old_password' => 'required|string',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|same:new_password',
            ]);
    
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation Error',
                    'errors' => $validator->errors()
                ], 422);
            }
    
            if (!Hash::check($request->input('old_password'), $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Old password is incorrect.',
                ], 400);
            }
    
            if (Hash::check($request->input('new_password'), $user->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'New password must be different from the old password.',
                ], 400);
            }
            $user->password = bcrypt($request->input('new_password'));
            $user->save();
    
            return response()->json([
                'status' => true,
                'message' => 'Password updated successfully.',
                'data' => $user,
            ], 200);
        }

        return response()->json([
            'status' => false,
            'message' => 'No update fields provided.',
        ], 400);
    }

    public function delete(Request $request){
        if ($request->id) {
            
            $user=User::find($request->id);
            
            if (!$user) {
                return response()->json(['error'=>true,'message'=>"User not found to delete"],404);
            } else {
                if ($request->has('password') ) {
                    $validator = Validator::make($request->all(), [
                        'password' => 'required|string',     
                    ]);
            
                    if ($validator->fails()) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Validation Error',
                            'errors' => $validator->errors()
                        ], 422);
                    }
            
                    if (!Hash::check($request->input('password'), $user->password)) {
                        return response()->json([
                            'status' => false,
                            'message' => 'Password is incorrect.',
                        ], 400);
                    }
                    else{
                        $user->delete();
                        return response()->json(['success'=>true,'message'=>'Account deleted'],200);
                    }
                }
             
            }
        }else{
            return response()->json(['status'=>false,
                                     'message'=>"Please provide an id",
                                      'errors'=>'Id required']);  
        }
    }
  }

