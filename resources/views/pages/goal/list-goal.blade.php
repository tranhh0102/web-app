@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/charity.css') }}">
@endsection

@section('content')

<div class="w-full fixed top-0 z-10">
<!--Header-->
<div class="list-charity-header">
    <span></span>
    <h2 class="add-category-header">Mục tiêu</h2>
    <button type="button" class="filter" onclick="toggleFilter()">
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

    <form action="{{ route('list-goal') }}" method="GET" id="form-filter-goal">
        <div id="filter-options" class="filter-box p-4 rounded hidden" style="background: white;">
            <label class="block mb-2 text-white">Lọc theo trạng thái:</label>
            <select name="status" class="w-full p-2 rounded bg-gray-700 text-white" id="filter-status">
                <option value="">Tất cả</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Đang thực hiện</option>
                <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Hết hạn</option>
            </select>

            <!-- Nút Xóa bộ lọc -->
            <a href="{{ route('list-goal') }}" class="w-full block mt-2 text-center bg-red-500 hover:bg-red-600 p-2 rounded text-color-white">
                Xóa bộ lọc
            </a>
        </div>
    </form>

    <!--Banner charity-->
    <div class="banner-container">
        <div class="archive">
            <div class="grid">
                <span>Những mục tiêu của bạn 🎉</span>
                <span>Bạn đã hoàn thành : {{$total}}</span>
            </div>
            <div class="grid justify-items-center">
                <div>
                    <img id="medalImg" width="60px" src="{{ asset('svg/home/target.svg') }}" alt="Medal">
                </div>
            </div>
        </div>
    </div>
</div>

<!--List charity-->
<div class="list-search mb-20 grid p-3 gap-3 mt-[160px]">
    @foreach ($data as $goal)
    <div class="items">
        <a href="{{ ($goal['status'] == 0 && \Carbon\Carbon::today() <= \Carbon\Carbon::parse($goal['due_date'])) 
            ? route('add-goal-transaction', ['id' => $goal['id']]) 
            : route('transaction.list-goal', ['id' => $goal['id']]) }}">
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <img style="width: 32px; height: 32px;" src="{{asset('svg/home/goal.svg')}}" alt="">
                    <div class="grid">
                        <span class="text-white">Tên: {{$goal['name'] }}</span>
                        <span class="text-white">Thời hạn: {{$goal['due_date'] }}</span>
                        <span class="dollar text-white">
                            Tiền mục tiêu: {{ number_format($goal->goalTransactions->sum('charge')) }} / {{ number_format($goal['charge']) }}
                        </span>

                        @php
                        $totalCharge = $goal->goalTransactions->sum('charge');
                        $targetCharge = $goal['charge'];
                        $percentage = $targetCharge > 0 ? ($totalCharge / $targetCharge) * 100 : 0;
                        @endphp

                        <!-- Thanh tiến trình -->
                        <div style="width: 100%; background: #444; height: 10px; border-radius: 5px; margin-top: 8px; overflow: hidden;">
                            <div style="width: {{ $percentage }}%; background: #00c853; height: 100%; border-radius: 5px; transition: width 0.5s ease-in-out;"></div>
                        </div>

                        <span class="text-white">{{ round($percentage, 2) }}%</span>

                        @if ($percentage >= 100)
                        <span class="text-red-500 font-bold">🔥 Hoàn thành mục tiêu!</span>
                        @elseif (\Carbon\Carbon::today() > \Carbon\Carbon::parse($goal['due_date']))
                        <span class="text-red-500 font-bold">🔥 Hết hạn mục tiêu!</span>
                        @endif
                    </div>
                </div>

                @if ($goal['status'] == 0 && \Carbon\Carbon::today() <= \Carbon\Carbon::parse($goal['due_date']))
                    <div class="flex gap-2">
                    <!-- Nút xóa -->
                    <form action="{{route('transaction.delete-goal',['id' => $goal['id'] ])}}" method="POST" onsubmit="return confirmDelete(event)">
                        @csrf
                        <button type="submit" class="text-red-500">
                            <img src="{{ asset('svg/delete.svg') }}" alt="Xóa">
                        </button>
                    </form>
                    <!-- Nút chuyển trang -->
                    <a href="{{ route('transaction.list-goal', ['id' => $goal['id']]) }}">
                        <img src="{{ asset('svg/arrow.svg') }}" alt="">
                    </a>
            </div>
            @endif
    </div>
    </a>
</div>

@if ($goal['stauts'] == 1)
<div id="goal-modal" class="modal">
    <div class="modal-content">
        <p>🎉 Chúc mừng! Bạn đã đạt được mục tiêu! 🎯</p>
        <button onclick="closeGoalModal()">Đóng</button>
    </div>
</div>
@endif
@endforeach

</div>

<script>
    function toggleFilter() {
        let filterBox = document.getElementById("filter-options");
        filterBox.classList.toggle("hidden");
    }

     document.getElementById('filter-status').addEventListener('change', function() {
        let filterBox = document.getElementById("filter-options");
        filterBox.classList.add('hidden');
        document.getElementById('form-filter-goal').submit();
    })

    function confirmDelete(event) {
        event.preventDefault(); // Ngăn chặn form gửi ngay lập tức

        if (confirm("Bạn có chắc chắn muốn xóa giao dịch này không?")) {
            event.target.submit(); // Nếu xác nhận, tiến hành gửi form
        }
    }
</script>
@endsection