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
            <button class="tab-button active" onclick="openTab(event, 'income')">Thu</button>
            <button class="tab-button" onclick="openTab(event, 'expense')">Chi</button>
        </div>
        <div class="justify-end">
            <a href="{{route('home-search')}}" class="icons-back">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M19.7 18.3L15.5 14.1C15.3 13.9 15 13.8 14.7 13.8C15.5 12.8 16 11.4 16 10C16 6.7 13.3 4 10 4C6.7 4 4 6.7 4 10C4 13.3 6.7 16 10 16C11.4 16 12.8 15.5 13.8 14.6C13.8 14.9 13.8 15.2 14.1 15.4L18.3 19.6C18.5 19.8 18.8 19.9 19 19.9C19.2 19.9 19.5 19.8 19.7 19.6C20.1 19.3 20.1 18.7 19.7 18.3ZM10 14.5C7.5 14.5 5.5 12.5 5.5 10C5.5 7.5 7.5 5.5 10 5.5C12.5 5.5 14.5 7.5 14.5 10C14.5 12.5 12.5 14.5 10 14.5Z" fill="white" fill-opacity="0.6" />
                </svg>
            </a>
        </div>

    </div>

    <div id="income" class="tab-content active">
        <div class="items">
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <img src="{{asset('svg/logo.svg')}}" alt="">
                    <span class="text-white">income</span>
                </div>
                <span class="dollar text-white">$10.00</span>
            </div>
        </div>
    </div>

    <div id="expense" class="tab-content">
        <div class="items">
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <img src="{{asset('svg/logo.svg')}}" alt="">
                    <span class="text-white">spent</span>
                </div>
                <span class="dollar text-white">$5.99</span>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .tabs {
        display: flex;
        justify-content: space-between;
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