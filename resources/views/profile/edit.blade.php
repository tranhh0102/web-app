@extends('layouts.master')
@section('styles')
    <link rel="stylesheet" href="{{ asset('style/profile.css') }}">
@endsection
@section('content')
    <div class="general">
        <span class="general-2">General</span>
        <div class="auto-layout-vertical-1">
          <div class="security">
            <span class="security-2">Security</span>
            <div class="icons-faceid"></div>
            <div class="auto-layout-horizontal">
              <span class="face-id">FaceID</span>
              <div class="icons-arrow-medium"></div>
            </div>
          </div>
          <div class="frame">
            <div class="switch"></div>
            <span class="icloud-sync">iCloud Sync</span>
            <div class="icons-icloud"></div>
          </div>
        </div>
      </div>
@endsection