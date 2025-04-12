@extends('pages.layouts.layout')

@section('title')
    <title>Chi tiết đơn hàng đã đặt</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/delivery.css') }}">
    <link rel="stylesheet" href="{{ asset('css/order_detail.css') }}">
@endsection

@section('content')
    <main>
        <p class="title">Chi tiết đơn hàng</p>

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

        {{-- Thông tin khách hàng --}}
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model1">
            <h5>Địa chỉ nhận hàng</h5>
            <div class="order__info__user">
                <p id="selected-name">{{ $order->delivery_info['name'] }}</p>
                <p id="selected-phone">{{ $order->delivery_info['phone'] }}</p>
                <p id="selected-address">{{ $order->delivery_info['address'] }}
                </p>

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

            @foreach ($order->order_details as $detail)
                {{-- {{dd($detail, $detail->product )}} --}}

                {{-- Thoong tin sản phẩm --}}
                <div class="order__info__product d-flex row">
                    <div class="col-4 d-flex">
                        <div class="col-4">
                            @if ($detail->product->images[0]->img_path)
                                @if ($detail->product->images[0]->img_path && \Storage::exists($detail->product->images[0]->img_path))
                                    <img src="{{ \Storage::url($detail->product->images[0]->img_path) }}" alt=""
                                        class="product_img">
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

        {{-- {{ dd($order->discounts->isNotEmpty()) }} --}}
        {{-- Khuyến mãi --}}
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model2">
            <h5>Khuyến mãi</h5>
            <div class="order__info__user">
                @if ($order->discounts->isNotEmpty())
                    @foreach ($order->discounts as $discount)
                        <p>{{ $discount['des'] . ' ' . $discount['percent'] . '%' }}</p>
                    @endforeach
                @else
                    <p>Chưa áp dụng khuyến mãi</p>
                @endif

            </div>
        </div>

        {{-- {{dd($order->payment_method)}} --}}
        {{-- Phương thức thanh toán --}}
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model3">
            <h5>Phương thức thanh toán</h5>
            <div class="order__info__user">
                <p id="selected-paymenthod">{{ $order->payment_method['name'] }}</p>
            </div>
        </div>

        {{-- {{dd($order->getTotalDiscount())}}  --}}
        {{-- Tổng hóa đơn --}}
        <div class="order__info__sum row mb-2">
            <div class="col-8"></div>
            <div class="col-4 d-flex">
                <div class="col-8 order__info__sum__type">
                    <p>Trạng thái</p>
                    <p>Tổng tiền sản phẩm</p>
                    <p>Tổng phí vận chuyển</p>
                    <p>Tổng khuyến mãi</p>
                    <p>Khách hàng thân thuộc</p>
                    <hr>
                    <p style="font-size: 1.2rem; font-weight:600; color: var(--extra1-color)">Tổng thanh toán</p>
                </div>
                <div class="col-4 order__info__sum__price" style="text-align:end;">
                    @if ($order['status'] == 'pending')
                        <p class="text-warning">Đang duyệt</p>
                    @elseif ($order['status'] == 'rejecting')
                        <p class="text-danger">Bị từ chối</p>
                    @elseif ($order['status'] == 'aborting')
                        <p class="text-danger">Đã hủy</p>
                    @elseif ($order['status'] == 'shipping')
                        <p class="text-secondary">Đang giao</p>
                    @elseif ($order['status'] == 'completing')
                        <p class="text-success">Hoàn thành</p>
                    @endif
                    {{-- <p id="totalPriceProduct">0</p> --}}
                    <p id="totalPriceProduct">{{ number_format($order->getTotalPrice(), 0, '', '.') }}</p>
                    <p id="priceDelivery">{{ number_format($priceDelivery, 0, '', '.') }}</p>
                    {{-- <p id="pricePromotion">0</p> --}}
                    <p id="pricePromotion">{{ number_format($order->getTotalDiscount(), 0, '', '.') }}</p>
                    <p id="pricePromotion">{{ number_format($order['priceRankDiscount'], 0, '', '.') }}</p>
                    <hr>
                    <p style="font-size: 1.2rem;" id="finalPrice">
                        {{ number_format($order['total_price'], 0, '', '.') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Lựa chọn --}}
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 d-flex">
                <div class="order__info__option justify-content-end p-0">
                    @if ($order['status'] == 'pending')
                        <form action="{{ route('order.abort', $order) }}" method="POST" style="width: 45%" class="ms-3">
                            @csrf
                            <button class="btn " type="submit" style="font-weight:600; width: 100%"
                                onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?')">
                                Hủy đơn
                            </button>
                        </form>
                    @elseif ($order['status'] == 'shipping')
                        <form action="{{ route('order.receive', $order) }}" method="POST" style="width: 45%"
                            class="ms-3">
                            @csrf
                            <button class="btn " type="submit" style="font-weight:600; width: 100%"
                                onclick="return confirm('Khi nhận hàng, bạn sẽ thanh toán cho đơn hàng')">
                                Đã nhận hàng
                            </button>
                        </form>
                    @elseif ($order['status'] == 'completing')
                        <form action="{{ route('order.pdf', $order) }}" method="get" style="width: 45%"
                            class="col-5 ms-2">
                            <button class="btn " type="submit" style="font-weight:600; width: 100%">
                                In hóa đơn
                            </button>
                        </form>
                        @if ($order->evaluates->isEmpty())
                            <form action="{{ route('evaluate.create', $order) }}" method="get" style="width: 45%"
                                class="ms-3">
                                <button class="btn " type="submit" style="font-weight:600; width: 100%">
                                    Đánh giá
                                </button>
                            </form>
                        @else
                            <form action="{{ route('evaluate.show', $order) }}" method="get" style="width: 45%"
                                class="ms-3">
                                <button class="btn " type="submit" style="font-weight:600; width: 100%">
                                    Xem đánh giá
                                </button>
                            </form>
                        @endif
                    @endif
                </div>
            </div>
        </div>

    </main>
@endsection
