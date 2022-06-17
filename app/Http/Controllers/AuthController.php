<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){

        // Validat request
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        // Create user in the database
        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])   
        ]);

        // Create token
        $token = $user->createToken('upaymentsToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 201);
    }   

    public function login(Request $request){

        // Validate request
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

       // Get user
       $user = User::where('email', $fields['email'])->first();

       // Check if user exists and Password Hash is matched
       if(!$user || !Hash::check($fields['password'], $user->password)){
        $response = [
            'message' => 'Invalid Credentials'
        ];
        
        return response($response, 401);
       }

       // Create token
        $token = $user->createToken('upaymentsToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response($response, 200);
    } 

    public function logout(Request $request){
        
        // Delete token
        auth()->user()->tokens()->delete();

        $response = [
            'message' => 'Logged out'
        ];
        
        return response($response, 200);
    }
}
