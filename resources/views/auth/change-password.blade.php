@extends('auth.app')

@section('styles')
    <link rel="stylesheet" href="{{ asset('style/auth/change-password.css') }}">
@endsection

@section('content')

<div class="add-expenses-header">
    <a href="{{route('profile.edit')}}" class="icons-back">
            <img src="{{asset('svg/arrow-back.svg')}}" alt="">
    </a>
    <span class="add-expenses-title">Đổi mật khẩu</span>
    <span></span>
</div>
<form method="POST" action="{{ route('password.update') }}">
    @csrf
    @method('PUT')

    <!-- Mật khẩu hiện tại -->
    <div class="input-login relative">
        <span class="password txt-white">Mật khẩu hiện tại</span>

        <div class="relative w-full">
            <input id="current_password" type="password" name="current_password" required 
            class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">

            <!-- Icon mắt -->
            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePassword('current_password', 'eyeIcon1')">
                <svg id="eyeIcon1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </span>
        </div>

        @error('current_password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Mật khẩu mới -->
    <div class="input-login relative">
        <span class="password txt-white">Mật khẩu mới</span>

        <div class="relative w-full">
            <input id="password" type="password" name="password" required 
            class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">

            <!-- Icon mắt -->
            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePassword('password', 'eyeIcon2')">
                <svg id="eyeIcon2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </span>
        </div>

        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Xác nhận mật khẩu -->
    <div class="input-login relative">
        <span class="password txt-white">Xác nhận mật khẩu</span>

        <div class="relative w-full">
            <input id="password_confirmation" type="password" name="password_confirmation" required 
            class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">

            <!-- Icon mắt -->
            <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer" onclick="togglePassword('password_confirmation', 'eyeIcon3')">
                <svg id="eyeIcon3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5 text-gray-500">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
            </span>
        </div>

        @error('password_confirmation')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid items-center justify-center mt-4">    
        <button class="button-register mb-[10px]" type="submit">
            <span class="get-started">Cập nhật mật khẩu</span>
        </button>
    </div>
</form>

<script>
    function togglePassword(inputId, iconId) {
        let passwordInput = document.getElementById(inputId);
        let eyeIcon = document.getElementById(iconId);

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2 12s2-4 10-4 10 4 10 4-2 4-10 4-10-4-10-4z"></path>
                <line x1="2" y1="2" x2="22" y2="22" stroke="currentColor" stroke-width="2"></line>
            `;
        } else {
            passwordInput.type = "password";
            eyeIcon.innerHTML = `
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
            `;
        }
    }
</script>
@endsection
