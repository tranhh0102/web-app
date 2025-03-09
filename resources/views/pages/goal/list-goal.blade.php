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
<div class="list-search mb-20 grid p-3">
    @foreach ($data as $goal)
    <div class="items">
        <div class="items-sub">
            <div class="flex items-center gap-2">
                <img style="width: 32px; height: 32px;" src="{{ asset('png/goal.png') }}" alt="">
                <div class="grid">
                    <!-- Hiển thị tên mục tiêu -->
                    <span class="text-white">Tên: {{$goal['name'] }}</span>

                    <!-- Hiển thị số tiền đã đạt được / số tiền mục tiêu -->
                    <span class="dollar text-white">
                        Tiền mục tiêu: {{ number_format($goal->goalTransactions->sum('charge')) }} / {{ number_format($goal['charge']) }}
                    </span>

                    @php
                    // Tính tổng số tiền đã chi tiêu từ các giao dịch
                    $totalCharge = $goal->goalTransactions->sum('charge');

                    // Lấy số tiền mục tiêu
                    $targetCharge = $goal['charge'];

                    // Tính phần trăm tiến trình
                    $percentage = $targetCharge > 0 ? ($totalCharge / $targetCharge) * 100 : 0;
                    @endphp

                    <!-- Thanh tiến trình -->
                    <div style="width: 100%; background: #444; height: 10px; border-radius: 5px; margin-top: 8px; overflow: hidden;">
                        <div style="width: {{ $percentage }}%; background: #00c853; height: 100%; border-radius: 5px; transition: width 0.5s ease-in-out;"></div>
                    </div>

                    <!-- Hiển thị phần trăm đạt được -->
                    <span class="text-white">{{ round($percentage, 2) }}%</span>

                    <!-- Hiển thị thông báo chúc mừng nếu đạt 100% -->
                    @if ($percentage >= 100)
                        <div id="toast-container">
                            <div class="toast-success">
                                🎉 Chúc mừng! Bạn đã đạt được mục tiêu! 🎯
                            </div>
                        </div>
                    @endif
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