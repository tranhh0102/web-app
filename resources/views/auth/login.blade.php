@extends('auth.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('style/auth/login.css') }}">
@endsection

@section('content')
    @if (session('status'))
    <div class="mb-4 text-green-600">
        {{ session('status') }}
    </div>
    @endif
    <form method="POST" action="{{ route('login') }}">
    @csrf
        <div class="input-login">
            <span class="login-1 txt-white">Email</span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="input-password">
            <span class="password txt-white">Password</span>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex-row-c">
            <a href="{{ route('password.request') }}" class="forgot-password">Forgot password ?</a>
        </div>
        <div class="p-3">
            <button class="button" type="submit"><span class="get-started">Sign In</span></button>
        </div>
    </form>
  
    <span class="no-account">If you don't have an account yet?</span>
    <div class="p-3">
        <button class="button-4"><a  href="{{ route('register') }}" class="sign-up">Sign Up</a></button>
    </div>
@endsection