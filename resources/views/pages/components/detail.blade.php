@extends('pages.layouts.layout')

@section('title')
    <title>Chi tiết sản phẩm</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
@endsection

@section('content')
    <main>
        <div class="mt-4">
            <div class="d-flex row" style="width: 100%">

                {{-- SLIDER --}}
                <div class=" col-5 p-0">
                    <!--head-card-->
                    <div id="demo" class="carousel slide" data-bs-ride="carousel">
                        {{-- {{ dd($product) }} --}}
                        <!-- Indicators/dots -->
                        <div class="carousel-indicators">
                            @if ($product->images)
                                @foreach ($product->images as $key => $image)
                                    <button type="button" data-bs-target="#demo" data-bs-slide-to="{{ $key }}"
                                        class="{{ $key == 0 ? 'active' : '' }}"></button>
                                @endforeach
                            @endif
                        </div>

                        <div class="carousel-inner">
                            @if ($product->images)
                                @foreach ($product->images as $key => $image)
                                    @if ($image->img_path && \Storage::exists($image->img_path))
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <a href="{{ \Storage::url($image->img_path) }}">
                                                <img src="{{ \Storage::url($image->img_path) }}" alt=""
                                                    width="150rem" class="me-2">
                                            </a>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <!-- Left and right controls/icons -->
                        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>

                {{-- Content --}}
                <div class="detailContainer col-7">
                    <p class="detailContainer__name">{{ $product['name'] }}
                    </p>
                    <p class="detailContainer__des">
                        {{ $product['des'] }}
                    </p>
                    <p class="detailContainer__category">{{ $product->category['name'] }}
                    </p>

                    <p class="detailContainer__price">{{ number_format($product->sale_prices[0]->price, 0, '', ' Triệu ') }}
                    </p>

                    <div class="d-flex align-items-center mt-2">
                        <div class="detailContainer__submit">
                            <button type="submit" class="btn">
                                Thêm vào giỏ
                            </button>
                        </div>

                        <div class="detailContainer__submit">
                            <button type="submit" class="btn">
                                Mua ngay
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5">
                <!--card-bottom-->
                <div class="d-flex">
                    <div class="p-4">
                        {{-- Thông tin sản phẩm --}}
                        <h4 class="">Thông Tin Sản Phẩm</h4>
                        <div class="p-3">
                            <div class="col-12 d-flex align-items-center">
                                <p class="detail__title col-2">Tến sản phẩm: </p>
                                <p class="d-flex align-items-center col-8">{{ $product->name }}</p>
                            </div>
                            <div class="col-12 d-flex align-items-center">
                                <p class="detail__title col-2">Danh mục sản phẩm: </p>
                                <p class="col-8">{{ $product->category->name }}</p>
                            </div>
                            <div class="col-12 d-flex align-items-center">
                                <p class="detail__title col-2">Kích thước sản phẩm: </p>
                                <div class="col-8 d-flex">
                                    @foreach ($product->sizes as $size)
                                        <p class="me-2">{{ $size->pivot->size }}</p>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-12 d-flex align-items-center">
                                <p class="detail__title col-2">Mô tả: </p>
                                <p class="col-8"> {{ $product->des }} </p>
                            </div>


                            <div class="col-12 d-flex align-items-center">
                                <p class="detail__title col-2">Ảnh sản phẩm: </p>
                            </div>
                            <div class="d-flex flex-column align-items-center">
                                @if ($product->images)
                                    @foreach ($product->images as $image)
                                        @if ($image->img_path && \Storage::exists($image->img_path))
                                            <a href="{{ \Storage::url($image->img_path) }}"><img
                                                    src="{{ \Storage::url($image->img_path) }}" alt=""
                                                    width="600rem" class="me-2"></a>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Đánh giá --}}
                        <h4 class="product-title">Đánh giá</h4>
                        <div class="product-content__info p-3">
                            <div class="col-12 d-flex align-items-center">
                                <p class="title col-2">Trần Phúc </p>
                                <p class="d-flex align-items-center col-8">Sản phẩm tốt</p>
                            </div>
                        </div>

                        <div>
                            <div class="productPreviewContainer">
                                <h4 class="productPreviewContainer__title">Sản phẩm cùng danh mục</h4>
                                <div class="row mb-3">
                                    @php $temp = 1;  @endphp
                                    @foreach ($allProducts as $suggest)
                                        {{-- {{ dd($suggest) }} --}}
                                        @if ($suggest['category_name'] == $product->category->name)
                                            <div class="contentContainer col-3">
                                                <a href="{{ route('product.detail', $suggest['product_id']) }}">
                                                    @if ($suggest['image'])
                                                        @if ($suggest['image'] && \Storage::exists($suggest['image']))
                                                            <img src="{{ \Storage::url($suggest['image']) }}"
                                                                alt="" class="product_img">
                                                        @endif
                                                    @endif

                                                    <div class="productInfoContainer">
                                                        <p class="product_name">{{ $suggest['product_name'] }}
                                                        </p>
                                                        <p class="product_category">{{ $suggest['category_name'] }}
                                                        </p>
                                                        <p class="product_price">
                                                            {{ number_format($suggest['price'], 0, ',', ' Triệu ') }}
                                                        </p>
                                                    </div>
                                                </a>
                                            </div>
                                            @php $temp++;  @endphp
                                            @if ($temp > 4)
                                                @php break; @endphp
                                            @endif
                                        @endif
                                    @endforeach
                                </div>
                                <a href="{{ route('product', ['category' => $product->category->id]) }}"
                                    class="productPreviewContainer__more">
                                    <p class="">Xem Thêm</p>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </main>
@endsection

@section('js')
    <script src="{{ asset('/js/product.js') }}"></script>
@endsection
