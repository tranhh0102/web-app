@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/home.css') }}">
@endsection

@section('content')
<!-- <div class="balance-container ">
        <div class="balance">
            <span class="">Số dư đầu</span>
            <span class="">1.000.000</span>
        </div>
        <div class="balance">
            <span class="">Số dư cuối</span>
            <span class="">300.000</span>
        </div>
    </div> -->
@if(session('success'))
<div id="toast-message" class="alert alert-success fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg">
    {{ session('success') }}
</div>
@endif
<div class="home-header">
    <span class="home-title">Trang chủ</span>
</div>
<div class="stastic">
    <div class="grid gap-3 w-full">
        <div class="active-subs">
            <span class="active-subs-title">Thu nhập</span>
            <span class="receive">{{$totalIncomes}}</span>
        </div>
        <div class="active-subs">
            <span class="active-subs-title">Chi tiêu</span>
            <span class="cost">{{$totalExpenses}}</span>
        </div>
    </div>
    <div class="grid gap-3 w-full">
        <div class="active-subs">
            <span class="active-subs-title">Những đóng góp của bạn</span>
            <span class="receive">{{$totalCharity}}</span>
        </div>
        <div class="active-subs">
            <span class="active-subs-title">Những mục tiêu của bạn</span>
            <span class="cost">{{$totalGoal}}</span>
        </div>
    </div>
</div>
<p class="title-header text-center">Danh sách thu chi tháng này</p>
<div class="flex-row-b">
    <div class="tabs">
        <div>
            <button class="tab-button active" onclick="openTab(event, 'income')">Thu nhập</button>
            <button class="tab-button" onclick="openTab(event, 'expense')">Chi tiêu</button>
        </div>
    </div>

    <div id="income" class="tab-content active">
        <div class="items">
            @forelse($dataIncomes as $item)
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <div>
                        <img style="width: 32px; height: 32px;" src="{{asset('png/income.png')}}" alt="">
                    </div>
                    <div class="grid gap-1">
                        <span class="text-white">{{$item->name}}</span>
                        <span class="dollar text-green-400">{{ number_format($item->charge) }}</span>
                    </div>
                </div>
                <div>
                    <a href="{{route('transaction.update-income', ['id' => $item->id])}}">
                        <img src="{{asset('svg/arrow.svg')}}" alt="">
                    </a>
                </div>
            </div>
            @empty
            <p class="title-header text-center">No data</p>
            @endforelse
        </div>
    </div>

    <div id="expense" class="tab-content">
        <div class="items">
            @forelse($dataExpenses as $item)
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <div>
                        <img style="width: 32px; height: 32px;" src="{{asset('png/spending.png')}}" alt="">
                    </div>
                    <div class="grid gap-1">
                        <span class="text-white">{{$item->name}}</span>
                        <span class="dollar text-red-400">{{ number_format($item->charge) }}</span>
                    </div>
                </div>
                <div>
                    <a href="{{route('transaction.update-expense', ['id' => $item->id])}}">
                        <img src="{{asset('svg/arrow.svg')}}" alt="">
                    </a>
                </div>
            </div>
            @empty
            <p class="title-header text-center">No data</p>
            @endforelse
        </div>
    </div>
</div>
@endsection

<style>
    .tabs {
        display: flex;
        justify-content: center;
        gap: 12px;
        align-items: center;
        padding: 12px;
    }

    .tab-button {
        padding: 10px 20px;
        cursor: pointer;
        border: none;
        background: #333;
        color: white;
        border-radius: 12px;
    }

    .tab-button.active {
        background: #555;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
</style>

<script>
    function openTab(event, tabId) {
        document.querySelectorAll('.tab-content').forEach(tab => tab.classList.remove('active'));
        document.querySelectorAll('.tab-button').forEach(button => button.classList.remove('active'));
        document.getElementById(tabId).classList.add('active');
        event.currentTarget.classList.add('active');
    }

    setTimeout(() => {
        document.getElementById('toast-message').style.display = 'none';
    }, 3000);
</script>
