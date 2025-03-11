@extends('pages.layouts.layout')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/product.css">
    <link rel="stylesheet" href="css/home.css">
@endsection

@section('content')
    <main>
        <img class="banner" src="/assets/images/banner/main_banner.jpg">
        </img>
        <div class="Content-container">
            <div class="">
                <p class="visitContainer__title">Khám Phá VibeZ</p>
                <div class="visitContainer">
                    <a href="">
                        <div class="visitContainer__item">
                            <div class="content">
                                <i class='bx bxs-food-menu'></i>
                                <a href="{{ route('product') }}">
                                    <p>Sản phẩm</p>
                                </a>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('cart') }}">
                        <div class="visitContainer__item">
                            <div class="content">
                                <i class='bx bxs-cart-alt'></i>
                                <a href="{{ route('cart') }}">
                                    <p>Giỏ hàng</p>
                                </a>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('order_history') }}">
                        <div class="visitContainer__item">
                            <div class="content">
                                <i class='bx bxs-package'></i>
                                <a href="{{ route('order_history') }}">
                                    <p>Đơn hàng</p>
                                </a>
                            </div>
                        </div>
                    </a>
                    <a href="{{ route('contact') }}">
                        <div class="visitContainer__item">
                            <div class="content">
                                <i class='bx bx-support'></i>
                                <a href="{{ route('contact') }}">
                                    <p>Liên hệ</p>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div>
                <div class="productPreviewContainer">
                    <p class="productPreviewContainer__title">Converse</p>
                    <div class="row mb-3">
                        @php $temp = 1;  @endphp
                        @foreach ($products as $product)
                            {{-- {{ dd($product) }} --}}
                            @if ($product['category_name'] == 'Giày Converse')
                                <div class="contentContainer col-3">
                                    <a href="">
                                        @if ($product['image'])
                                            @if ($product['image'] && \Storage::exists($product['image']))
                                                <img src="{{ \Storage::url($product['image']) }}" alt=""
                                                    class="product_img">
                                            @endif
                                        @endif

                                        <div class="productInfoContainer">
                                            <p class="product_name">{{ $product['product_name'] }}
                                            </p>
                                            <p class="product_category">{{ $product['category_name'] }}
                                            </p>
                                            <p class="product_price">
                                                {{ number_format($product['price'], 0, ',', ' Triệu ') }}</p>
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
                    <a href="" class="productPreviewContainer__more">
                        <p>Xem Thêm</p>
                    </a>
                </div>
            </div>

            <div>
                <div class="productPreviewContainer">
                    <p class="productPreviewContainer__title">Nike</p>
                    <div class="row mb-3">
                        @php $temp = 1;  @endphp
                        @foreach ($products as $product)
                            {{-- {{ dd($product) }} --}}
                            @if ($product['category_name'] == 'Giày Nike')
                                <div class="contentContainer col-3">
                                    <a href="">
                                        @if ($product['image'])
                                            @if ($product['image'] && \Storage::exists($product['image']))
                                                <img src="{{ \Storage::url($product['image']) }}" alt=""
                                                    class="product_img">
                                            @endif
                                        @endif

                                        <div class="productInfoContainer">
                                            <p class="product_name">{{ $product['product_name'] }}
                                            </p>
                                            <p class="product_category">{{ $product['category_name'] }}
                                            </p>
                                            <p class="product_price">
                                                {{ number_format($product['price'], 0, ',', ' Triệu ') }}</p>
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
                    <a href="" class="productPreviewContainer__more">
                        <p>Xem Thêm</p>
                    </a>
                </div>
            </div>

            <div>
                <div class="productPreviewContainer">
                    <p class="productPreviewContainer__title">Adidas</p>
                    <div class="row mb-3">
                        @php $temp = 1;  @endphp
                        @foreach ($products as $product)
                            {{-- {{ dd($product) }} --}}
                            @if ($product['category_name'] == 'Giày Adidas')
                                <div class="contentContainer col-3">
                                    <a href="">
                                        @if ($product['image'])
                                            @if ($product['image'] && \Storage::exists($product['image']))
                                                <img src="{{ \Storage::url($product['image']) }}" alt=""
                                                    class="product_img">
                                            @endif
                                        @endif

                                        <div class="productInfoContainer">
                                            <p class="product_name">{{ $product['product_name'] }}
                                            </p>
                                            <p class="product_category">{{ $product['category_name'] }}
                                            </p>
                                            <p class="product_price">
                                                {{ number_format($product['price'], 0, ',', ' Triệu ') }}</p>
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
                    <a href="" class="productPreviewContainer__more">
                        <p>Xem Thêm</p>
                    </a>
                </div>
            </div>

            <div class="productPreviewContainer">
                <p class="productPreviewContainer__title">Đánh giá</p>
                <div class="productPreviewContainer__item">
                    <a href="/_sp/sp2_10.html">
                        <div class="productPreviewContainer__item__product">
                            <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                alt="">
                            <p class="des">Giày Adidas PureBoost 23 – IF2367</p>
                            <p class="size">Size: 40 - 42</p>
                            <p class="price">4 triệu 200 nghìn</p>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </main>
@endsection
