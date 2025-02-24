@extends('layouts.master')
@section('content')
<header class="bg-white shadow">
<nav>
                <ul>
                    <li><a href="{{ route('profile.edit') }}" class="text-blue-600 hover:underline">{{ __('Profile') }}</a></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-red-600 hover:underline">{{ __('Log Out') }}</button>
                        </form>
                    </li>
                </ul>
            </nav>
    </header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                </div>
            </div>
        </div>
    </div>
@endsection