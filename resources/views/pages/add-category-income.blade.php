@extends('layouts.master')

@section('styles')
    <link rel="stylesheet" href="{{asset('style/add-category.css')}}">
@endsection

@section('content')
    <div class="category-header flex items-center justify-between p-3">
        <a href="{{route('home')}}" class="icons-back">
            <img src="{{asset('svg/arrow-back.svg')}}" alt="">
        </a>
        <h2 class="add-category-header">Danh mục chi tiêu</h2>
        <span></span>
    </div>
    <div class="container-add-category">
        <form method="post" action="{{mincome.insert}}">
            @csrf
            <div class="input-group mb-3">
                <label for="name-category" class="label-category">Tên danh mục thu nhập : </label>
                <input style="background: #1D1D1D; border-radius: 12px; border: 0.8px solid #979797;" 
                type="text" class="form-control w-full text-white" placeholder="Nhập danh mục mới" required>
            </div>
            <button class="button-add-category">Thêm</button>
        </form>
    </div>
    <div class="list-spending">
        @forelse($list as $item)
            <div class="spending-sub">
                <span class="name-spending">
                    {{$item['name']}}
                </span>
                <form action="{{ route('mincome.delete', $item['id']) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa?');">
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
