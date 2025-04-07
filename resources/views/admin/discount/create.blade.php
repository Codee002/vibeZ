@extends('admin.layouts.admin')

@section('title')
    <title>Thêm khuyến mãi</title>
@endsection

{{-- @section('namePage', 'Danh sách sản phẩm') --}}

@section('content')
    <div class="container">

        <h2 class="text-center fw-bolder text-">Thêm khuyến mãi</h2>


        <form action="{{ route('admin.discount.store') }}" class="col-8" style="margin: 50px auto" method="post"
            onsubmit="return confirm('Bạn chắc chắn muốn thêm khuyến mãi này?')">
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
                <label for="category_id">Danh mục</label>
                <select name="category_id" id="category_id"
                    class="form-select
             @error('category_id') is-invalid @enderror"
                    value="{{ old('category_id') }}">
                    <option value="" disabled selected>Chọn danh mục</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="des">Mô tả khuyến mãi</label>
                <input type="text" placeholder="Nhập vào mô tả khuyến mãi" name="des" id="des"
                    class="form-control
                 @error('des') is-invalid @enderror" value="{{ old('des') }}">
                @error('des')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="percent">Trị giá (%): </label>
                <input type="text" placeholder="Nhập vào trị giá khuyến mãi" name="percent" id="percent"
                    class="form-control
                 @error('percent') is-invalid @enderror"
                    value="{{ old('percent') }}">
                @error('percent')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="start_at">Ngày bắt đầu: </label>
                <input type="date" placeholder="Nhập vào trị giá khuyến mãi" name="start_at" id="start_at"
                    class="form-control
                 @error('start_at') is-invalid @enderror"
                    value="{{ old('start_at') }}">
                @error('start_at')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="end_at">Ngày kết thúc: </label>
                <input type="date" placeholder="Nhập vào trị giá khuyến mãi" name="end_at" id="end_at"
                    class="form-control
                 @error('end_at') is-invalid @enderror"
                    value="{{ old('end_at') }}">
                @error('end_at')
                    <span class="invalid-feedback" style="display: block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>


            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ url()->previous() }}" class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button href="" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>

    </div>
@endsection
