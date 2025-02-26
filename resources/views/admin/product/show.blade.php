@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết sản phẩm</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Chi tiết sản phẩm</h2>
        <div class="row" style="margin: auto">
            <div class="col-8 d-flex align-items-center">
                <p class="title">Ảnh sản phẩm: </p>
                @if ($product->images)
                    @foreach ($product->images as $image)
                        @if ($image->img_path && \Storage::exists($image->img_path))
                            <img src="{{ \Storage::url($image->img_path) }}" alt="" width="60rem" class="me-2">
                        @endif
                    @endforeach
                @endif
            </div>
            <div class="col-8 d-flex align-items-center">
                <p class="title">Tến sản phẩm: </p>
                <p class="d-flex align-items-center">{{ $product->name }}</p>
            </div>
            <div class="col-8 d-flex align-items-center">
                <p class="title">Danh mục sản phẩm: </p>
                <p>{{ $product->category->name }}</p>
            </div>
            <div class="col-8 d-flex align-items-center">
                <p class="title">Kích thước sản phẩm: </p>
                @foreach ($product->sizes as $size)
                    <p class="me-2">{{ $size->pivot->size }}</p>
                @endforeach
            </div>
            <div class="col-8 d-flex align-items-center">
                <p class="title">Ngày tạo: </p>
                <p>{{ \Carbon\Carbon::parse($product['created_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-8 d-flex align-items-center">
                <p class="title">Mô tả: </p>
                <p> {{ $product->des }} </p>
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
