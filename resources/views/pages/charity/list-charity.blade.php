@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('style/charity/list-charity.css') }}">
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
    <div class="archive">
        <div class="grid">
            <span>Congratulations 🎉</span>
            <span>{{ number_format($totalCharge) }} Points</span>
        </div>
        <div class="grid justify-items-center">
        <div>
            @php
                // Xác định medal dựa trên điểm
                if ($totalCharge <= 1000000) {
                    $medal = 'bronze.png';  
                    $nextMilestone = 50000000;
                } elseif ($totalCharge < 50000000) {
                    $medal = 'silver.png';  
                    $nextMilestone = 1000000000;
                } else {
                    $medal = 'gold.png';  
                    $nextMilestone = null;
                }

                $progress = ($nextMilestone) ? min(100, ($totalCharge / $nextMilestone) * 100) : 100;
            @endphp
            <img width="60px" src="{{ asset('png/medal/' . $medal) }}" alt="Medal">
        </div>

        <!-- Thanh tiến trình -->
        <div class="progress-container">
            <div class="progress-bar" style="width: {{ $progress }}%;"></div>
        </div>

        <!-- Hiển thị mốc điểm tiếp theo -->
        @if ($nextMilestone)
            <p class="next-level">Next level: {{ number_format($nextMilestone) }} Points</p>
        @else
            <p class="next-level">You've reached the highest rank! 🎉</p>
        @endif
        </div>
    </div>
</div>


    <!--Title charity-->
    <div>
        <p class="title-header text-center">Những đóng góp của bạn</p>
    </div>

    <!--List charity-->
    <div class="list-search mb-20 grid p-3">
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