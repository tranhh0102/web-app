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
                class="text-white mb-3" name="name" placeholder="Mô tả" required></textarea>
        </div>
        <div class="flex add-expenses-sub text-center mt-4">
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

<!-- Thêm Toast Container vào HTML -->
<div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 9999;"></div>

<script>
    function showToast(message, type = "error") {
        let toast = document.createElement("div");
        toast.textContent = message;
        toast.style.padding = "10px 20px";
        toast.style.color = "#fff";
        toast.style.background = type === "error" ? "#ff4d4d" : "#28a745";
        toast.style.borderRadius = "5px";
        toast.style.marginBottom = "10px";
        toast.style.boxShadow = "0px 0px 10px rgba(0,0,0,0.2)";
        toast.style.transition = "opacity 0.5s ease-in-out";
        
        let toastContainer = document.getElementById("toast-container");
        toastContainer.appendChild(toast);

        setTimeout(() => {
            toast.style.opacity = "0";
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    function nextStep(step) {
        let currentStep = document.querySelector(".step-" + (step - 1));
        let inputs = currentStep.querySelectorAll("input[required], select[required], textarea[required]");
        
        let isValid = true;
        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.style.border = "2px solid red"; // Highlight ô bị thiếu
            } else {
                input.style.border = ""; // Xóa highlight nếu hợp lệ
            }
        });

        if (!isValid) {
            showToast("Vui lòng điền đầy đủ thông tin trước khi tiếp tục!", "error");
            return;
        }

        document.querySelectorAll(".step").forEach(el => el.style.display = "none");
        document.querySelector(".step-" + step).style.display = "block";
    }

    function prevStep(step) {
        document.querySelectorAll(".step").forEach(el => el.style.display = "none");
        document.querySelector(".step-" + step).style.display = "block";
    }
</script>
