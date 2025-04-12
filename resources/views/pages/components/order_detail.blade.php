@extends('pages.layouts.layout')

@section('title')
    <title>Xác nhận đơn hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/order_detail.css') }}">
@endsection

@section('content')
    <main>
        <form action="{{ route('order.store') }}" method="POST" onsubmit="return formConfirm('delivery', 'payMethod')">
            @csrf

            <!-- FLASH MESSAGE -->
            <div class="">
                <ul id="errors">
                </ul>
            </div>

            {{-- Thông tin khách hàng --}}
            <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model1">
                <h5>Địa chỉ nhận hàng</h5>
                <div class="order__info__user">
                    <p id="selected-name">{{ $deliveryDefault['name'] ?? 'Vui lòng chọn thông tin giao hàng' }}</p>
                    <p id="selected-phone">{{ $deliveryDefault['phone'] ?? '' }}</p>
                    <p id="selected-address">{{ $deliveryDefault['address'] ?? '' }}
                    </p>

                </div>
                <i class='bx bx-right-arrow-alt'></i>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="Model1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h1 class="modal-title text-center ms-auto">
                                    Chọn thông tin nhận hàng</h1>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <!-- Fix CSRF -->
                                @csrf

                                @if ($deliveryInfos->isNotEmpty())
                                    
                                @foreach ($deliveryInfos as $deliveryInfo)
                                    <div class="d-flex mb-3">
                                        <input class="form-check-input" type="radio" name="delivery" id="delivery"
                                            value="{{ $deliveryInfo['id'] }}" @checked($deliveryInfo['default'] == 1)>
                                        <div class="order__info__user p-0 ms-3">
                                            <p>{{ $deliveryInfo['name'] }}
                                                @if ($deliveryInfo['default'] == 1)
                                                    <i>(Mặc định)</i>
                                                @endif
                                            </p>
                                            <p>{{ $deliveryInfo['phone'] }}</p>
                                            <p>
                                                {{ $deliveryInfo['address'] }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                                @else
                                <div class="d-flex mb-3">
                                    <p>Bạn chưa có địa chỉ nào</p>
                                </div>
                                @endif

                            </div>
                        </div>
                        <div
                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                            <a href="{{ route('delivery.create') }}" class="btn btn-success">Thêm địa chỉ</a>
                            <button type="button" id="select-delivery" class="btn btn-primary"
                                data-bs-dismiss="modal">Chọn</button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Danh mục --}}
            <div class="order__info">
                <div class="row mb-4">
                    <div class="col-4">
                        <h5>Sản phẩm</h5>
                    </div>
                    <div class="col-2  d-flex justify-content-center">
                        <h5>Phân loại</h5>
                    </div>
                    <div class="col-2  d-flex justify-content-center">
                        <h5>Đơn giá</h5>
                    </div>
                    <div class="col-2  d-flex justify-content-center">
                        <h5>Số lượng</h5>
                    </div>
                    <div class="col-2  d-flex justify-content-center">
                        <h5>Thành tiền</h5>
                    </div>
                </div>

                {{-- Phân biệt xem đặt hàng do đâu --}}
                @if ($type == 'cart')
                    <input type="hidden" name="type" value="cart">
                    @foreach ($cartIds as $cartDetailId)
                        <input type="hidden" name="cartDetailId[]" value="{{ $cartDetailId }}">
                    @endforeach
                @endif
                @foreach ($cartDetails as $detail)
                    {{-- Thông tin sản phẩm --}}
                    <input type="hidden" name="products[]" value="{{ $detail['product_id'] }}">
                    <input type="hidden" name="sizes[]" value="{{ $detail['size'] }}">
                    <input type="hidden" name="quantities[]" value="{{ $detail['quantity'] }}">
                    <input type="hidden" name="prices[]" value="{{ $detail['price'] }}">

                    {{-- {{ dd($detail) }} --}}
                    {{-- Thoong tin sản phẩm --}}
                    <div class="order__info__product d-flex row">
                        <div class="col-4 d-flex">
                            <div class="col-4">
                                @if ($detail->product->images[0]->img_path)
                                    @if ($detail->product->images[0]->img_path && \Storage::exists($detail->product->images[0]->img_path))
                                        <img src="{{ \Storage::url($detail->product->images[0]->img_path) }}"
                                            alt="" class="product_img">
                                    @endif
                                @endif
                            </div>
                            <div class="ms-2 col-8 d-flex flex-column p-3">
                                <div>
                                    <p class="d-flex order__info__product__name">{{ $detail->product->name }}</p>
                                    <p class="d-flex order__info__product__size">Size: {{ $detail['size'] }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center p-3">
                            <p>{{ $detail->product->category->name }}</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center p-3">
                            <p>{{ number_format($detail['price'], 0, ',', '.') }}</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center p-3">
                            <p>{{ $detail['quantity'] }}</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center p-3">
                            <p>{{ number_format($detail['price'] * $detail['quantity'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Khuyến mãi --}}
            <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model2">
                <h5>Khuyến mãi</h5>
                <div class="order__info__user">
                    <p id="selected-discounts">Chưa áp dụng mã khuyến mãi nào</p>
                </div>
                <i class='bx bx-right-arrow-alt'></i>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="Model2" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h1 class="modal-title text-center ms-auto">
                                    Chọn khuyến mãi</h1>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <!-- Fix CSRF -->
                                @csrf
                                <label for="oldpass" class="form-label ">
                                    Khuyến mãi:</label>
                                <div class="form-group">
                                    <select class="form-select" name="discounts[]" multiple>
                                        @if ($discounts == null)
                                            <option value="" disabled>Không có khuyến mãi</option>
                                        @else
                                            @foreach ($discounts as $discount)
                                                <option value="{{ $discount['id'] }}">
                                                    {{ $loop->iteration . '. ' . $discount->category['name'] . ': ' . $discount['percent'] . '%' }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="mb-3 invalid-feedback" style="display: block"></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                bỏ</button>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Chọn</button>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Phương thức thanh toán --}}
            <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model3">
                <h5>Phương thức thanh toán</h5>
                <div class="order__info__user">
                    <p id="selected-paymenthod">Chọn phương thức thanh toán</p>
                </div>
                <i class='bx bx-right-arrow-alt'></i>
            </div>
            <!-- Modal -->
            <div class="modal fade" id="Model3" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h1 class="modal-title text-center ms-auto">
                                    Chọn phương thức thanh toán</h1>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                {{-- {{ dd($payMenthods) }} --}}
                                <label for="oldpass" class="form-label ">
                                    Phương thức thanh toán</label>
                                <div class="form-group">
                                    <select class="form-select" name="payMethod" id="payMethod">
                                        <option value="" disabled selected>Chọn phương thức thanh toán</option>
                                        @foreach ($payMenthods as $payMenthod)
                                            <option value="{{ $payMenthod['id'] }}" @disabled($payMenthod['status'] == 'off')>
                                                {{ $payMenthod['name'] }}
                                                @if ($payMenthod['status'] == 'off')
                                                    <i> (Chưa hỗ trợ)</i>
                                                @endif
                                            </option>
                                        @endforeach

                                    </select>
                                    <span class="mb-3 invalid-feedback" style="display: block"></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                            <a type="button" href="{{ url()->previous() }}" class="btn btn-danger"
                                data-bs-dismiss="modal"> Hủy
                                bỏ</a>
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Chọn</button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tổng hóa đơn --}}
            <div class="order__info__sum row mb-2">
                <div class="col-8"></div>
                <div class="col-4 d-flex">
                    <div class="col-8 order__info__sum__type">
                        <p>Tổng tiền sản phẩm</p>
                        <p>Tổng phí vận chuyển</p>
                        <p>Tổng khuyến mãi</p>
                        <p>Khách hàng thân thuộc</p>
                        <hr>
                        <p style="font-size: 1.2rem; font-weight:600; color: var(--extra1-color)">Tổng thanh toán</p>
                    </div>
                    <div class="col-4 order__info__sum__price" style="text-align:end;">
                        <p id="totalPriceProduct">{{ number_format($totalPriceProduct, 0, '', '.') }}</p>
                        <p id="priceDelivery">{{ number_format($priceDelivery, 0, '', '.') }}</p>
                        <p id="pricePromotion">{{ number_format($pricePromotion, 0, '', '.') }}</p>
                        <p id="pricePromotion">{{ number_format($priceRankDiscount, 0, '', '.') }}</p>
                        <hr>
                        <p style="font-size: 1.2rem;" id="finalPrice">
                            {{ number_format($totalPriceProduct + $priceDelivery - $pricePromotion - $priceRankDiscount, 0, '', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Tổng giá --}}
            <input type="hidden" name="total_price"
                value="{{ $totalPriceProduct + $priceDelivery - $pricePromotion - $priceRankDiscount}}">
            <input type="hidden" name="rank_discount"
                value="{{ $priceRankDiscount }}">

            {{-- Lựa chọn --}}
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4 d-flex">
                    <div class="order__info__option">
                        <button class="btn" type="button" style="font-weight:600; "><a
                                href="{{ url()->previous() }}">Hủy</a></button>
                        <button class="btn" type="submit" style="font-weight:600; color: var(--extra1-color)">Đặt
                            hàng</button>
                    </div>
                </div>
            </div>
        </form>
    </main>

    {{-- Thay đổi thông tin khi đặt hàng --}}
    <script>
        // Địa chỉ
        const deliveryRadios = document.querySelectorAll('input[name="delivery"]');
        const addressName = document.getElementById('selected-name');
        const addressPhone = document.getElementById('selected-phone');
        const addressDetails = document.getElementById('selected-address');

        deliveryRadios.forEach(radio => {
            radio.addEventListener('change', function() {
                const selectedAddressId = this.value;

                console.log(this.value)
                const deliveryInfos = @json($deliveryInfos); // Chuyển dữ liệu PHP sang JSON

                // console.log(deliveryInfos)
                // Tìm thông tin địa chỉ tương ứng
                const selectedAddress = deliveryInfos.find(delivery => delivery.id == selectedAddressId);
                // console.log(selectedAddress.name)

                if (selectedAddress) {
                    addressName.textContent = selectedAddress.name;
                    addressPhone.textContent = selectedAddress.phone;
                    addressDetails.textContent = selectedAddress.address;
                }
            });
        });

        // Khuyến mãi
        const discountsSelect = document.querySelector('select[name="discounts[]"]');
        const selectedDiscounts = document.getElementById("selected-discounts");
        discountsSelect.addEventListener("change", function() {
            const selectedValues = [];
            const selectedOptions = this.selectedOptions

            // Lấy DS khuyến mãi được chọn
            for (let i = 0; i < selectedOptions.length; i++) {
                selectedValues.push(selectedOptions[i].value)
            }
            const discountValues = @json($discounts);
            const discountDes = [];

            // Tìm ra thông tin các khuyến mãi được chọn
            selectedValues.forEach((id) => {
                // console.log(discount, selectedValues[i])
                let temp = discountValues.find(e => e.id == id)
                discountDes.push(temp)
            })

            // Nếu có khuyến mãi
            if (discountDes) {
                let content = ""

                // Giá khuyến mãi
                let pricePromotion = 0;
                p_pricePromotion = document.getElementById("pricePromotion")

                // Giá đơn hàng
                p_finalPrice = document.getElementById("finalPrice")
                let totalPriceProduct = @json($totalPriceProduct);
                let input_finalPrice = document.querySelector('input[name="total_price"]');

                // Giá KM khách hàng thân thuộc
                let priceRankDiscount = @json($priceRankDiscount);

                const cartDetails = @json ($cartDetails);

                discountDes.forEach((discount, i) => {
                    // Hiển thị cho người dùng
                    content += (i + 1) + ". " +
                        discount.des + " " + discount.percent + "%<br>";

                    // Cập nhật giá khuyến mãi cho từng SP
                    for (let j = 0; j < cartDetails.length; j++) {
                        if (cartDetails[j].product.category_id == discount.category_id) {
                            pricePromotion += cartDetails[j].totalPrice * (discount.percent) / 100;
                        }
                    }

                })
                p_pricePromotion.textContent = pricePromotion
                p_finalPrice.textContent = totalPriceProduct - pricePromotion - priceRankDiscount + 30
                selectedDiscounts.innerHTML = content
                input_finalPrice.value = totalPriceProduct - pricePromotion - priceRankDiscount + 30
                // console.log(input_finalPrice.value);
            }
        })

        // Thanh toán
        const paySelecte = document.querySelector('select[name="payMethod"]');
        const payMenthod = document.getElementById('selected-paymenthod');

        paySelecte.addEventListener("change", function() {
            const payMethodId = this.value;
            const payMethodValues = @json($payMenthods);
            const selectedPayMenthod = payMethodValues.find(e => e.id == payMethodId)
            console.log(selectedPayMenthod, payMethodId, payMethodValues)
            if (selectedPayMenthod) {
                payMenthod.textContent = selectedPayMenthod.name
            }
        })
    </script>
@endsection
@section('js')
    <script src="{{ asset('/js/order.js') }}"></script>
@endsection
