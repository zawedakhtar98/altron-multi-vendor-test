<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class PassportController extends Controller
{
    public function login(Request $request)
    {
        Log::info($request->all());
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // dd($credentials);
        $admin = Admin::where('email', $credentials['email'])->first();
        if ($admin && Hash::check($credentials['password'], $admin->password)) {
            $token = $admin->createToken('AdminToken')->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'Login successfully!',
                'data' => $admin,
                'token' => $token,
            ]);
        }
        return response()->json(['stauts' => false, 'message' => 'Invalid credential'], 401);
    }
    public function index()
    {
        $data = Admin::all();
        $admin = Admin::find(1);
        $token = $admin->createToken('AdminToken')->accessToken;
        return response()->json([
            'status' => true,
            'message' => 'Fetch successfully!',
            'data' => $data,
            'token' => $token,
        ]);
    }

    public function register(Request $request)
    {
        Log::info($request->file('profile'));
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|max:60',
            'profile' => 'required|mimes:jpg,png|max:1024'
        ]);

        try {
            if ($request->hasFile('profile')) {
                Log::info('test');
                $path = $request->file('profile')->store('avtars');
            } else {
                Log::info('fail');
            }
            $user = Admin::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'role' => 'admin',
                'password' => Hash::make($data['password']),
                'profile' => $path
            ]);
            $token = $user->createToken('adminnewtoken')->accessToken;
            return response()->json([
                'status' => true,
                'message' => 'Register successfull!',
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Something went wrong! ' . $e->getMessage()
            ]);
        }
        Log::info('passw');
    }

    public function logout(Request $request)
    {
        // $request->user('api') is equivalent to auth('api')->user()
        try {
            Log::info('start');
            $user = $request->user('api');
            Log::info($user);
            if (!$user) {
                Log::info('user not found');
                return response()->json([
                    'status'  => false,
                    'message' => 'Unauthenticated.'
                ], 401);
            }
            $token = $user->token()->revoke();
            return response()->json([
                'status'  => true,
                'message' => 'Logout successfully!'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthenticated. '.$th->getMessage()
            ], 401);
        }
    }
}
