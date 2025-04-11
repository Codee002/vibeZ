@extends('admin.layouts.admin')

@section('title')
    <title>Thêm nhà cung cấp</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thêm nhà cung cấp</h2>
        <form action="{{ route('admin.distributor.store') }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn thêm nhà cung cấp này?')">
            @csrf
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('danger'))
                <div class="alert alert-danger">
                    {{ session('danger') }}
                </div>
            @endif

            <div class="form-group mb-3">
                <label for="name">Tên nhà cung cấp</label>
                <input type="text" placeholder="Nhập vào tên nhà cung cấp" name="name" id="name"
                    class="form-control
                 @error('name') is-invalid @enderror" value="{{ old('name') }}">
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
                    value="{{ old('address') }}">
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
                 @error('email') is-invalid @enderror" value="{{ old('email') }}">
                @error('email')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.distributor.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button href="" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>

    </div>
@endsection
