@extends('pages.layouts.layout')

@section('title')
    <title>Đánh giá đơn hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/cart.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/evaluate.css') }}">
@endsection

@section('content')
    <main>
        <p class="title">Đánh giá cho đơn hàng</p>

        {{-- FLASH MESSAGE --}}
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


        {{-- {{ dd($listProductOrder) }} --}}
        <form action="{{ route('evaluate.store', $order) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                {{-- Thoong tin sản phẩm --}}
                @foreach ($listProductOrder as $detail)
                    {{-- <input type="hidden" name="productId[]" value="{{$detail->product['id'])}}"> --}}
                    <div class="contentContainer col-3">
                        <a href="{{ route('product.detail', $detail->product['id']) }}">
                            @if ($detail->product->images[0]->img_path)
                                @if ($detail->product->images[0]->img_path && \Storage::exists($detail->product->images[0]->img_path))
                                    <img src="{{ \Storage::url($detail->product->images[0]->img_path) }}" alt=""
                                        class="product_img">
                                @endif
                            @endif
                            <div class="productInfoContainer">
                                <p class="product_name">{{ $detail->product->name }}
                                </p>
                                <p class="product_category">{{ $detail->product->category->name }}
                                </p>
                                <p class="product_category">Size:
                                    @foreach ($order->order_details as $temp)
                                        @if ($temp['product_id'] == $detail['product_id'])
                                            {{ $temp['size'] }}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        </a>
                    </div>

                    {{-- {{dd($errors)}} --}}

                    <div class="contentContainer col-9">
                        <div class="form-group mb-2 row d-flex align-items-center
                         product-review"
                            data-product-id="{{ $detail->product['id'] }}">
                            <label for="rate">Số sao:</label>
                            <div class="star-rating d-flex align-items-center">
                                <span class="star" data-rating="1">★</span>
                                <span class="star" data-rating="2">★</span>
                                <span class="star" data-rating="3">★</span>
                                <span class="star" data-rating="4">★</span>
                                <span class="star" data-rating="5">★</span>
                                <input type="hidden" class="selected_rating" name="ratings[{{ $detail->product['id'] }}]"
                                    value="{{ old('ratings' . '.' . $detail->product['id'], 0) }}">
                                @error('ratings' . '.' . $detail->product['id'])
                                    <span class="invalid-feedback ms-3" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div>
                                <label for="rate">Đánh giá:</label>
                                <textarea id="" cols="30" rows="4" class="form-control mb-2" placeholder="Đánh giá"
                                    name="contents[{{ $detail->product['id'] }}]">{{ old('contents.' . $detail->product['id'], "") }}</textarea>
                            </div>

                            <div class="">
                                <label for="images">Ảnh đánh giá</label>
                                <input type="file" accept="image/*" name="images[{{ $detail->product['id'] }}]"
                                    class="form-control images
                 @error('images' . '.' . $detail->product['id']) is-invalid @enderror">
                                @error('images' . '.' . $detail->product['id'])
                                    <span class="invalid-feedback" style="display: block">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                {{-- {{dd($errors)}} --}}
                                <div class="form-group mb-3 mt-2 previewImages">
                                    <!-- Script in anh xem truoc -->
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Lựa chọn --}}
                <div class="row mt-5">
                    <div class="col-8"></div>
                    <div class="col-4 d-flex">
                        <div class="order__info__option d-flex justify-content-end">
                            <button class="btn" type="submit" id="btn-submit"
                                style="font-size: 1.2rem;font-weight: 700; color: var(--extra1-color)">Đánh giá</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </main>
@endsection

@section('js')
    <script src="/js/product.js"></script>
    <script src="{{ asset('js/evaluate.js') }}"></script>
@endsection
