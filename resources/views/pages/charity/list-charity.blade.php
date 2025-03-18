@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/charity/list-charity.css') }}">
@endsection

@section('content')

<div class="w-full fixed top-0 z-10 bg-[#1c1c23]">
    <div class="list-charity-header">
        <span></span>
        <h2 class="add-category-header">Cộng đồng</h2>
        <button type="button" class="filter-charity" onclick="toggleFilter()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M11 4H13V7H11V4Z" fill="white" fill-opacity="0.6" />
                <path d="M10 8V11H11V20H13V11H14V8H10Z" fill="white" fill-opacity="0.6" />
                <path d="M6 4H8V12H6V4Z" fill="white" fill-opacity="0.6" />
                <path d="M5 13V16H6V20H8V16H9V13H5Z" fill="white" fill-opacity="0.6" />
                <path d="M16 4H18V14H16V4Z" fill="white" fill-opacity="0.6" />
                <path d="M15 15V18H16V20H18V18H19V15H15Z" fill="white" fill-opacity="0.6" />
            </svg>
        </button>
    </div>


    <!-- Khung lọc (ẩn mặc định) -->
    <div id="filter-options" class="filter-box hidden bg-gray-800 p-4 rounded">
        <label class="block mb-2 text-white">Lọc theo ngày:</label>
        <input type="date" id="filter-date" name="date" value="{{ request('date') }}" class="w-full p-2 rounded bg-gray-700 text-white">

        <button id="apply-filter" class="w-full mt-4 bg-blue-500 hover:bg-blue-600 p-2 rounded text-white">
            Áp dụng
        </button>

        <!-- Nút Xóa bộ lọc -->
        <button id="clear-filters" class="w-full mt-2 bg-red-500 hover:bg-red-600 p-2 rounded text-white">
            Xóa bộ lọc
        </button>
    </div>

    <!--Banner charity-->
    <div class="banner-container">
        <div class="archive">
            <div class="grid">
                <span>Bạn là công dân gương mẫu 🎉</span>
                <span>Tiền bạn đã ủng hộ:</span>
                <span>{{ number_format($totalCharge) }} VNĐ</span>
            </div>
            <div class="grid justify-items-center">
                <div class="contents">
                    @php
                    // Xác định medal & milestone
                    if ($totalCharge <= 500000) {
                        $color='#CD7F32' ; // Đồng
                        $nextMilestone=2000000;
                        $rank='Đồng' ;
                        } elseif ($totalCharge < 2000000) {
                        $color='#C0C0C0' ; // Bạc
                        $nextMilestone=5000000;
                        $rank='Bạc' ;
                        } elseif ($totalCharge < 5000000) {
                        $color='#FFD700' ; // Vàng
                        $nextMilestone=10000000;
                        $rank='Vàng' ;
                        } elseif ($totalCharge < 10000000) {
                        $color='#B9F2FF' ; // Kim Cương
                        $nextMilestone=15000000;
                        $rank='Kim Cương' ;
                        } else {
                        $color='#8B0000' ; // Huyền Thoại
                        $nextMilestone=null;
                        $rank='Huyền Thoại' ;
                        }

                        $progress=($nextMilestone) ? min(100, ($totalCharge / $nextMilestone) * 100) : 100;
                        @endphp

                        <img id="medalImg" width="60px" src="{{ asset('svg/home/medal.svg') }}" alt="Medal">
                        <span>Cấp bậc: <strong style="color: {{ $color }}">{{ $rank }}</strong></span>
                </div>

                <!-- Thanh tiến trình -->
                <div class="progress-container">
                    <div class="progress-bar" style="width: {{ $progress }}%;"></div>
                </div>

                <!-- Hiển thị mốc điểm tiếp theo -->
                @if ($nextMilestone)
                <p class="next-level">Cấp bậc tiếp theo : {{ number_format($nextMilestone) }} VNĐ</p>
                @else
                <p class="next-level">Bạn đã đạt hạng cao nhất!</p>
                @endif
            </div>
        </div>
    </div>

    <!--Title charity-->
    <div>
        <p class="title-header text-center">Những đóng góp của bạn</p>
    </div>
</div>
<!--Header-->


<!--List charity-->
<div class="list-search mb-20 grid p-3  mt-[260px]">
    @foreach ($data as $transactions)
    <div class="items">
        <div class="items-sub">
            <div class="flex items-center gap-2">
                <img style="width: 32px; height: 32px;" src="{{ asset('svg/home/charity.svg') }}" alt="">
                <div class="grid">
                    <span class="text-white">{{ $transactions['name'] }}</span>
                    <span class="dollar text-white">{{ number_format($transactions['charge']) }}</span>
                </div>
            </div>
            <!-- Form xóa -->
            <form action="{{ route('transaction.delete-charity', ['id' => $transactions['id']]) }}" method="POST" onsubmit="return confirmDelete(event)">
                @csrf
                <button type="submit" class="text-red-500 mt-2">
                    <img style="height: 32px; width: 32px;" src="{{ asset('svg/delete.svg') }}" alt="Xóa">
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

<script>
    function toggleFilter() {
        let filterBox = document.getElementById("filter-options");
        filterBox.classList.toggle("hidden");
    }

    function confirmDelete(event) {
        event.preventDefault(); // Ngăn chặn form gửi ngay lập tức

        if (confirm("Bạn có chắc chắn muốn xóa giao dịch này không?")) {
            event.target.submit(); // Nếu xác nhận, tiến hành gửi form
        }
    }

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

    document.getElementById("apply-filter").addEventListener("click", function() {
        let selectedDate = document.getElementById("filter-date").value;

        if (selectedDate) {
            let currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set("date", selectedDate);
            window.location.href = currentUrl.toString();
        }
    });

    document.getElementById("clear-filters").addEventListener("click", function() {
        let currentUrl = new URL(window.location.href);
        currentUrl.searchParams.delete("date");
        window.location.href = currentUrl.toString();
    });
</script>
@endsection