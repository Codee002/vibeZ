@extends('admin.layouts.admin')

@section('title')
    <title>Thêm nhập hàng</title>
@endsection

{{-- @section('namePage', 'Danh sách nhập hàng') --}}
@section('css')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/config.css') }}">
    <link rel="stylesheet" href="{{ asset('css/layouts.css') }}">
@endsection
@section('content')
    <div class="container">
        @if (session('danger'))
            <div class="alert alert-danger">
                {{ session('danger') }}
            </div>
        @endif
        <h3 class="text-center fw-bolder ">Tạo phiếu nhập</h3>
        <form action="{{ route('admin.receipt.store') }}" class="col-12" style="margin: 3rem auto" method="POST"
            onsubmit="return confirm('Bạn chắc chắn muốn tạo phiếu nhập này?')" enctype="multipart/form-data">
            @csrf


            <div class="order__info">
                <div class="form-group mb-3 row">
                    <h5 class="">Nhà cung cấp</h5>
                    <select placeholder="Chọn kho" name="distributor" id="distributor"
                        class="form-select
                 @error('distributor') is-invalid @enderror"
                        style="width: 100%; margin: 0 auto">
                        <option value="" disabled selected>Chọn kho</option>
                        @foreach ($distributors as $id => $distributor)
                            <option value="{{ $id }}">{{ $distributor }}</option>
                        @endforeach
                    </select>
                    @error('distributor')
                        <span class="invalid-feedback" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mb-5 row">
                    <h5 class="">Kho</h5>
                    <select placeholder="Chọn kho" name="warehouse" id="warehouse"
                        class="form-select
                 @error('warehouse') is-invalid @enderror"
                        style="width: 100%; margin: 0 auto">
                        <option value="" disabled selected>Chọn kho</option>
                        @foreach ($warehouses as $id => $warehouse)
                            <option value="{{ $id }}">{{ $warehouse }}</option>
                        @endforeach
                    </select>
                    @error('warehouse')
                        <span class="invalid-feedback" style="display: block">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="row mb-4">
                    <div class="col-4">
                        <h5>Sản phẩm</h5>
                    </div>
                    <div class="col-2 text-center d-flex justify-content-center">
                        <h5>Phân loại</h5>
                    </div>
                    <div class="col-1 text-center d-flex justify-content-center">
                        <h5>Kích thước</h5>
                    </div>
                    <div class="col text-center d-flex justify-content-center">
                        <h5>Gía nhập</h5>
                    </div>
                    <div class="col text-center d-flex justify-content-center">
                        <h5>Gía bán</h5>
                    </div>
                    <div class="col text-center d-flex justify-content-center">
                        <h5>Số lượng</h5>
                    </div>
                </div>

                @foreach ($data as $products)
                    @foreach ($products['sizes'] as $size)
                        <div class="order__info__product d-flex row">
                            @if ($products['product']->images->isNotEmpty())
                                <div class="col-4 d-flex">
                                    <div class="col-3 me-4">
                                        @if ($products['product']->images[0] && \Storage::exists($products['product']->images[0]->img_path))
                                            <img src="{{ asset(\Storage::url($products['product']->images[0]->img_path)) }}"
                                                class="" alt="">
                                        @endif
                                    </div>
                                    <p class="col-9 d-flex justify-content-center align-items-center">
                                        {{ $products['product']->name }}</p>
                                </div>
                            @endif
                            <div class="col-2 d-flex justify-content-center">
                                <p>{{ $products['product']->category->name }}</p>
                            </div>
                            <div class="col-1 d-flex justify-content-center order__info__product__size">
                                <input class="form-control  text-center" name="size" disabled
                                    value="{{ $size }}">
                                </input>
                            </div>

                            {{-- Giá nhập --}}
                            <div class="col d-flex  flex-column align-items-center justify-content-center">
                                <input type="text"
                                    class="form-control 
                                @error('product' . '.' . $products['product']->id . '.' . $size . '.' . 'purchase_price') is-invalid @enderror"
                                    style="width: 70%;"
                                    name="product[{{ $products['product']->id }}][{{ $size }}][purchase_price]"
                                    value="{{ old(
                                        'product' . '.' . $products['product']->id . '.' . $size . '.' . 'purchase_price',
                                        $products['product']->getPurchasePrice($size),
                                    ) }}">

                                @error('product' . '.' . $products['product']->id . '.' . $size . '.' . 'purchase_price')
                                    <span class="invalid-feedback text-center" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Giá bán --}}
                            <div class="col d-flex flex-column align-items-center justify-content-center">
                                <input type="text"
                                    class="form-control
                                @error('product' . '.' . $products['product']->id . '.' . $size . '.' . 'sale_price') is-invalid @enderror"
                                    style="width: 70%;"
                                    name="product[{{ $products['product']->id }}][{{ $size }}][sale_price]"
                                    value="{{ old(
                                        'product' . '.' . $products['product']->id . '.' . $size . '.' . 'sale_price',
                                        $products['product']->getSalePrice($size),
                                    ) }}">
                                @error('product' . '.' . $products['product']->id . '.' . $size . '.' . 'sale_price')
                                    <span class="invalid-feedback text-center" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Số lượng --}}
                            <div class="col d-flex flex-column align-items-center justify-content-center">
                                <input type="number"
                                    class="form-control 
                                @error('product' . '.' . $products['product']->id . '.' . $size . '.' . 'quantity') is-invalid @enderror"
                                    style="width: 70%;"
                                    name="product[{{ $products['product']->id }}][{{ $size }}][quantity]"
                                    value="{{ old('product' . '.' . $products['product']->id . '.' . $size . '.' . 'quantity') }}">
                                @error('product' . '.' . $products['product']->id . '.' . $size . '.' . 'quantity')
                                    <span class="invalid-feedback text-center" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                @endforeach

            </div>
            <div class="form-group mb-3 d-flex" style="justify-content: end;">
                <a href="{{ route('admin.receipt.index') }}"
                    class="btn btn-secondary text-white text-decoration-none m-1">Hủy</a>
                <button type="submit" class="btn btn-primary text-white text-decoration-none m-1">Thêm</button>
            </div>
        </form>
    </div>

    <style>
        .order__info__product {
            height: 7.5rem;
        }
    </style>
@endsection
