@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{ asset('style/home.css') }}">
@endsection

@section('content')
    <div class="balance-container ">
        <div class="balance">
            <span class="">Số dư đầu</span>
            <span class="">1.000.000</span>
        </div>
        <div class="balance">
            <span class="">Số dư cuối</span>
            <span class="">300.000</span>
        </div>
    </div>
    <div class="flex-row">
        <div class="active-subs">
            <span class="active-subs-title">Thu nhập</span>
            <span class="receive">$19.99</span>
        </div>
        <div class="active-subs">
            <span class="active-subs-title">Chi tiêu</span>
            <span class="cost">$19.99</span>
        </div>
        <div class="active-subs">
            <span class="active-subs-title">Tổng tiền</span>
            <span class="total-money">$5.99</span>
        </div> 
    </div>
    <p class="title-header text-center">Danh sách chi tiêu tháng này</p>
    <div class="flex-row-b">
        <div class="items">
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <img src="{{asset('svg/logo.svg')}}" alt="">
                    <span class="text-white">spent</span>
                </div>
                <span class="dollar text-white">$5.99</span>
            </div>
            <div class="items-sub">
                <div class="flex items-center gap-2">
                    <img src="{{asset('svg/logo.svg')}}" alt="">
                    <span class="text-white">spent</span>
                </div>
                <span class="dollar text-white">$5.99</span>
            </div>
        </div>
    </div>
@endsection
