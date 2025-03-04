@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{ asset('style/home-search.css') }}">
@endsection

@section('content') 
    <div class="home-search-header">
    <form method="GET" action="{{ route('home-search') }}" class="home-search-header w-full relative">
        <input type="text" class="input-search" name="search" placeholder="Tìm kiếm..." value="{{ request('search') }}">
        
        <div class="flex">
            <button type="submit" class="search">
                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none">
                    <path d="M19.7 18.3L15.5 14.1C15.3 13.9 15 13.8 14.7 13.8C15.5 12.8 16 11.4 16 10C16 6.7 13.3 4 10 4C6.7 4 4 6.7 4 10C4 13.3 6.7 16 10 16C11.4 16 12.8 15.5 13.8 14.6C13.8 14.9 13.8 15.2 14.1 15.4L18.3 19.6C18.5 19.8 18.8 19.9 19 19.9C19.2 19.9 19.5 19.8 19.7 19.6C20.1 19.3 20.1 18.7 19.7 18.3ZM10 14.5C7.5 14.5 5.5 12.5 5.5 10C5.5 7.5 7.5 5.5 10 5.5C12.5 5.5 14.5 7.5 14.5 10C14.5 12.5 12.5 14.5 10 14.5Z" fill="white" fill-opacity="0.6" />
                </svg>
            </button>
            
            <!-- Nút Filter -->
            <button type="button" class="filter" onclick="toggleFilter()">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M11 4H13V7H11V4Z" fill="white" fill-opacity="0.6"/>
                    <path d="M10 8V11H11V20H13V11H14V8H10Z" fill="white" fill-opacity="0.6"/>
                    <path d="M6 4H8V12H6V4Z" fill="white" fill-opacity="0.6"/>
                    <path d="M5 13V16H6V20H8V16H9V13H5Z" fill="white" fill-opacity="0.6"/>
                    <path d="M16 4H18V14H16V4Z" fill="white" fill-opacity="0.6"/>
                    <path d="M15 15V18H16V20H18V18H19V15H15Z" fill="white" fill-opacity="0.6"/>
                </svg>
            </button>
        </div>

        <!-- Khung lọc (ẩn mặc định) -->
        <div id="filter-options" class="filter-box hidden bg-gray-800">
            <label class="block mb-2">Lọc theo ngày:</label>
            <input type="date" name="date" value="{{ request('date') }}" class="w-full p-2 rounded bg-gray-700 text-white">

            <label class="block mt-3 mb-2">Số tiền tối thiểu:</label>
            <input type="number" name="min_amount" value="{{ request('min_amount') }}" class="w-full p-2 rounded bg-gray-700 text-white" placeholder="Nhập số tiền">

            <label class="block mt-3 mb-2">Số tiền tối đa:</label>
            <input type="number" name="max_amount" value="{{ request('max_amount') }}" class="w-full p-2 rounded bg-gray-700 text-white" placeholder="Nhập số tiền">

            <button type="submit" class="w-full mt-4 bg-blue-500 hover:bg-blue-600 p-2 rounded">Áp dụng</button>
        </div>
    </form>

    </div>
    <div class="list-search mb-20">
    @foreach ($groupedTransactions as $date => $transactions)
        <h2 class="text-white font-bold pl-3">{{ $date }}</h2> <!-- Hiển thị ngày giao dịch -->
        
        @foreach ($transactions as $transaction)
            <div class="items">
                <div class="items-sub">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('svg/logo.svg') }}" alt="">
                        <span class="text-white">{{ $transaction['name'] }}</span>
                    </div>
                    <span class="dollar text-white">${{ $transaction['amount'] }}</span>
                </div>
            </div>
        @endforeach
    @endforeach
</div>
@endsection

<script>
    function toggleFilter() {
    let filterBox = document.getElementById("filter-options");
    filterBox.classList.toggle("hidden");
}
</script>