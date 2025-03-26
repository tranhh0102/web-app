@extends('auth.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('style/auth/login.css') }}">
@endsection

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        
        <!-- Name -->
        <div class="input-login">
            <span class="login-1 txt-white">Họ và tên</span>
            <input id="name" type="text" name="name" value="{{ old('name') }}" autofocus autocomplete="name"
            class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('name')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Email Address -->
        <div class="input-password">
            <span class="login-1 txt-white">Email</span>
            <input id="email" type="email" name="email" value="{{ old('email') }}" autofocus autocomplete="username"
                class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('email')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Password -->
        <div class="input-password">
            <span class="password txt-white">Mật khẩu</span>
            <input id="password" type="password" name="password" autocomplete="current-password"
                class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <!-- Confirm Password -->

        <div class="input-password">
            <span class="password txt-white">Xác nhận mật khẩu</span>
            <input id="password_confirmation" type="password" name="password_confirmation" autocomplete="new-password"
                    class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
            @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        
        <div class="grid items-center justify-center mt-4">    
                <button class="button-register mb-[10px]" type="submit">
                    <span class="get-started">Đăng ký</span>
                </button>
                <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md txt-white">
                    Bạn có tài khoản rồi à? Vui lòng đăng nhập.
                </a>
        </div>
       
    </form>
@endsection