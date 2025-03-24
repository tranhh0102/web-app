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
        <span class="add-expenses-title">Khuyến nghị chi tiêu</span>
        <span></span>
    </div>    <form action="{{route('idea_plan')}}" method="get" class="p-3">
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
        <div class="add-expenses">
            <!--Input expenses-->
            <div class="add-expenses-sub">
                <label for="charge">Số tiền thu nhập</label>
                <input type="text" id="charge" class="input-expenses" placeholder="Nhập số tiền">
                <input type="hidden" name="charge" id="charge-hidden">
            </div>

            <div class="add-expenses-sub">
                <label for="type">Cách chi tiêu</label>
                <select name="type">
                    <option value="1">Tận hưởng cuộc sống</option>
                    <option value="2">Tối ưu tài chính</option>
                    <option value="3">Tận hưởng và tối ưu tài chính</option>
                </select>
            </div>

        </div>
    
        <!-- Submit Button -->
        <div class="add-expenses-sub text-center mt-4">
            <button type="submit" class="button-add-expenses">Tạo kế hoạch chi tiêu</button>
        </div>
    </form>
</div>

@endsection
<script>
document.addEventListener('DOMContentLoaded', function () {
    const chargeInput = document.getElementById('charge');
    const chargeHidden = document.getElementById('charge-hidden');

    chargeInput.addEventListener('input', function (e) {
        charge = this.value;
        let rawValue = this.value.replace(/\D/g, ''); // Loại bỏ tất cả ký tự không phải số
        let formattedValue = new Intl.NumberFormat('en-US').format(rawValue); // Định dạng kiểu 1.000.000

        this.value = formattedValue; // Hiển thị số có dấu chấm
        chargeHidden.value = rawValue; // Lưu giá trị không có dấu chấm vào input ẩn
    });
});
</script>