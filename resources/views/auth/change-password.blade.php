@extends('auth.app')

@section('content')
<form method="POST" action="{{ route('password.update') }}" class="p-3">
    @csrf
    @method('PUT')

    <!-- Mật khẩu hiện tại -->
    <div class="input-login">
        <span class="login-1 txt-white">Mật khẩu hiện tại</span>
        <input id="current_password" type="password" name="current_password" required 
        class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
        @error('current_password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Mật khẩu mới -->
    <div class="input-login">
        <span class="login-1 txt-white">Mật khẩu mới</span>
        <input id="password" type="password" name="password" required 
        class="block mt-1 w-full border-gray-300 rounded-2xl shadow-sm">
        @error('password')
            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <!-- Xác nhận mật khẩu -->
    <div class="input-login">
        <span class="login-1 txt-white">Xác nhận mật khẩu</span>
        <input id="password_confirmation" type="password" name="password_confirmation" required 
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
