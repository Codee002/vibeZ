@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết phiếu nhập hàng</title>
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
        <h3 class="text-center fw-bolder ">Chi tiết phiếu nhập</h3>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center row" style="padding: .5rem;">
                <p class="detail_title col-2">Nhà cung cấp: </p>
                <p class="d-flex align-items-center col-5">{{ $receipt->distributor->name }}</p>
            </div>
            <div class="col-8 d-flex align-items-center row" style="padding: .5rem;">
                <p class="detail_title col-2">Kho đã nhập: </p>
                <p class="d-flex align-items-center col-5">{{ $receipt->warehouse->address }}</p>
            </div>
            <div class="col-8 d-flex align-items-center row" style="padding: .5rem;">
                <p class="detail_title col-2">Tổng sản phẩm: </p>
                <p class="col-5">{{ $receipt->getQuantity() }}</p>
            </div>
            <div class="col-8 d-flex align-items-center row" style="padding: .5rem;">
                <p class="detail_title col-2">Tổng giá tiền: </p>
                <p class="col-5">{{ number_format($receipt->getPrice(), 0, '', '.') }}</p>
            </div>
            <div class="col-8 d-flex align-items-center row" style="padding: .5rem;">
                <p class="detail_title col-2">Trạng thái: </p>
                <p class="col-5">{{ $receipt['status'] == 'pending' ? 'Đang xử lý' : 'Đã nhập' }}</p>
            </div>
            <div class="col-8 d-flex align-items-center row" style="padding: .5rem;">
                <p class="detail_title col-2">Ngày tạo: </p>
                <p class="col-5">{{ \Carbon\Carbon::parse($receipt['created_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row" style="padding: .5rem;">
                <p class="detail_title">Chi tiết các sản phẩm: </p>
            </div>
            <div class="order__info">
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
                        <h5>Gía đang bán</h5>
                    </div>
                    <div class="col text-center d-flex justify-content-center">
                        <h5>Số lượng</h5>
                    </div>
                </div>

                @foreach ($receipt->receipt_details as $receipt_detail)
                    {{-- {{dd($receipt_detail->product->warehouse_details)}} --}}
                @endforeach
                @foreach ($receipt->receipt_details as $receipt_detail)
                    <div class="order__info__product d-flex row">
                        @if ($receipt_detail->product->images->isNotEmpty())
                            <div class="col-4 d-flex">
                                <div class="col-3 me-4">
                                    @if ($receipt_detail->product->images[0] && \Storage::exists($receipt_detail->product->images[0]->img_path))
                                        <img src="{{ asset(\Storage::url($receipt_detail->product->images[0]->img_path)) }}"
                                            class="" alt="">
                                    @endif
                                </div>
                                <p class="col-9 d-flex justify-content-center align-items-center">
                                    {{ $receipt_detail->product->name }}</p>
                            </div>
                        @endif
                        <div class="col-2 d-flex justify-content-center">
                            <p>{{ $receipt_detail->product->category->name }}</p>
                        </div>
                        <div class="col-1 d-flex justify-content-center order__info__product__size">
                            <input class="form-control  text-center" name="size" disabled
                                value="{{ $receipt_detail->size }}">
                            </input>
                        </div>

                        {{-- Giá nhập --}}
                        <div class="col d-flex  flex-column align-items-center justify-content-center">
                            <input disabled type="text" class="form-control" style="width: 70%;"
                                value="{{ $receipt_detail['purchase_price'] }}">
                        </div>

                        {{-- Giá bán --}}
                        <div class="col d-flex flex-column align-items-center justify-content-center">
                            <input disabled type="text" class="form-control" style="width: 70%;"
                                value="{{ $receipt_detail->product->getSalePrice($receipt_detail->size) }}">
                        </div>

                        {{-- Số lượng --}}
                        <div class="col d-flex flex-column align-items-center justify-content-center">
                            <input disabled type="number" class="form-control" style="width: 70%;"
                                value="{{ $receipt_detail['quantity'] }}">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <style>
        .detail_title {
            font-size: 1rem;
            font-weight: 700;
            margin-right: 1rem;
            display: flex;
            justify-content: start;
            align-items: center;
        }
        .order__info__product{
            height: 7.5rem;
        }
    </style>
@endsection
