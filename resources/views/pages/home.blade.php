@extends('layouts.master')

@section('content')
    <div class="balance-container">
        <span class="balance">so du dau : 1.000.000</span>
        <span class="balance">so du cuoi : 300.000</span>
    </div>
    <div class="flex-row">
        <div class="active-subs">
            <span class="active-subs-6">Active subs</span>
            <span class="active-subs-number">12</span>
        </div>
        <div class="highest-subs">
            <span class="highest-subs-8">Highest subs</span>
            <span class="dollar">$19.99</span>
        </div>
        <div class="lowest-subs">
            <span class="lowest-subs-b">Lowest subs</span>
            <span class="dollar">$5.99</span>
        </div> 
    </div>
    <p class="spent-f text-center">Danh sách chi tiêu tháng này</p>
    <div class="flex-row-b">
        <div class="items">
            <div class="spent">
                <span class="dollar">$5.99</span>
                <span class="spent-f">spent</span>
            </div>
            <div class="draw">
                <span class="dollar">$18.99</span>
                <span class="draw-12">draw</span>
            </div>
        </div>
    </div>
    <div class="navbar">
        <div class="nav-button">
            <img src="{{asset('svg/home.svg')}}" alt="">
        </div>
        <div class="nav-button">
            <img src="{{asset('svg/schedule.svg')}}" alt="">
        </div>
        <div class="add-button">+</div>
        <div class="nav-button">
            <img src="{{asset('svg/report.svg')}}" alt="">
        </div>
        <div class="nav-button">
            <img src="{{asset('svg/account.svg')}}" alt="">
        </div>
    </div>
@endsection
