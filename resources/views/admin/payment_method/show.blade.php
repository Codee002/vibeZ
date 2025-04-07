@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết phương thức</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Chi tiết phương thức</h2>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tên phương thức: </p>
                <p class="d-flex align-items-center col-5">{{ $payment_method['name'] }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Trạng thái: </p>
                @if ($payment_method['status'] == 'on')
                    <p class="col-5">Đang bật</p>
                @else
                    <p class="col-5">Đang tắt</p>
                @endif
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Ngày tạo: </p>
                <p class="col-5">{{ \Carbon\Carbon::parse($payment_method['created_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center row">
                <p class="title col-4">Tổng sản phẩm thuộc phương thức: </p>
                <p class="col-5">100</p>
            </div>
            <div>

            </div>
        </div>

    </div>

    <style>
        .title {
            font-size: 1rem;
            font-weight: 700;
            margin-right: 1rem;
            display: flex;
            justify-content: start;
            align-items: center;
        }
    </style>
@endsection
