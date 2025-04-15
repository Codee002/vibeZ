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
        {{-- <img class="banner" src="/assets/images/banner/main_banner.jpg">
        </img> --}}
        <img class="banner" src="{{ \Storage::url(\App\Models\GeneralImage::getBannner()) }}">
        </img>
        {{-- {{\App\Models\GeneralImage::getBannner()}} --}}
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

                    <a href="{{ route('order.history') }}">
                        <div class="visitContainer__item">
                            <div class="content">
                                <i class='bx bxs-package'></i>
                                <a href="{{ route('order.history') }}">
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
                                    <a href="{{ route('product.detail', $product['product_id']) }}">
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
                    <a href="{{ route('product', ['category' => 25]) }}" class="productPreviewContainer__more">
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
                                    <a href="{{ route('product.detail', $product['product_id']) }}">
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
                    <a href="{{ route('product', ['category' => 25]) }}" class="productPreviewContainer__more">
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
                                    <a href="{{ route('product.detail', $product['product_id']) }}">
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
                    <a href="{{ route('product', ['category' => 26]) }}" class="productPreviewContainer__more">
                        <p>Xem Thêm</p>
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
