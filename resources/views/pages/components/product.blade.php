@extends('pages.layouts.layout')

@section('title')
    <title>Danh sách sản phẩm</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/product.css">
@endsection

@section('content')
    <main>
        <hr>
        <div class="search" action="{{ route('product') }}" method="GET">
            <form action="" style="width: 100%">
                <div class="row">
                    <div class="form-group mb-3 col-3">
                        <input type="text" name="name" class="form-control" placeholder="Tìm kiếm"
                            value={{ $name }}>
                    </div>
                    <div class="col-3">
                        <button type="submit" style="width:50%" class="btn btn-primary text-center">
                            <i class='bx bx-search-alt'></i> Tìm</button>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group mb-3 col-3">
                        <select name="category" id="category" class="form-select">
                            <option value="" selected>Chọn danh mục</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}"
                                    @isset($categorySearch)
                                    {{ $category['id'] == $categorySearch['id'] ? 'selected' : '' }}
                                    @endisset>
                                    {{ $category['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- <div class="form-group mb-3 col-3">
                        <select name="size" id="size" class="form-select">
                            <option value="" selected>Size</option>
                            @foreach ($sizes as $size)
                                <option value="{{$size['size']}}">{{$size['size']}}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    {{-- <div class="form-group mb-3 col-3">
                    <select name="sale" id="sale" class="form-select">
                        <option value="" disabled selected>Khuyến mãi</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div> --}}
                    {{-- <div class="form-group mb-3 col-3">
                        <select name="sort" id="sort" class="form-select">
                            <option value="" disabled selected>Giá</option>
                            <option value="desc">Giảm dần</option>
                            <option value="asc">Tăng dần</option>

                        </select>
                    </div> --}}
                </div>
            </form>
        </div>
        <hr>
        @if (isset($name) || isset($categorySearch))
            @isset($name)
                <h5 class="">Từ Khóa Tìm Kiếm: <b>{{ $name }}</h5>
            @endisset
            @isset($categorySearch)
                <h5 class="mb-4">Danh Mục: <b>{{ $categorySearch['name'] }}</h5>
            @endisset
        @else
            <h4 class="mb-4">Sản Phẩm Cập Nhật Mới Nhất T3/2025</h4>
        @endif

        <!-- FLASH MESSAGE -->
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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


        <div class="">
            <div class="row">
                @if ($products->isNotEmpty())
                    {{-- {{ dd($products) }} --}}
                    @foreach ($products as $product)
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
                                        {{ number_format($product->price['price'], 0, ',', ' Triệu ') }}
                                        <i class="bx bxs-cart-add" data-bs-toggle="modal"
                                            data-bs-target="#Model{{ $product['product_id'] }}"></i>
                                    </p>
                                </div>
                            </a>
                        </div>
                        {{-- {{dd($product)}} --}}

                        <!-- Modal -->
                        <div class="modal fade" id="Model{{ $product['product_id'] }}" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
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
                                                    <input type="text" id="product_name" class="form-control mb-1"
                                                        disabled value="{{ $product['product_name'] }}">
                                                    {{-- <input type="hidden" name="product_id" id="product_id"
                                                        value="{{ $product['product_id'] }}"> --}}
                                                </div>
                                                <label for="phone" class="form-label"> Kích thước:</label>
                                                <div class="mb-3">
                                                    <input type="hidden" name="product_id" id="product_id"
                                                        value="{{ $product['product_id'] }}">
                                                    <select name="size" id=""
                                                        class="form-select selectQuantity mb-2">
                                                        @foreach ($product['sizes'] as $size)
                                                            <option value="{{ $size }}">{{ $size }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <i id="quantity[{{ $product['product_id'] }}]">Số lượng còn lại:
                                                        {{ $quantities[$product['product_id']][$product['sizes'][0]] - $pendingQuantities[$product['product_id']][$product['sizes'][0]] }}</i>
                                                </div>
                                                {{-- <label for="phone" class="form-label"> Số lượng còn lại:</label> --}}
                                                {{-- <div class="mb-3">
                                                   <input type="number" value="1" disabled class="form-control">
                                                </div> --}}
                                                <label for="phone" class="form-label"> Số lượng:</label>
                                                <div class="order__info__product__quantity">
                                                    <div class="order__info__product__quantity__prepend">
                                                        <button class="btn btn-outline-secondary" type="button">-</button>
                                                    </div>
                                                    <input type="text" class="form-control" value="1"
                                                        name="quantity" min="1">
                                                    <div class="order__info__product__quantity__apend">
                                                        <button class="btn btn-outline-secondary" type="button">+</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                                bỏ</button>
                                            <button type="submit" class="btn btn-primary">Thêm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h4 class="text-center">Không tìm thấy sản phẩm với từ khóa <b>{{ $name }}</b></h4>
                @endif
                <div class="mt-5">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </main>
    <script>
        // Số lượng
        const selectInput = document.querySelectorAll('select[name="size"]');

        console.log(selectInput);
        selectInput.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedSize = this.value;
                const productInput = this.parentElement.querySelector("input[name='product_id']")
                const productId = productInput.value
                const quantityMessage = document.getElementById("quantity[" + productId + "]")
                console.log(selectedSize, productId, quantityMessage, "quantity[" + productId + "]")

                const quantities = @json($quantities);
                const pendingQuantities = @json($pendingQuantities);

                quantityMessage.textContent = "Số lượng còn lại: " +
                    (quantities[productId][selectedSize] - pendingQuantities[productId][selectedSize])

            });
        });
    </script>
@endsection
@section('js')
    <script src="{{ asset('/js/product.js') }}"></script>
@endsection
