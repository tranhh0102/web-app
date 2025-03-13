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
    
    <form action="{{route('transaction.expense')}}" method="post" class="p-3">
        @csrf
        <div class="add-expenses">

            <!--Input expenses-->
            <div class="add-expenses-sub">
                <label for="charge">Số tiền chi tiêu</label>
                <span id="charge-warning" style="color: white; font-size: 12px;">Vui lòng nhập số tiền!</span>
                <input type="text" id="charge" class="input-expenses" placeholder="Nhập số tiền" required>
                <input type="hidden" name="charge" id="charge-hidden">
            </div>

            <!--Type expenses-->
            <div class="add-expenses-sub flex" id="openModal">
                <div class="flex gap-2">
                    <span class="add-expenses-span" >Loại</span>
                </div>
                <input style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797; width: 100%;" 
                type="text" id="selectedType" class="text-white mb-3" placeholder="Loại đã chọn" readonly>
                <input type="hidden" id="m_expense_id" name="m_expense_id">
            </div>

            <!--Time expenses-->
            <div class="add-expenses-sub">
                <label for="date">Thời gian</label>
                <input type="date" name="date" class="input-expenses" required>
            </div>
            
            <!--Description expenses-->
            <div class="add-expenses-sub">
                <label for="charge">Mô tả</label>
                <textarea style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797; width: 100%;" 
                class="text-white" name="name" placeholder="Mô tả" required></textarea>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="add-expenses-sub text-center mt-4">
            <button type="submit" class="button-add-expenses">Lưu chi tiêu</button>
        </div>
    </form>

    <!-- Overlay nền mờ -->
    <div id="modalOverlay" class="modal-overlay hidden"></div>

    <!-- Bottom Sheet (Hiện từ dưới lên) -->
    <div id="modalSheet" class="modal-sheet">
        <div class="modal-content">
            <ul class="modal-list">
                @foreach ($result as $category)
                    <li class="modal-item" 
                        data-value="{{ $category['id'] }}" 
                        data-name="{{ $category['name'] }}">
                        {{ $category['name'] }}
                    </li>
                @endforeach
            </ul>
            <button id="closeModal">Đóng</button>
        </div>
    </div>

@endsection

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const openModal = document.getElementById("openModal");
        const modalOverlay = document.getElementById("modalOverlay");
        const modalSheet = document.getElementById("modalSheet");
        const closeModal = document.getElementById("closeModal");
        const selectedTypeInput = document.getElementById("selectedType");
        const modalItems = document.querySelectorAll(".modal-item");
        const expenseIdInput = document.getElementById("m_expense_id");

        openModal.addEventListener("click", function () {
            modalOverlay.style.display = "block";
            modalSheet.classList.add("show");
        });

        modalItems.forEach(item => {
            item.addEventListener("click", function () {
                const selectedId = this.getAttribute("data-value");
                const selectedName = this.getAttribute("data-name"); 

                expenseIdInput.value = selectedId;
                selectedTypeInput.value = selectedName; 
                closeModalFunc();
            });
        });

        closeModal.addEventListener("click", closeModalFunc);
        modalOverlay.addEventListener("click", closeModalFunc);

        function closeModalFunc() {
            modalSheet.classList.remove("show");
            setTimeout(() => {
                modalOverlay.style.display = "none";
            }, 300);
        }
    });
</script>
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