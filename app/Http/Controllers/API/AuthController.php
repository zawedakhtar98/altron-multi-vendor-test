<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller; 
class AuthController extends Controller
{    

    public function login(Request $request)
    {     
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validator->errors()
            ], 422);
        }

        try{

            $user = User::where('email', $request->email)->first();

            if(!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(
                    ['message' => 'Invalid Credentials','status' => 'fail'
                ], 401);
            }

            $token = $user->createToken('api-token')->plainTextToken;

            return response()->json([
                'message' => 'Login Successful',
                'status' => 'success',
                'data' => $user,
                'token' => $token,
            ]);
        }
        catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong, please try again later.',
                'status' => 'fail',
            ], 500);
        }
    }

    public function register(Request $request)
    {        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,seller,customer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'fail',
                'errors' => $validator->errors()
            ], 422);
        }
        
        try{
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'User Registered Successfully',
            'status' => 'success',
            'data' => $user,
            'token' => $token,
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went wrong, please try again later.',
                'status' => 'fail',
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully','status' => 'success']);
    }
}