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
    <a href="{{route('list-goal')}}" class="icons-back">
        <img src="{{asset('svg/arrow-back.svg')}}" alt="">
    </a>
    <span class="add-expenses-title">Tạo mục tiêu</span>
    <span></span>
</div>
<form action="{{route('transaction.create-goal')}}" method="post" class="p-3">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li style="color: red;font-weight: bold;">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="step step-1">
        <div class="add-expenses-sub">
            <label for="charge">Số tiền mục tiêu</label>
            <input type="text" id="charge" class="input-expenses" placeholder="Nhập số tiền">
            <input type="hidden" name="charge" id="charge-hidden">
        </div>
    </div>

    <div class="step step-2">
        <div class="add-expenses-sub">
            <label for="name">Mô tả</label>
            <textarea style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797; width: 100%;"
                class="text-white mb-3" name="name" placeholder="Mô tả"></textarea>
        </div>
    </div>

    <div class="step step-3">
        <div class="add-expenses-sub">
            <label for="due_date">Ngày hết hạn</label>
            <input type="date" name="due_date" class="input-expenses">
        </div>
    </div>

    <button type="submit" class="button-add-expenses" style="margin-top: 20px;">Tạo mục tiêu</button>
</form>


@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    const chargeInput = document.getElementById('charge');
    const chargeHidden = document.getElementById('charge-hidden');

    chargeInput.addEventListener('input', function (e) {
        let rawValue = this.value.replace(/\D/g, ''); // Loại bỏ tất cả ký tự không phải số
        let formattedValue = new Intl.NumberFormat('en-US').format(rawValue); // Định dạng kiểu 1.000.000

        this.value = formattedValue; // Hiển thị số có dấu chấm
        chargeHidden.value = rawValue; // Lưu giá trị không có dấu chấm vào input ẩn
    });
});
</script>