@extends('layout.app')
@section('title', 'Sign In') 
@section('custom-css') <link href="{{asset('assets/css/register.css')}}" rel="stylesheet"> @endsection
@section('main')

    <div class="register-card">
        @if (session()->has('error'))
            <div class="alert alert-danger text-center" role="alert">
                <span>{{ session('error') }}</span>
            </div>
                
        @endif
        <form method="post" action="{{route('login')}}" id="sign-in">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                <span class="text-danger">@error('email') {{$message}} @enderror</span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password">
                <span class="text-danger">@error('password') {{$message}} @enderror</span>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <p class="text-center mt-3">
            Create an account? <a href="{{route('register')}}">Register</a>
        </p>
    </div>


@endsection

@section('javascript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
<script>
    $( "#sign-in" ).validate({
    rules: {
        email: {
        required: true,
        email:true
        },
        password: {
        required: true,
        minlength: 6
        }
    },
    messages:{
        email: {
        required: "Please enter your email",
        email: "Please enter a valid email"
        },
        password: {
        required: "Please enter your password",
        minlength: "Password must be at least 6 characters"
        }
    },
    submitHandler: function(form) {
        form.submit();
    }
});

@endsection