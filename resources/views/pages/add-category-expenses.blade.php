@extends('layouts.master')

@section('styles')
<link rel="stylesheet" href="{{asset('style/add-category.css')}}">
@endsection

@section('content')
@if(session('success'))
<div id="toast-message" class="alert alert-success fixed top-5 right-5 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg">
    {{ session('success') }}
</div>
@endif
<div class="main-category">
    <div class="category-header flex items-center justify-between p-3">
        <a href="{{route('profile.edit')}}" class="icons-back">
            <img src="{{asset('svg/arrow-back.svg')}}" alt="">
        </a>
        <h2 class="add-category-header">Danh mục chi tiêu</h2>
        <span></span>
    </div>
    <div class="container-add-category">
        <form method="post" action="{{route('mexpense.insert')}}">
            @csrf
            <div class="input-group mb-3">
                <label for="name-category" class="label-category">Tên danh mục chi tiêu : </label>
                <input style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797;"
                    type="text" name="name" class="form-control w-full text-white" placeholder="Nhập danh mục mới" required>
            </div>
            <button class="button-add-category">Thêm</button>
        </form>
    </div>
</div>
<div class="list-spending">
    @forelse($list as $item)
    <div class="spending-sub">
        <span class="name-spending">
            {{$item['name']}}
        </span>
        <form action="{{ route('mexpense.delete', $item['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
            @csrf
            @method('DELETE')
            <button type="submit" style="border: none; background: none; cursor: pointer;">
                <img style="height: 32px; width: 32px;" src="{{ asset('svg/delete.svg') }}" alt="Xóa">
            </button>
        </form>
    </div>
    @empty
    <p>Không có dữ liệu.</p>
    @endforelse
</div>
@endsection

<script>
    setTimeout(() => {
        document.getElementById('toast-message').style.display = 'none';
    }, 3000);
</script>