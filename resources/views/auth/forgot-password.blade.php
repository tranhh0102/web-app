@extends('auth.app')
@section('styles')
    <link rel="stylesheet" href="{{ asset('style/auth/forgot-password.css') }}">
@endsection
@section('content')
<div class="w-full max-w-md mx-auto mt-10 p-3">
    <div class="mb-4 text-sm text-white italic">
        Bạn đã quên mật khẩu? Không vấn đề gì. Hãy cho chúng tôi email của bạn để gửi yêu cầu thay đổi mật khẩu.
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
            <button class="btn-request" type="submit"><span class="get-started">Gửi yêu cầu quên mật khẩu</span></button>
        </div>
        <div class="flex-row-c">
            <a href="{{ route('login') }}" class="back-to-login">Bạn vẫn còn nhớ mật khẩu? <br> Quay lại trang đăng nhập.</a>
        </div>
    </form>
</div>
@endsection