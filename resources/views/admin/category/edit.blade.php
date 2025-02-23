@extends('admin.layouts.admin')

@section('title')
    <title>Chỉnh sửa danh mục</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <h2 class="text-center fw-bolder text-">Chỉnh sửa danh mục</h2>
        <form action="{{ route('admin.category.update', $category) }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn sửa danh mục này?')">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Danh mục</label>
                <input type="text" placeholder="Nhập vào tên danh mục" name="name" id="name"
                    class="form-control
                 @error('name') is-invalid @enderror" value="{{ $category['name'] }}">
                @error('name')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.category.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button class="btn btn-warning text-white text-decoration-none m-1">Sửa</button>
            </div>
        </form>

    </div>
@endsection
