@extends('auth.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('style/auth/login.css') }}">
@endsection

@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

         <!-- Email Address -->
         <div class="input-password">
            <span class="login-1 txt-white">Email</span>
            <input id="email" type="email" name="email" value="{{ old('email', request()->email) }}" required autofocus autocomplete="username"
                class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('email')
            <p class="mt-2 text-sm text-red-600" style="color: white !important;">Link reset của bạn đã sử dụng hoặc hết hạn</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-password">
            <span class="password txt-white">Mật khẩu mới</span>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="input-password">
            <span class="password txt-white">Xác nhận mật khẩu</span>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid items-center justify-center mt-4">    
            <button class="button-register mb-[10px]" type="submit">
                <span class="get-started">Cập nhật mật khẩu</span>
            </button>
        </div>
    </form>
@endsection
