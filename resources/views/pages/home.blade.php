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
<div class="home-header">
    <span class="home-title">Thống kê</span>
</div>
<div class="stastic">
    <div class="grid gap-3 w-full">
        <div class="active-subs">
            <span class="active-subs-title">Thu nhập</span>
            <span class="receive">$19.99</span>
        </div>
        <div class="active-subs">
            <span class="active-subs-title">Chi tiêu</span>
            <span class="cost">$19.99</span>
        </div>
    </div>
    <div class="grid gap-3 w-full">
        <div class="active-subs">
            <span class="active-subs-title">Thu nhập</span>
            <span class="receive">$19.99</span>
        </div>
        <div class="active-subs">
            <span class="active-subs-title">Chi tiêu</span>
            <span class="cost">$19.99</span>
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
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <img style="width: 32px; height: 32px;" src="{{asset('png/salary.png')}}" alt="">
                    <span class="text-white">income</span>
                </div>
                <span class="dollar text-green-400">$10.00</span>
            </div>
        </div>
    </div>

    <div id="expense" class="tab-content">
        <div class="items">
            <div class="items-sub">
                <div class="flex items-center gap-2">
                <img style="width: 32px; height: 32px;" src="{{asset('png/spending.png')}}" alt="">
                    <span class="text-white">spent</span>
                </div>
                <span class="dollar text-red-400">$5.99</span>
            </div>
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
</script>