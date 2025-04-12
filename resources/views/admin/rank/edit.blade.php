@extends('admin.layouts.admin')

@section('title')
    <title>Chỉnh sửa cấp</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">
        <div class="row">

        </div>
        <h2 class="text-center fw-bolder text-">Chỉnh sửa cấp</h2>
        <form action="{{ route('admin.rank.update', $rank) }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn sửa cấp này?')">
            @csrf
            @method('PUT')

            <div class="form-group mb-3">
                <label for="type">Cấp</label>
                <input type="text" placeholder="Nhập vào tên cấp" name="type" id="type"
                    class="form-control
                 @error('type') is-invalid @enderror"
                    value="{{ old('type', $rank['type']) }}">
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
                    value="{{ old('point', $rank['point']) }}">
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
                 @error('discount') is-invalid @enderror"
                    value="{{ old('discount', $rank['discount']) }}">
                @error('discount')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.rank.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button class="btn btn-primary text-white text-decoration-none m-1">Sửa</button>
            </div>
        </form>

    </div>
@endsection
