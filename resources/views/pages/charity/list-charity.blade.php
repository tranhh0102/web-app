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
            <span>Chúc mừng bạn 🎉</span>
            <span>Tiền bạn đã ủng hộ:</span>
            <span>{{ number_format($totalCharge) }} VNĐ</span>
        </div>
        <div class="grid justify-items-center">
        <div>
        @php
            // Xác định medal & milestone
            if ($totalCharge <= 500000) {
                $color = '#CD7F32';
                $nextMilestone = 2000000;
            } elseif ($totalCharge < 2000000) {
                $color = '#C0C0C0'; 
                $nextMilestone = 5000000;
            } elseif ($totalCharge < 5000000) {
                $color = '#FFD700'; 
                $nextMilestone = 10000000;
            } elseif ($totalCharge < 10000000) {
                $color = '#B9F2FF'; 
                $nextMilestone = 15000000;
            } else {
                $color = '#8B0000'; 
                $nextMilestone = null;
            }

            $progress = ($nextMilestone) ? min(100, ($totalCharge / $nextMilestone) * 100) : 100;
        @endphp

            <img id="medalImg" width="60px" src="{{ asset('svg/home/medal.svg') }}" alt="Medal">
        </div>

        <!-- Thanh tiến trình -->
        <div class="progress-container">
            <div class="progress-bar" style="width: {{ $progress }}%;"></div>
        </div>

        <!-- Hiển thị mốc điểm tiếp theo -->
        @if ($nextMilestone)
            <p class="next-level">Cấp tiếp theo : {{ number_format($nextMilestone) }} VNĐ</p>
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
                    <img style="width: 32px; height: 32px;" src="{{asset('svg/home/charity.svg')}}" alt="">
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetch("{{ asset('svg/home/medal.svg') }}")
            .then(response => response.text())
            .then(svgData => {
                let container = document.createElement("div");
                container.innerHTML = svgData;
                let svg = container.querySelector("svg");

                // Đổi màu fill
                svg.querySelector("path").setAttribute("fill", "{{ $color }}");

                // Thay thế <img> bằng SVG
                document.getElementById("medalImg").replaceWith(svg);
            });
    });
</script>