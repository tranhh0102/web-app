@extends('auth.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('style/auth/forgot-password.css') }}">
@endsection
@section('content')
<div class="w-full max-w-md mx-auto mt-10 p-3">
    <div class="mb-4 text-sm text-white italic">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    @if (session('status'))
    <p class="mb-4 text-sm text-green-600">{{ session('status') }}</p>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-sm txt-white font-bold">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
            @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-center mt-4">
            <button class="btn-request" type="submit"><span class="get-started">{{ __('Email Password Reset Link') }}</span></button>
        </div>
        <div class="flex-row-c">
            <a href="{{ route('login') }}" class="back-to-login">Didn't want to request a password request? <br> Back to login page</a>
        </div>
    </form>
</div>
@endsection