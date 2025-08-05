@extends('layout.app')
@section('title', 'Sign Up')
@section('custom-css') <link href="{{asset('assets/css/register.css')}}" rel="stylesheet"> @endsection
@section('main')

    <div class="register-card">
        @if(session()->has('error'))
        <div class="alert alter-danger"><span>{{session('error')}}</span>
        </div>
        @elseif(session()->has('success'))
        <div class="alert alter-success"><span>{{session('success')}}</span>
        </div>
        @endif
        <form method="post" action="{{route('register')}}" id="sign-up">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
                <span class="text-danger">@error('name') {{$message}}
                @enderror</span>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                <span class="text-danger">@error('email') {{$message}}
                    @enderror</span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter password" required>
                <span class="text-danger">@error('password') {{$message}}
                    @enderror</span>
            </div>
            <input type="hidden" name="user_role" value="admin">
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
        <p class="text-center mt-3">
            Already have an account? <a href="{{route('login')}}">Login</a>
        </p>
    </div>


@endsection