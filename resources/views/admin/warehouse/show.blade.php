@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết kho</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Chi tiết kho</h2>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center">
                <p class="title">Địa chỉ kho: </p>
                <p class="d-flex align-items-center">{{ $warehouse['address'] }}</p>
            </div>
            <div class="col-8 d-flex align-items-center">
                <p class="title">Dung tích kho: </p>
                <p >{{ $warehouse['capacity'] }}</p>
            </div>
            <div class="col-8 d-flex align-items-center">
                <p class="title">Ngày tạo: </p>
                <p>{{ \Carbon\Carbon::parse($warehouse['created_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center">
                <p class="title">Tổng sản phẩm thuộc kho: </p>
                <p>100</p>
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
