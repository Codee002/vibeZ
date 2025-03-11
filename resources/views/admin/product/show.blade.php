@extends('admin.layouts.admin')

@section('title')
    <title>Chi tiết sản phẩm</title>
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Chi tiết sản phẩm</h2>
        <div class="row" style="margin: auto">
            <div class="col-12 d-flex align-items-center">
                <p class="title col-2">Tến sản phẩm: </p>
                <p class="d-flex align-items-center col-9">{{ $product->name }}</p>
            </div>
            <div class="col-12 d-flex align-items-center">
                <p class="title col-2">Danh mục sản phẩm: </p>
                <p class="col-9">{{ $product->category->name }}</p>
            </div>
            <div class="col-12 d-flex align-items-center">
                <p class="title col-2">Kích thước sản phẩm: </p>
                <div class="col-9 d-flex">
                    @foreach ($product->sizes as $size)
                        <p class="me-2">{{ $size->pivot->size }}</p>
                    @endforeach
                </div>
            </div>
            <div class="col-12 d-flex align-items-center">
                <p class="title col-2">Ngày tạo: </p>
                <p class="col-9">{{ \Carbon\Carbon::parse($product['created_at'])->format('d/m/Y') }}</p>
            </div>

            <div class="col-12 d-flex align-items-center">
                <p class="title col-2">Mô tả: </p>
                <p class="col-9"> {{ $product->des }} </p>
            </div>
            <p class="title ">Ảnh sản phẩm: </p>
            <div class="col-12 d-flex  align-items-center">
                <div class="col-2"> </div>
                <div class="col-9">
                    @if ($product->images)
                        @foreach ($product->images as $image)
                            @if ($image->img_path && \Storage::exists($image->img_path))
                                <a href="{{ \Storage::url($image->img_path) }}"><img
                                        src="{{ \Storage::url($image->img_path) }}" alt="" width="150rem"
                                        class="me-2"></a>
                            @endif
                        @endforeach
                    @endif
                </div>
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
