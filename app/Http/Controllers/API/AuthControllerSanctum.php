<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthControllerSanctum extends Controller
{

    public function register(Request $request){
        $registerUserData  = $request->validate([
            'name'=>'required|string',
            'email'=>'required|string|email|unique:users',
            'password'=>'required|min:8'
        ]);

        $user = User::create([
            'name'=>$registerUserData['name'],
            'email'=>$registerUserData['email'],
            'password'=>$registerUserData['password'],
        ]);

        $token = $user->createToken('my-token')->plainTextToken;

        return response([
            'message'=>'User created successfull!',
            'token'=>$token,
            'user'=>$user
        ],201);
    }

    public function login(Request $request){
        // dd($request->all());
        
        $userLoing = $request->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $user=  User::where('email',$userLoing['email'])->first();
        if(!$user || !Hash::check($userLoing['password'],$user->password)){
            return response([
                'status'=>false,
                'message'=>'Credential not match!'
            ],401);
        }
        $token = $user->createToken('myapptoken')->plainTextToken;
        return response([
                'status'=>true,
                'message'=>'Login success!',
                'token'=>$token
            ],200);

    }
}
