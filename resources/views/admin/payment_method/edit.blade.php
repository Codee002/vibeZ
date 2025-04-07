@extends('admin.layouts.admin')

@section('title')
    <title>Chỉnh sửa phương thức</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <h2 class="text-center fw-bolder text-">Chỉnh sửa phương thức</h2>
        <form action="{{ route('admin.payment_method.update', $payment_method) }}" class="col-8" style="margin: 50px auto"
            method="post" onsubmit="return confirm('Bạn chắc chắn muốn sửa phương thức này?')">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="name">Phương thức</label>
                <input type="text" placeholder="Nhập vào tên phương thức" name="name" id="name"
                    class="form-control
                 @error('name') is-invalid @enderror"
                    value="{{ $payment_method['name'] }}">
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
                    
             @error('status') is-invalid @enderror"
                    value="{{ old('status') }}">
                    <option value="on" @selected($payment_method['status'] == "on")>Bật</option>
                    <option value="off" @selected($payment_method['status'] == "off")>Tắt</option>
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
                <button class="btn btn-primary text-white text-decoration-none m-1">Sửa</button>
            </div>
        </form>

    </div>
@endsection
