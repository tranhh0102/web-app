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
    <div class="archive">
        <div class="grid">
            <span>Những mục tiêu của bạn 🎉</span>
            <span>Bạn đã hoàn thành : {{$total}}</span>
            <span>Mục tiêu không hoàn thành: {{$totalNotDone}}</span>
        </div>
        <div class="grid justify-items-center">
            <div>
                <img id="medalImg" width="60px" src="{{ asset('svg/home/target.svg') }}" alt="Medal">
            </div>
        </div>
    </div>
</div>
<!--Title charity-->
<!-- <div>
    <p class="title-header text-center">Những mục tiêu của bạn</p>
</div> -->

<!--List charity-->
<div class="list-search mb-20 grid p-3 gap-3">
    @foreach ($data as $goal)
    <div class="items">
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
                    <div style="width: 30vh; background: #444; height: 10px; border-radius: 5px; margin-top: 8px; overflow: hidden;">
                        <div style="width: {{ $percentage }}%; background: #00c853; height: 100%; border-radius: 5px; transition: width 0.5s ease-in-out;"></div>
                    </div>

                    <span class="text-white">{{ round($percentage, 2) }}%</span>

                    @if (\Carbon\Carbon::today() > \Carbon\Carbon::parse($goal['due_date']) && $goal['status'] != 1 )
                        <span class="text-red-500 font-bold">🔥 Hết hạn mục tiêu!</span>
                    @elseif ($goal['status'] == 1)
                        <span class="text-green-500 font-bold">✅ Đã hoàn thành!</span>
                    @endif
                </div>
            </div>

            @if ($goal['status'] == 0 && \Carbon\Carbon::today() > \Carbon\Carbon::parse($goal['due_date']))
            <div>
                <a href="{{ route('add-goal-transaction', ['id' => $goal['id']]) }}">
                    <img src="{{ asset('svg/arrow.svg') }}" alt="">
                </a>
            </div>
            @endif
        </div>
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
@endsection
<script>
    function toggleFilter() {
        let filterBox = document.getElementById("filter-options");
        filterBox.classList.toggle("hidden");
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let goalCompleted = localStorage.getItem("goalCompleted");

        // Kiểm tra nếu có mục tiêu hoàn thành và chưa hiển thị modal trước đó
        if (!goalCompleted && document.getElementById("goal-modal")) {
            document.getElementById("goal-modal").style.display = "flex";

            // Khi nhấn ra ngoài modal thì ẩn đi
            document.getElementById("goal-modal").addEventListener("click", function(event) {
                if (event.target === this) {
                    closeGoalModal();
                }
            });
        }
    });

    function closeGoalModal() {
        document.getElementById("goal-modal").style.display = "none";
        localStorage.setItem("goalCompleted", "true"); // Lưu trạng thái vào localStorage
    }
</script>