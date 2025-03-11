@extends('auth.app')

@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ request()->route('token') }}">

        <!-- Email Address -->
        <div>
            <label for="email">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', request()->email) }}" required autofocus autocomplete="username">
            @error('email')
                <p class="mt-2 text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password">
            @error('password')
                <p class="mt-2 text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password">
            @error('password_confirmation')
                <p class="mt-2 text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-end mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection
