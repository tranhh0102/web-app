@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/goal/detail-goal-transaction.css') }}">
@endsection

@section('content')
<div class="add-expenses-header">
    <a href="{{route('list-goal')}}" class="icons-back">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <g clip-path="url(#clip0_32_4598)">
                <path d="M17.1699 24C17.0383 24.0007 16.9078 23.9755 16.786 23.9257C16.6641 23.876 16.5533 23.8027 16.4599 23.71L8.28986 15.54C7.82423 15.0755 7.4548 14.5238 7.20274 13.9163C6.95067 13.3089 6.82092 12.6577 6.82092 12C6.82092 11.3423 6.95067 10.6911 7.20274 10.0837C7.4548 9.4762 7.82423 8.92445 8.28986 8.45999L16.4599 0.290002C16.5531 0.196764 16.6638 0.122803 16.7856 0.0723425C16.9074 0.0218822 17.038 -0.00408935 17.1699 -0.00408936C17.3017 -0.00408936 17.4323 0.0218822 17.5541 0.0723425C17.6759 0.122803 17.7866 0.196764 17.8799 0.290002C17.9731 0.38324 18.0471 0.49393 18.0975 0.615752C18.148 0.737574 18.174 0.868142 18.174 1C18.174 1.13186 18.148 1.26243 18.0975 1.38425C18.0471 1.50607 17.9731 1.61676 17.8799 1.71L9.70986 9.87999C9.14806 10.4425 8.8325 11.205 8.8325 12C8.8325 12.795 9.14806 13.5575 9.70986 14.12L17.8799 22.29C17.9736 22.3829 18.048 22.4935 18.0988 22.6154C18.1495 22.7373 18.1757 22.868 18.1757 23C18.1757 23.132 18.1495 23.2627 18.0988 23.3846C18.048 23.5064 17.9736 23.617 17.8799 23.71C17.7864 23.8027 17.6756 23.876 17.5538 23.9257C17.4319 23.9755 17.3015 24.0007 17.1699 24Z" fill="#A2A2B5" />
            </g>
            <defs>
                <clipPath id="clip0_32_4598">
                    <rect width="24" height="24" fill="white" />
                </clipPath>
            </defs>
        </svg>
    </a>
    <span class="add-expenses-title">Chi tiết mục tiêu</span>
    <span></span>
</div>
@php
use Carbon\Carbon;
$previousDate = null;
@endphp

<div class="list-search mb-20">
    @forelse ($data as $transaction)
    @php
    $currentDate = Carbon::parse($transaction->created_at)->format('Y-m-d');
    @endphp

    @if ($currentDate !== $previousDate)
    <h2 class="text-white font-bold pl-3">{{ $currentDate }}</h2>
    @php $previousDate = $currentDate; @endphp
    @endif

    <div class="items">
        @if (!empty($transaction))
        <div class="items-sub items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('svg/home/goal.svg') }}" alt="income">
                <div class="grid">
                    <span class="text-white">{{ $transaction->goal->name }}</span>
                    <span class="receive">{{ number_format($transaction->charge) }} VND</span>
                </div>
            </div>
            <form class="m-0" action="{{route('transaction.delete-goal-transaction',['id' => $transaction['id'] ])}}" method="POST" onsubmit="return confirmDelete(event)">
                @csrf
                <button type="submit" class="text-red-500">
                    <img src="{{ asset('svg/delete.svg') }}" alt="Xóa">
                </button>
            </form>
        </div>
        @else
        <p class="title-header text-center">Không có dữ liệu</p>
        @endif
    </div>
    @empty
    <p class="title-header text-center">Không có dữ liệu</p>
    @endforelse
</div>
@endsection

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
</script>