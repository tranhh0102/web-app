@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{asset('style/add-expenses.css')}}">
@endsection

@section('content')
    <div class="add-expenses-header">
        <a href="{{route('home')}}" class="icons-back">
            <img src="{{asset('svg/arrow-back.svg')}}" alt="">
        </a>
        <span class="add-expenses-title">Thêm thu nhap</span>
        <span></span>
    </div>
    <form action="{{route('transaction.income')}}" method="post" class="p-3">
        @csrf
        <div class="add-expenses">

            <!--Input expenses-->
            <div class="add-expenses-sub" >
                <label for="charge">Số tiền thu nhap</label>
                <input type="number" class="input-expenses" placeholder="Nhập danh thu nhap" required>
            </div>

            <!--Type expenses-->
            <div class="add-expenses-sub flex" id="openModal">
                <div class="flex gap-2">
                    <span class="add-expenses-span" >Loại</span>
                </div>
                <input style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797; width: 100%;" 
                type="text" id="selectedType" class="text-white mb-3" placeholder="Loại đã chọn" readonly>
                <input type="hidden" id="m_income_id" name="m_income_id">
            </div>

            <!--Time expenses-->
            <div class="add-expenses-sub">
                <label for="charge">Thời gian</label>
                <input type="datetime-local" class="input-expenses" placeholder="Nhập thời gian" required>
            </div>

            <!--Description expenses-->
            <div class="add-expenses-sub">
                <label for="charge">Mô tả</label>
                <textarea style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797; width: 100%;" 
                class="text-white" placeholder="Mô tả" required></textarea>
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
            <h3>Chọn loại</h3>
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
        const expenseIdInput = document.getElementById("m_income_id");

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