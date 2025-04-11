@extends('admin.layouts.admin')

@section('title')
    <title>Chỉnh sửa nhà cung cấp</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <h2 class="text-center fw-bolder text-">Chỉnh sửa nhà cung cấp</h2>
        <form action="{{ route('admin.distributor.update', $distributor) }}" class="col-8" style="margin: 50px auto"
            method="post" onsubmit="return confirm('Bạn chắc chắn muốn sửa nhà cung cấp này?')">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="name">Tên nhà cung cấp</label>
                <input type="text" placeholder="Nhập vào tên nhà cung cấp" name="name" id="name"
                    class="form-control
                 @error('name') is-invalid @enderror" value="{{ old('name', $distributor['name']) }}">
                @error('name')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="address">Địa chỉ</label>
                <input type="text" placeholder="Nhập vào địa chỉ nhà cung cấp" name="address" id="address"
                    class="form-control
                 @error('address') is-invalid @enderror"
                    value="{{ old('address', $distributor['address']) }}">
                @error('address')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="text" placeholder="Nhập vào email nhà cung cấp" name="email" id="email"
                    class="form-control
                 @error('email') is-invalid @enderror" value="{{ old('email', $distributor['email']) }}">
                @error('email')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.distributor.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button class="btn btn-primary text-white text-decoration-none m-1">Sửa</button>
            </div>
        </form>

    </div>
@endsection
