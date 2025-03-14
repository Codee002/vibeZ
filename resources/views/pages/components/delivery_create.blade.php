@extends('pages.layouts.layout')

@section('title')
    <title>Tạo thông tin nhân hàng</title>
@endsection

@section('css')
<link rel="stylesheet" href="{{asset("css/delivery.css")}}">
@endsection

@section('content')
    <main>
        <p class="title">Thêm thông tin nhận hàng</p>
        <form action="{{ route('delivery.store') }}" class="col-8" style="margin: 0 auto; width: 40rem"
            method="post" onsubmit="return confirm('Bạn chắc chắn muốn thêm thông tin này?')">
            @csrf
            <div class="form-group mb-3">
                <label for="capacity">Họ tên</label>
                <input type="text" placeholder="Nhập vào họ tên" name="name" id="name"
                    class="form-control
                     @error('name') is-invalid @enderror"
                    value="{{ old('name') }}">
                @error('name')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="address">Địa chỉ</label>
                <input type="text" placeholder="Nhập địa chỉ nhận hàng" name="address" id="address"
                    class="form-control
             @error('address') is-invalid @enderror" value="{{ old('address') }}">
                @error('address')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="capacity">Số điện thoại</label>
                <input type="text" placeholder="Nhập vào số điện thoại" name="phone" id="phone"
                    class="form-control
                     @error('phone') is-invalid @enderror"
                    value="{{ old('phone') }}">
                @error('phone')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="form-group d-flex align-items-center  mb-3">
                <label for="default">Đặt làm mặc định</label>
                <input type="checkbox" id="default" name="default"
                    class="form-check-input ms-2" 
                    value="1">
            </div>
            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.warehouse.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button href="" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>
    </main>
@endsection

@section('js')
@endsection
