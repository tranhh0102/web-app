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
        <a class="active-subs">
            <div class="flex items-center gap-2">
                <img src="{{asset('svg/home/income.svg')}}" alt="">
                <span class="active-subs-title">Tổng thu nhâp</span>
            </div>
            <span class="receive">{{ number_format($data['income'] ?? 0)}} VNĐ</span>
        </a>
        <a class="active-subs">
            <div class="flex items-center gap-2">
                <img src="{{asset('svg/home/expense.svg')}}" alt="">
                <span class="active-subs-title">Tổng chi tiêu</span>
            </div>
            <span class="cost">{{ number_format($data['expense'] ?? 0)}} VNĐ</span>
        </a>
    </div>
    <div class="flex gap-3 w-full">
        <a href="{{ route('list-charity')}}" class="active-subs">
            <div class="flex items-center gap-2">
                <img src="{{asset('svg/home/charity.svg')}}" alt="">
                <span class="active-subs-title">Đóng góp của bạn</span>
            </div>
            <span class="receive text-[#EF5350]">{{ number_format($data['charity'] ?? 0)}} VNĐ</span>
        </a>
        <a href="{{route('list-goal')}}" class="active-subs">
            <div class="flex items-center gap-2">
                <img src="{{asset('svg/home/goal.svg')}}" alt="">
                <span class="active-subs-title">Mục tiêu của bạn</span>
            </div>
            <span class="cost text-[#FB8A00]">{{ number_format($data['goal'] ?? 0)}} VNĐ</span>
        </a>
    </div>
</div>
<!-- <p class="title-header text-center">Danh sách thu chi tháng này</p> -->
<div class="flex-row-b p-3">
    <div class="tabs">
        <div>
            <button class="tab-button active" onclick="openTab(event, 'statistic')">Thống kê</button>
            <button class="tab-button" onclick="openTab(event, 'expense')">Chi tiêu</button>
            <button class="tab-button" onclick="openTab(event, 'income')">Thu nhập</button>
        </div>
    </div>

    <!--Expenses-->
    <div id="expense" class="tab-content">
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
            <p class="title-header text-center">Không có dữ liệu</p>
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
            <p class="title-header text-center">Không có dữ liệu</p>
            @endforelse
        </div>
    </div>

    <div id="statistic" class="tab-content active">
        <p style="color: white;text-align: center;">
            <img style="width: 35px;height: 35px;display: inline;margin-right: 5px;" src="{{asset('svg/wallet.svg')}}" alt="">
            Số dư: {{ number_format(($data['income'] - $data['expense'] - $data['goal'] - $data['charity']) ?? 0)}} VNĐ
        </p>
    </div>
</div>

@if (!$hasExpenseForToday)
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const checkIsAlertReminder = localStorage.getItem("checkIsAlertReminder");
            if (checkIsAlertReminder == 1) {
                document.getElementById('expenseReminderModal').classList.add('hidden');
            }
        });
        function closeModal() {
            document.getElementById('expenseReminderModal').classList.add('hidden');
        }
        function noMoreAlert() {
            localStorage.setItem('checkIsAlertReminder', 1);
            document.getElementById('expenseReminderModal').classList.add('hidden');
        }
    </script>
@endif

<!-- Modal -->
<div id="expenseReminderModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 @if($hasExpenseForToday) hidden @endif">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold text-gray-800">Nhắc nhở nhập chi tiêu</h2>
        <p class="mt-2 text-gray-600">Bạn chưa nhập chi tiêu cho ngày hôm nay. Hãy nhập ngay để quản lý tài chính tốt hơn!</p>
        
        <div class="mt-4 flex justify-end space-x-2">
            <button onclick="closeModal()" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">OK</button>
            <button onclick="noMoreAlert()" class="px-4 py-2 bg-gray-300 rounded-md hover:bg-gray-400">Hủy</button>
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
        border-radius:12px;
    }

    .tab-button {
        cursor: pointer;
        border: none;
        color: white;
        border-radius: 12px;
        padding: 8px;
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
        overflow: scroll;
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
        if (document.getElementById('toast-message')) {
            document.getElementById('toast-message').style.display = 'none';
        }
    }, 3000);
</script>
