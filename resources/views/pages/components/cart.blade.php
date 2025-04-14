@extends('pages.layouts.layout')

@section('title')
    <title>Giỏ hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/cart.css">
@endsection

@section('content')
    <main>
        <p class="title">Giỏ hàng của bạn</p>

        {{-- FLASH MESSAGE --}}
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


        @if ($cartDetails->isEmpty())
            <h4 class="text-center mt-4 fw-light">Bạn chưa có sản phẩm nào trong giỏ hàng</h4>
        @else
            <form action="{{ route('order') }}" method="POST">
                @csrf
                <input type="hidden" name='type' value="cart">
                {{-- Danh mục --}}
                <div class="order__info">
                    <div class="row mb-4">
                        <div class="col-3">
                            <h5>Sản phẩm</h5>
                        </div>
                        <div class="col-2  d-flex justify-content-center">
                            <h5>Phân loại</h5>
                        </div>
                        <div class="col-2  d-flex justify-content-center">
                            <h5>Kích thước</h5>
                        </div>
                        <div class="col-2  d-flex justify-content-center">
                            <h5>Số lượng</h5>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <h5>Đơn giá</h5>
                        </div>
                        <div class="col-1">
                        </div>
                    </div>
                </div>


                {{-- Thoong tin sản phẩm --}}

                @foreach ($cartDetails as $i => $detail)
                    {{-- {{ dd($detail->product->sale_prices[0]->price, $detail) }} --}}
                    {{-- {{ dd($detail->product->name, $detail['quantity']) }} --}}
                    <div class="order__info__product d-flex row">
                        <div class="col-3 d-flex">
                            <div class="col-4">
                                @if ($detail->product->images[0]->img_path)
                                    @if ($detail->product->images[0]->img_path && \Storage::exists($detail->product->images[0]->img_path))
                                        <img src="{{ \Storage::url($detail->product->images[0]->img_path) }}" alt=""
                                            class="product_img">
                                    @endif
                                @endif
                            </div>
                            {{-- {{ dd($detail) }} --}}
                            <p class="col-8 d-flex align-items-center order__info__product_name">
                                {{ $detail->product->name }}</p>
                        </div>
                        @if ($detail['sizes'] != null)
                            <div class="col-2 d-flex justify-content-center">
                                <p>{{ $detail->product->category->name }}</p>
                            </div>

                            <div class="col-2 d-flex justify-content-center order__info__product__size">
                                <p>{{ $detail['size'] }}</p>
                            </div>
                            {{-- @if (in_array($detail['size'], $detail['sizes'])) --}}
                                <div class="col-2 d-flex justify-content-center">
                                    <div class="">
                                        <p type="text" class="text-center">{{ $detail['quantity'] }}
                                            @if (!in_array($detail['size'], $detail['sizes']))
                                            <i>(kích thước đã hết)</i>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            <div class="col-2 d-flex justify-content-center">
                                @foreach ($detail->product->sale_prices as $sale_price)
                                    @if ($sale_price['size'] == $detail['size'])
                                        <p>{{ number_format($sale_price['price'], 0, '', '.') }}</p>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="col-8 d-flex justify-content-center">
                                <p>Sản phẩm đã hết hàng hoặc bị gỡ bỏ</p>
                            </div>
                        @endif
                        <div class="col-1 d-flex" style="position: relative">
                            {{-- Radio --}}
                            <div class="form-check">
                                <input class="form-check-input cartCheckBox" type="checkbox" name="cartDetailId[]"
                                    value="{{ $detail['id'] }}" @disabled($detail['sizes'] == null)  @disabled(!in_array($detail['size'], $detail['sizes']))>
                            </div>

                            {{-- Tùy chọn --}}
                            {{-- {{ dd($detail, $quantities, $pendingQuantities) }} --}}
                            <i class="fa-solid fa-caret-down friendList__main__info__menu__activeMenu"
                                data-bs-toggle="dropdown"></i>
                            <ul class="dropdown-menu friendList__main__info__dropdownMenu">
                                <li><a class="dropdown-item" href="{{ route('product.detail', $detail->product['id']) }}"
                                        style="color: var(--font-color)">Xem sản
                                        phẩm</a>
                                </li>
                                @if ($detail['sizes'] != null)
                                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                            data-bs-target="#QuantityEdit" onclick="openEditForm( {{ $i }})"
                                            style="color: var(--font-color)">Chỉnh sửa</a>
                                    <li>
                                @endif
                                <hr class="dropdown-divider">
                                </hr>
                                </li>
                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal{{ $detail['id'] }}"><strong>Xóa sản phẩm</strong></a></li>
                            </ul>
                        </div>

                        <!-- Modal xóa sản phẩm -->
                        <div class="modal" id="modal{{ $detail['id'] }}">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <!-- Modal Header -->
                                    <div class="modal-header">
                                        <h5 class="modal-title">Xóa sản phẩm</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <!-- Modal body -->
                                    <div class="modal-body">
                                        Bạn có chắc chắn xóa sản phẩm <b>{{ $detail->product->name }}</b>
                                        Size <b>{{ $detail['size'] }}</b>?
                                    </div>

                                    <!-- Modal footer -->
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <a href="{{ route('deleteCart', $detail) }}" id="btn_deleteCart"
                                            class="btn btn-danger">Xóa</a>
                                    </div>

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
                            <button class="btn" type="submit" id="btn-submit" disabled
                                style="font-size: 1.2rem;font-weight: 700; color: var(--extra1-color)">Đặt hàng</button>
                        </div>
                    </div>
                </div>

            </form>

            <!-- Modal chỉnh sửa số lượng -->
            <div class="modal fade" id="QuantityEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h5 class="modal-title text-center ms-auto">
                                    Thêm vào giỏ hàng</h5>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ route('updateQuantity') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="row">
                                    <label for="product_id" class="form-label ">
                                        Sản phẩm:</label>
                                    <div class="mb-3">
                                        <!-- Fix csrf -->
                                        @csrf
                                        <input type="text" id="product_name" class="form-control mb-1" disabled>
                                        <input type="hidden" name="cart_detail_id" id="cart_detail_id">
                                    </div>
                                    <label for="phone" class="form-label"> Kích thước:</label>
                                    <div class="mb-3">
                                        <input type="hidden" name="product_id" id="product_id">
                                        <select name="size" id="select_input" class="form-select selectQuantity mb-2">
                                        </select>
                                        <i id="remain_quantity">Số lượng còn lại:</i>
                                    </div>
                                    <label for="phone" class="form-label"> Số lượng:</label>
                                    <div class="order__info__product__quantity">
                                        <div class="order__info__product__quantity__prepend">
                                            <button class="btn btn-outline-secondary" type="button">-</button>
                                        </div>
                                        <input type="text" class="form-control" value="1" name="quantity"
                                            id="quantity_input" min="1">
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
                                <button type="submit" class="btn btn-primary">Sửa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </main>
    <script>
        // Lấy cartDetails 
        const cartDetails = @json($cartDetails);
        const quantities = @json($quantities);
        const pendingQuantities = @json($pendingQuantities);

        function openEditForm(i) {
            const productNameInput = document.getElementById("product_name")
            const productIdInput = document.getElementById("product_id")
            const detailIdInput = document.getElementById("cart_detail_id")
            const quantityInput = document.getElementById("quantity_input")
            const selectInput = document.getElementById("select_input")

            console.log(cartDetails, cartDetails[i])

            productNameInput.value = cartDetails[i].product.name
            productIdInput.value = cartDetails[i].product_id
            detailIdInput.value = cartDetails[i].id
            quantityInput.value = cartDetails[i].quantity

            // Hiện danh sách số lượng của SP
            selectInput.innerHTML = "";
            let sizeSelect = cartDetails[i].sizes[0];
            cartDetails[i].sizes.forEach(size => {
                const option = document.createElement('option');
                option.value = size;
                option.textContent = `${size}`;

                // Nếu trùng size hiện tại, thì chọn
                if (size === cartDetails[i].size) {
                    option.selected = true;
                    sizeSelect = cartDetails[i].size
                }

                selectInput.appendChild(option);
            })

            // Hiện số lượng còn lại
            const remain_quantity = document.getElementById("remain_quantity")
            remain_quantity.textContent = "Số lượng còn lại: " +
                (quantities[productIdInput.value][sizeSelect] - pendingQuantities[productIdInput.value][
                    sizeSelect
                ])
        }

        // Hiện số lượng còn lại
        // const selectInput = document.querySelectorAll('select[name="size"]');
        const selectInput = document.getElementById("select_input")

        selectInput.addEventListener('change', function() {
            const selectedSize = this.value;
            const productInput = this.parentElement.querySelector("input[name='product_id']")
            const productId = productInput.value
            const quantityMessage = document.getElementById("remain_quantity")


            quantityMessage.textContent = "Số lượng còn lại: " +
                (quantities[productId][selectedSize] - pendingQuantities[productId][selectedSize])

        });
    </script>
@endsection

@section('js')
    <script src="/js/product.js"></script>
    <script src="/js/cart.js"></script>
@endsection
