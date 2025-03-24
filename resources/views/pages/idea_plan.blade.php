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
<div class="home-header">
    <div class="add-expenses-header">
        <a href="{{route('idea')}}" class="icons-back">
             <img src="{{asset('svg/arrow-back.svg')}}" alt="">
        </a>
        <span class="add-expenses-title">{{ $titlePage }}</span>
        <span></span>
    </div>
    <h2 style="color: white; text-align: center;font-size: 18px; margin-top: 10px;font-style:italic;">{{ $typeName }}</h2>

    <div style="width: fit-content;margin-left: auto;margin-right: auto;padding: 15px;border-radius: 8px;">
        <ul style="color: white;">
            <li>Nhu cầu cơ bản: {{ number_format($planData['nhu_cau_co_ban'] ?? 0) }} VND</li>
            <li>Tiết kiệm & Đầu tư: {{ number_format($planData['tiet_kiem'] ?? 0) }} VND</li>
            <li>Giải trí & Hưởng thụ: {{ number_format($planData['giai_tri'] ?? 0) }} VND</li>
            <li>Khác: {{ number_format($planData['khac'] ?? 0) }} VND</li>
            <li>Phù hợp cho: {{ $planData['note'] }} </li>
            <ul style="list-style: circle;">✅ Ưu điểm
                @foreach ($planData['advantage'] as $item)
                    <li style="margin-left: auto;margin-right: auto;width: 80vw;">{{ $item }}</li>
                @endforeach
            </ul>
            <ul style="list-style: circle;">❌ Nhược điểm
                @foreach ($planData['disadvantage'] as $item)
                    <li style="margin-left: auto;margin-right: auto;width: 80vw;">{{ $item }}</li>
                @endforeach
            </ul>
        </ul>
    </div>
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