@extends('auth.app')

@section('title', 'Verify Email')

@section('content')
    <div class="w-full max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800">Xác nhận email</h2>
        
        <p class="mt-2 text-sm text-gray-600">
            Cảm ơn bạn vì đã đăng ký. Vui lòng vào email và xác nhận tài khoản của bạn để có thể tiếp tục sử dụng dịch vụ.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 p-2 text-sm text-green-600 bg-green-100 rounded">
                Đã có một link xác nhận gửi vào email của bạn. Vui lòng xác nhận để có thể tiếp tục sử dụng dịch vụ.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Gửi lại
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 underline hover:text-gray-900">
                    Đăng nhập
                </button>
            </form>
        </div>
    </div>
@endsection
