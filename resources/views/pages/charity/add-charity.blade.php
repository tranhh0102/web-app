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
        <span class="add-expenses-title">Ủng hộ quỹ cộng đồng</span>
        <span></span>
    </div>
    <form action="" method="post" class="p-3">
        @csrf
        <div class="add-expenses">

            <!--Input expenses-->
            <div class="add-expenses-sub" >
                <label for="charge">Số tiền chi tiêu</label>
                <input type="number" name="charge" class="input-expenses" placeholder="Nhập danh chi tiêu" required>
            </div>

            <!--Type expenses-->
            <div class="add-expenses-sub">
                <label for="charge">Mô tả</label>
                <input type="number" name="charge" class="input-expenses" placeholder="Nhập danh chi tiêu" required>
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
                class="text-white" name="name" placeholder="Mô tả" required></textarea>
            </div>

        </div>

        <!-- Submit Button -->
        <div class="add-expenses-sub text-center mt-4">
            <button type="submit" class="button-add-expenses">Lưu chi tiêu</button>
        </div>
    </form>
@endsection

