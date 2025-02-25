@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/profile.css') }}">
@endsection

@section('content')
  <div class="flex-row">
    <div class="icons-back">></div>
    <span class="settings-1">Settings</span>
  </div>

  <div class="avatar">
    <div class="image"></div>
  </div>

  <div class="general">
    <span class="general-2">General</span>
    <div class="auto-layout-vertical">
      <div class="auto-layout-vertical-3">
        <div class="security">
          <span class="security-4">Security</span>
          <div class="icons-faceid"></div>
          <div class="auto-layout-horizontal">
            <span class="faceid">FaceID</span>
            <div class="icons-arrow-medium"></div>
          </div>
        </div>
        <div class="frame">
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-red-700 hover:underline">{{ __('Log Out') }}</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection