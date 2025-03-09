@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{asset('style/add-expenses.css')}}">
@endsection

@section('content')
    <div class="add-expenses-header">
        <a href="{{route('home')}}" class="icons-back">
             <img src="{{asset('svg/arrow-back.svg')}}" alt="">
        </a>
        <span class="add-expenses-title">Thêm chi tiêu</span>
        <span></span>
    </div>
    @dd($goal)
    <form action="http://127.0.0.1:8000/transactions/goals/3" method="POST">
        @csrf
        <div class="add-expenses-sub">
            <label for="charge">Số tiền chi tiêu</label>
            <input type="number" name="charge" class="input-expenses" placeholder="Nhập danh chi tiêu" required>
        </div>

        <div class="add-expenses-sub text-center mt-4">
            <button type="submit" class="button-add-expenses">Lưu chi tiêu</button>
        </div>
    </form>

@endsection
