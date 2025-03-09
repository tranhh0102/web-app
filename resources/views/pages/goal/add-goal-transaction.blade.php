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
<form action="{{route('transaction.goal',['id'=>$goal['id']])}}" method="post" class="p-3">
    @csrf
    <div class="add-expenses">

        <div class="add-expenses-sub">
            <label for="charge">Số tiền </label>
            <input type="number" name="charge" class="input-expenses" placeholder="Nhập danh số tiền" required>
        </div>

    </div>

    <!-- Submit Button -->
    <div class="add-expenses-sub text-center mt-4">
        <button type="submit" class="button-add-expenses">Lưu chi tiêu</button>
    </div>
</form>
@endsection