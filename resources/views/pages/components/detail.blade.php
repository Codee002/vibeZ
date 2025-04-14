@extends('pages.layouts.layout')

@section('title')
    <title>Chi tiết sản phẩm</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="{{ asset('css/detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/product.css') }}">
    <link rel="stylesheet" href="{{ asset('css/evaluate.css') }}">
@endsection

@section('content')
    <main>
        <div class="mt-4">
            <div class="d-flex row" style="width: 100%">
                <!-- FLASH MESSAGE -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4" style="font-size: 1rem">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="alert alert-success" style="font-size: 1rem">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('danger'))
                    <div class="alert alert-danger" style="font-size: 1rem">
                        {{ session('danger') }}
                    </div>
                @endif
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

                    @if ($product['sizes'] != null)
                        <p class="detailContainer__price">
                            {{ number_format($product->sale_prices[0]->price, 0, '', ' Triệu ') }}
                        </p>
                    @else
                        <p class="detailContainer__price">
                            Sản phẩm đã hết hàng hoặc đã bị gỡ bỏ
                        </p>
                    @endif
                    {{-- {{ dd($product) }} --}}
                    @if ($product['sizes'] != null)
                        <div class="d-flex align-items-center mt-2">
                            {{-- Thêm vào giỏ --}}
                            <div class="detailContainer__submit">
                                <button type="submit" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#ModelAddCart{{ $product['id'] }}">
                                    Thêm vào giỏ
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="ModelAddCart{{ $product['id'] }}"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-size: 1rem">
                                    <div class="modal-dialog ">
                                        <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                                            <div class="modal-header">
                                                <strong>
                                                    <h5 class="modal-title text-center ms-auto">
                                                        Thêm vào giỏ hàng</h5>
                                                </strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('addToCart') }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <label for="product_id" class="form-label ">
                                                            Sản phẩm:</label>
                                                        <div class="mb-3">
                                                            <!-- Fix csrf -->
                                                            @csrf
                                                            <input type="text" id="name" class="form-control mb-1"
                                                                disabled value="{{ $product['name'] }}">
                                                            {{-- <input type="hidden" name="product_id" id="product_id"
                                                    value="{{ $product['product_id'] }}"> --}}
                                                        </div>
                                                        <label for="phone" class="form-label"> Kích thước:</label>
                                                        <div class="mb-3">
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product['id'] }}">
                                                            <select name="size" id=""
                                                                class="form-select selectQuantity mb-2">
                                                                @foreach ($product->sizes as $size)
                                                                    <option value="{{ $size }}">
                                                                        {{ $size }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <i id="quantity[{{ $product['id'] }}]">Số lượng còn lại:
                                                                {{ $quantities[$product['id']][$product->sizes[0]] }}</i>
                                                        </div>
                                                        {{-- <label for="phone" class="form-label"> Số lượng còn lại:</label> --}}
                                                        {{-- <div class="mb-3">
                                               <input type="number" value="1" disabled class="form-control">
                                            </div> --}}
                                                        <label for="phone" class="form-label"> Số lượng:</label>
                                                        <div class="order__info__product__quantity">
                                                            <div class="order__info__product__quantity__prepend">
                                                                <button class="btn btn-outline-secondary"
                                                                    type="button">-</button>
                                                            </div>
                                                            <input type="text" class="form-control" value="1"
                                                                name="quantity" min="1">
                                                            <div class="order__info__product__quantity__apend">
                                                                <button class="btn btn-outline-secondary"
                                                                    type="button">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">
                                                        Hủy
                                                        bỏ</button>
                                                    <button type="submit" class="btn btn-primary">Thêm</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Mua ngay --}}
                            <div class="detailContainer__submit">
                                <button type="submit" class="btn" data-bs-toggle="modal"
                                    data-bs-target="#ModelOrder{{ $product['id'] }}">
                                    Mua ngay
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="ModelOrder{{ $product['id'] }}"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true" style="font-size: 1rem">
                                    <div class="modal-dialog ">
                                        <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                                            <div class="modal-header">
                                                <strong>
                                                    <h5 class="modal-title text-center ms-auto">
                                                        Mua ngay</h5>
                                                </strong>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('order') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="type" value="detail">
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <label for="product_id" class="form-label ">
                                                            Sản phẩm:</label>
                                                        <div class="mb-3">
                                                            <!-- Fix csrf -->
                                                            @csrf
                                                            <input type="text" id="name"
                                                                class="form-control mb-1" disabled
                                                                value="{{ $product['name'] }}">
                                                            {{-- <input type="hidden" name="product_id" id="product_id"
                                                                            value="{{ $product['product_id'] }}"> --}}
                                                        </div>
                                                        <label for="phone" class="form-label"> Kích thước:</label>
                                                        <div class="mb-3">
                                                            <input type="hidden" name="product_id"
                                                                value="{{ $product['id'] }}">
                                                            <select name="size" id=""
                                                                class="form-select selectQuantity mb-2">
                                                                @foreach ($product->sizes as $size)
                                                                    <option value="{{ $size }}">
                                                                        {{ $size }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <i id="quantity[{{ $product['id'] }}]">Số lượng còn lại:
                                                                {{ $quantities[$product['id']][$product->sizes[0]] }}</i>
                                                        </div>
                                                        {{-- <label for="phone" class="form-label"> Số lượng còn lại:</label> --}}
                                                        {{-- <div class="mb-3">
                                                                       <input type="number" value="1" disabled class="form-control">
                                                                    </div> --}}
                                                        <label for="phone" class="form-label"> Số lượng:</label>
                                                        <div class="order__info__product__quantity">
                                                            <div class="order__info__product__quantity__prepend">
                                                                <button class="btn btn-outline-secondary"
                                                                    type="button">-</button>
                                                            </div>
                                                            <input type="text" class="form-control" value="1"
                                                                name="quantity" min="1">
                                                            <div class="order__info__product__quantity__apend">
                                                                <button class="btn btn-outline-secondary"
                                                                    type="button">+</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                                                    <button type="button" class="btn btn-danger"
                                                        data-bs-dismiss="modal">
                                                        Hủy
                                                        bỏ</button>
                                                    <button type="submit" class="btn btn-primary">Mua</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                                        <p class="me-2">{{ $size }}</p>
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
                        {{-- {{dd($product)}} --}}
                        <a href="{{ route('evaluate.index', $product['id']) }}" style="width: 100%">
                            <div class="evaluate__container productPreviewContainer  mt-2">
                                <h4 class="product-title" style="font-size: 1.2rem">
                                    @if ($countEvaluate != 0)
                                        {{ $averageRate }} <span class="star active">★</span>
                                    @endif
                                    Đánh giá ({{ $countEvaluate }})
                                </h4>
                                <i class='bx bx-right-arrow-alt nav'></i>

                                <div class="product-content__info ">
                                    <div class="col-12 d-flex flex-column align-items-start product-evaluate">
                                        @if ($product->evaluates->isNotEmpty())
                                            @foreach ($product->evaluates as $evaluate)
                                                <hr width="100%">
                                                {{-- {{ dd($product->evaluates, $evaluate) }} --}}

                                                <div style="width: 100%" class="d-flex align-items-center row">
                                                    <p class="col-2"></b><i class='bx bx-user'></i>:</b></p>
                                                    <p class="col-8"> {{ $evaluate->order->user['name'] }}</p>
                                                    <p class="col-2">
                                                        {{ \Carbon\Carbon::parse($evaluate['updated_at'])->format('d/m/Y') }}
                                                    </p>
                                                </div>

                                                <div style="width: 100%" class="product-rate">
                                                    <div class="star-rating d-flex align-items-center row"
                                                        style="width: 100%">
                                                        <p class="col-2"><b>Số sao:</b></p>
                                                        <div class="col-10">
                                                            <span class="star" data-rating="1">★</span>
                                                            <span class="star" data-rating="2">★</span>
                                                            <span class="star" data-rating="3">★</span>
                                                            <span class="star" data-rating="4">★</span>
                                                            <span class="star" data-rating="5">★</span>
                                                            <input type="hidden" class="selected_rating"
                                                                value="{{ $evaluate['rate'] }}">

                                                        </div>
                                                    </div>
                                                </div>

                                                <div style="width: 100%" class="d-flex align-items-center row mb-2">
                                                    <p class="col-2"><b>Đánh giá: </b></p>
                                                    <p class="col-10">{{ $evaluate['content'] ?? '(Không có nội dung)' }}
                                                    </p>
                                                </div>

                                                {{-- {{ dd($evaluate->order, $evaluate->order->order_details) }} --}}
                                                <div style="width: 100%" class="d-flex align-items-center row mb-2">
                                                    <p class="col-2"><b>Size: </b></p>
                                                    <p class="col-10">
                                                        @foreach ($evaluate->order->order_details as $temp)
                                                            @if ($temp['product_id'] == $evaluate['product_id'])
                                                                {{ $temp['size'] }}
                                                            @endif
                                                        @endforeach
                                                    </p>
                                                </div>

                                                <div class="row d-flex" style="width: 100%">
                                                    <p class="col-2"><b>Ảnh:</b></p>
                                                    @if ($evaluate['image'])
                                                        @if ($evaluate['image'] && \Storage::exists($evaluate['image']))
                                                            <a class="col-10"
                                                                href="{{ \Storage::url($evaluate['image']) }}"><img
                                                                    src="{{ \Storage::url($evaluate['image']) }}"
                                                                    alt="" class="product_img ms-2"
                                                                    style="height: 9rem; width: 8rem;"></a>
                                                        @endif
                                                    @else
                                                        <p class="col-10">(Không có ảnh đánh giá)</p>
                                                    @endif
                                                </div>
                                            @endforeach
                                            <hr width="100%">
                                        @else
                                            <div class="p-2 row" style="width:100%">
                                                <div class="col-2"></div>
                                                <p class="title col-7">(Sản phẩm chưa có đánh giá)</p>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </a>

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
<style>
    .product-evaluate p {
        margin: 0
    }
</style>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Sao đánh giá
        const productReviews = document.querySelectorAll('.product-rate');
        console.log(productReviews)
        productReviews.forEach(reviewContainer => {
            const stars = reviewContainer.querySelectorAll('.star-rating .star');
            const selectedRatingInput = reviewContainer.querySelector('.selected_rating');
            highlightStars(stars, parseInt(selectedRatingInput.value));
            // console.log(productReviews, reviewContainer, selectedRatingInput)
        });

        // Tô màu
        function highlightStars(starElements, rating) {
            starElements.forEach(star => {
                const starValue = parseInt(star.dataset.rating);
                if (starValue <= rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        // Số lượng SP
        const selectInput = document.querySelectorAll('select[name="size"]');

        console.log(selectInput);
        selectInput.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedSize = this.value;
                const productInput = this.parentElement.querySelector(
                    "input[name='product_id']")
                const productId = productInput.value
                const quantityMessage = this.parentElement.querySelector(
                    "i[id='quantity[" + productId + "]']")

                const quantities = @json($quantities);
                const pendingQuantities = @json($pendingQuantities);

                quantityMessage.textContent = "Số lượng còn lại: " +
                    (quantities[productId][selectedSize] - pendingQuantities[productId][
                        selectedSize
                    ])

            });
        });
    });
</script>
@section('js')
    <script src="{{ asset('/js/product.js') }}"></script>
@endsection
