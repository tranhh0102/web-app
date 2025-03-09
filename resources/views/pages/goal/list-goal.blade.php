@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/charity.css') }}">
@endsection

@section('content')

<!--Header-->
<div class="list-charity-header">
    <a href="{{route('home')}}" class="icons-back">
        <img src="{{asset('svg/arrow-back.svg')}}" alt="">
    </a>
    <h2 class="add-category-header">Mục tiêu</h2>
    <span></span>
</div>

<!--Banner charity-->
<div class="banner-container">
    <img class="banner" src="{{asset('png/Banner.png')}}" alt="">
    <div class="archive">
        <div class="grid">
            <span>
                Congratulations 🎉
            </span>
            <span>
            </span>
        </div>
        <div>
            <img src="{{asset('svg/medal.svg')}}" alt="">
        </div>
    </div>
</div>

<!--Title charity-->
<div>
    <p class="title-header text-center">Những mục tiêu của bạn</p>
</div>

<!--List charity-->
<div class="list-search mb-20">
    @foreach ($data as $goal)
    <div class="items">
        <div class="items-sub">
            <div class="flex items-center gap-2">
                <img style="width: 32px; height: 32px;" src="{{ asset('png/charity.png') }}" alt="">
                <div class="grid">
                    <span class="text-white">Tên : {{$goal['name'] }}</span>
                    <span class="dollar text-white">Tiền mục tiêu : {{number_format($goal['charge'])}}</span>
                </div>
            </div>
            <div>
                <a href="{{ route('add-goal-transaction', ['id' => $goal['id']]) }}">
                    <img src="{{ asset('svg/arrow.svg') }}" alt="">
                </a>
            </div>
        </div>
        @endforeach
    </div>
    @endsection

    <script>
        function toggleFilter() {
            let filterBox = document.getElementById("filter-options");
            filterBox.classList.toggle("hidden");
        }
    </script>