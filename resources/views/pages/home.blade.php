@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/home.css') }}">
@endsection

@section('content')

@if(session('success'))
<div id="toast-message" class="alert alert-success fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg">
    {{ session('success') }}
</div>
@endif
<div class="home-header">
    <span class="home-title">Trang chủ</span>
</div>
<div class="stastic">
    <div class="flex gap-3 w-full">
        <div class="active-subs">
            <div class="flex items-center gap-2">
                <img src="{{asset('svg/home/income.svg')}}" alt="">
                <span class="active-subs-title">Total Incomes</span>
            </div>
            <span class="receive">{{ number_format($data['income'] ?? 0)}} VNĐ</span>
        </div>
        <div class="active-subs">
            <div class="flex items-center gap-2">
                <img src="{{asset('svg/home/expense.svg')}}" alt="">
                <span class="active-subs-title">Total Expense</span>
            </div>
            <span class="cost">{{ number_format($data['expense'] ?? 0)}} VNĐ</span>
        </div>
    </div>
    <div class="flex gap-3 w-full">
        <div class="active-subs">
            <span class="active-subs-title">Your contribution</span>
            <span class="receive">{{ number_format($data['charity'] ?? 0)}} VNĐ</span>
        </div>
        <div class="active-subs">
            <span class="active-subs-title">Your goal</span>
            <span class="cost">{{ number_format($data['goal'] ?? 0)}} VNĐ</span>
        </div>
    </div>
</div>
<p class="title-header text-center">Danh sách thu chi tháng này</p>
<div class="flex-row-b p-3">
    <div class="tabs">
        <div>
            <button class="tab-button active" onclick="openTab(event, 'expense')">Expenses</button>
            <button class="tab-button" onclick="openTab(event, 'income')">Incomes</button>
        </div>
    </div>

    <!--Expenses-->
    <div id="expense" class="tab-content active">
        <div class="items">
            @forelse($dataExpenses as $item)
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <div>
                         <img src="{{asset('svg/home/expense.svg')}}" alt="">
                    </div>
                    <div class="grid gap-1">
                        <span class="text-white">{{$item->name}}</span>
                        <span class="cost">{{ number_format($item->charge) }} VNĐ</span>
                        <span class="text-white">{{$item->date}}</span>
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
    
    <!--Income-->
    <div id="income" class="tab-content ">
        <div class="items">
            @forelse($dataIncomes as $item)
        <div class="items-sub">
                <div class="flex items-center gap-2">
                    <div>
                        <img src="{{asset('svg/home/income.svg')}}" alt="">
                    </div>
                    <div class="grid gap-1">
                        <span class="text-white">{{$item->name}}</span>
                        <span class="receive">{{ number_format($item->charge) }} VNĐ</span>
                        <span class="text-white">{{$item->date}}</span>
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
</div>
@endsection

<style>
    .tabs {
        display: flex;
        justify-content: center;
        gap: 12px;
        align-items: center;
        padding: 12px;
        background: #333;
        border-radius:12px;
    }

    .tab-button {
        cursor: pointer;
        border: none;
        color: white;
        border-radius: 12px;
        padding: 12px;
        font-size: 14px;
        font-weight: 600;
        line-height: 20px;
    }

    .tab-button.active {
        background: #555;
    }

    .tab-content {
        margin-top: 12px;
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
