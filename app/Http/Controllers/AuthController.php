<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login()
    {
        return view('login');
    }

public function verifyUser(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],
[
            'email.required' => 'Please enter your email',
            'email.email' => 'Please enter a valid email address',
            'password.required' => 'Please enter your password',
        ]
        
    );

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $roleRedirects = [
            'admin' => 'admin.dashboard',
            'seller' => 'seller.dashboard',
            'customer' => 'product',
        ];
        $route = $roleRedirects[$user->role] ?? 'product';
            return redirect()->route($route)->with('success', 'Login Successful');
        } else {
            return redirect()->back()->with('error', 'Invalid Credentials');
        }
    }

    public function register()
    {
        return view('register');
    }

    public function SaveUsers(Request $request){
        try{
            
            $request->validate([
                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6',            
            ]);
    
             $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>$request->password,
                'role' => 'customer', 
            ]); 

            Auth::login($user);
            return redirect()->route('product')->with('success','User Registered Successfully');  
        }
        catch(\Exception $e){
            return redirect()->route('register')->with('error',"Something went wrong ".$e->getMessage());
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
    
}
