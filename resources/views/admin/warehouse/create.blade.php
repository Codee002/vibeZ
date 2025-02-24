@extends('admin.layouts.admin')

@section('title')
    <title>Thêm kho</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thêm kho</h2>
        <form action="{{ route('admin.warehouse.store') }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn thêm kho này?')">
            @csrf
            <div class="form-group mb-3">
                <label for="address">Địa chỉ</label>
                <input type="text" placeholder="Nhập vào tên kho" name="address" id="address"
                    class="form-control
                 @error('address') is-invalid @enderror"
                    value="{{ old('address') }}">
                @error('address')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="capacity">Dung tích kho</label>
                <input type="number" placeholder="Nhập vào dung tích kho" name="capacity" id="capacity"
                    class="form-control
             @error('capacity') is-invalid @enderror" value="{{ old('capacity') }}">
                @error('capacity')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.warehouse.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button href="" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>

    </div>
@endsection
