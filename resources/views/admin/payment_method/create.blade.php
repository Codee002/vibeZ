@extends('admin.layouts.admin')

@section('title')
    <title>Thêm phương thức</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thêm phương thức</h2>
        <form action="{{ route('admin.payment_method.store') }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn thêm phương thức này?')">
            @csrf
            <div class="form-group mb-3">
                <label for="name">Tên phương thức</label>
                <input type="text" placeholder="Nhập vào tên phương thức" name="name" id="name"
                    class="form-control
                 @error('name') is-invalid @enderror" value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="status">Trạng thái</label>
                <select name="status" id="status"
                    class="form-select
                    
             @error('status') is-invalid @enderror" value="{{ old('status') }}">
                    <option value="" disabled selected>Chọn trạng thái</option>
                        <option value="on">Bật</option>
                        <option value="off">Tắt</option>
                </select>
                @error('status')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.payment_method.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button href="" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>

    </div>
@endsection
