@extends('admin.layouts.admin')

@section('title')
    <title>Chỉnh sửa kho</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <h2 class="text-center fw-bolder text-">Chỉnh sửa kho</h2>
        <form action="{{ route('admin.warehouse.update', $warehouse) }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn sửa kho này?')">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label for="address">Kho</label>
                <input type="text" placeholder="Nhập vào địa chỉ" name="address" id="address"
                    class="form-control
                 @error('address') is-invalid @enderror" value="{{ $warehouse['address'] }}">
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
                 @error('capacity') is-invalid @enderror" value="{{ $warehouse['capacity'] }}">
                @error('capacity')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.warehouse.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button class="btn btn-warning text-white text-decoration-none m-1">Sửa</button>
            </div>
        </form>

    </div>
@endsection
