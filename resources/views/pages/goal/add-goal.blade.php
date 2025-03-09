@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{asset('style/add-expenses.css')}}">
@endsection

@section('content')
@if(session('success'))
<div id="toast-message" class="alert alert-success fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg">
    {{ session('success') }}
</div>
@endif
<div class="add-expenses-header">
    <a href="{{route('home')}}" class="icons-back">
        <img src="{{asset('svg/arrow-back.svg')}}" alt="">
    </a>
    <span class="add-expenses-title">Tạo mục tiêu</span>
    <span></span>
</div>
<form action="{{route('transaction.create-goal')}}" method="post" class="p-3">
    @csrf

    <div class="step step-1">
        <!-- Bước 1: Nhập số tiền -->
        <div class="add-expenses-sub">
            <label for="charge">Số tiền mục tiêu</label>
            <input type="number" name="charge" class="input-expenses" placeholder="Nhập số tiền mục tiêu" required>
        </div>
        <div class="add-expenses-sub text-center mt-4">
            <button type="button" class="button-add-expenses" onclick="nextStep(2)">Tiếp tục</button>
        </div>
    </div>

    <div class="step step-2" style="display: none;">
        <!-- Bước 2: Nhập mô tả -->
        <div class="add-expenses-sub">
            <label for="name">Mô tả</label>
            <textarea style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797; width: 100%;"
                class="text-white" name="name" placeholder="Mô tả" required></textarea>
        </div>
        <div class="add-expenses-sub text-center mt-4">
            <button type="button" class="button-add-expenses" onclick="prevStep(1)">Quay lại</button>
            <button type="button" class="button-add-expenses" onclick="nextStep(3)">Tiếp tục</button>
        </div>
    </div>

    <div class="step step-3" style="display: none;">
        <!-- Bước 3: Nhập ngày hết hạn -->
        <div class="add-expenses-sub">
            <label for="due_date">Ngày hết hạn</label>
            <input type="date" name="due_date" class="input-expenses" required>
        </div>
        <div class="add-expenses-sub text-center mt-4">
            <button type="button" class="button-add-expenses" onclick="prevStep(2)">Quay lại</button>
            <button type="submit" class="button-add-expenses">Hoàn tất</button>
        </div>
    </div>

</form>


@endsection

<script>
    function nextStep(step) {
        document.querySelectorAll(".step").forEach((el) => el.style.display = "none");
        document.querySelector(".step-" + step).style.display = "block";
    }

    function prevStep(step) {
        document.querySelectorAll(".step").forEach((el) => el.style.display = "none");
        document.querySelector(".step-" + step).style.display = "block";
    }
</script>