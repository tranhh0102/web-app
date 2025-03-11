@extends('auth.app')

@section('title', 'Verify Email')

@section('content')
    <div class="w-full max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-lg font-semibold text-gray-800">Verify Your Email</h2>
        
        <p class="mt-2 text-sm text-gray-600">
            Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. 
            If you didn’t receive the email, we will gladly send you another.
        </p>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 p-2 text-sm text-green-600 bg-green-100 rounded">
                A new verification link has been sent to the email address you provided during registration.
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Resend Verification Email
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-600 underline hover:text-gray-900">
                    Log Out
                </button>
            </form>
        </div>
    </div>
@endsection
