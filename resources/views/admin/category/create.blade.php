@extends('admin.layouts.admin')

@section('title')
    <title>Thêm danh mục</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thêm danh mục</h2>
        <form action="{{ route('admin.category.store') }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn thêm danh mục này?')">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Danh mục</label>
                <input type="text" placeholder="Nhập vào tên danh mục" name="name" id="name" class="form-control
                 @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.category.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button href="" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>

    </div>
@endsection
