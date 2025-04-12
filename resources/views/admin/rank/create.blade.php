@extends('admin.layouts.admin')

@section('title')
    <title>Thêm cấp</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Thêm cấp</h2>
        <form action="{{ route('admin.rank.store') }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn thêm cấp này?')">
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
                <label for="type">Cấp</label>
                <input type="text" placeholder="Nhập vào tên cấp" name="type" id="type"
                    class="form-control
                 @error('type') is-invalid @enderror" value="{{ old('type') }}">
                @error('type')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="point">Số điểm</label>
                <input type="text" placeholder="Nhập vào số điểm" name="point" id="point"
                    class="form-control
                 @error('point') is-invalid @enderror"
                    value="{{ old('point') }}">
                @error('point')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="discount">Giảm giá (%):</label>
                <input type="text" placeholder="Nhập vào phần trăm giảm giá" name="discount" id="discount"
                    class="form-control
                 @error('discount') is-invalid @enderror" value="{{ old('discount') }}">
                @error('discount')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.rank.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button href="" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>

    </div>
@endsection
