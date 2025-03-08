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
        <h2 class="add-category-header">Cộng đồng</h2>
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
                    {{number_format($totalCharge)}}
                </span>
            </div>
            <div>
                <img src="{{asset('svg/medal.svg')}}" alt="">
            </div>
        </div>
    </div>

    <!--Title charity-->
    <div>
        <p class="title-header text-center">Những đóng góp của bạn</p>
    </div>

    <!--List charity-->
    <div class="list-search mb-20">
        @foreach ($data as $transactions)
            <div class="items">
                <div class="items-sub">
                    <div class="flex items-center gap-2">
                        <img style="width: 32px; height: 32px;" src="{{ asset('png/charity.png') }}" alt="">
                        <div class="grid">
                            <span class="text-white">{{$transactions['name'] }}</span>
                            <span class="dollar text-white">{{number_format($transactions['charge'])}}</span>
                        </div>
                    </div>
                    <span class="dollar text-white">{{ $transactions['created_at'] }}</span>
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