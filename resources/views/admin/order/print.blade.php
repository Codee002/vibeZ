<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng</title>

    <style>
        body {
            font-family: 'DejaVu Sans', sans-serif;
        }


        /* Order_detail CSS */
        main {
            padding: 0rem;
            margin: 0rem 0rem;
            background-color: #fff;
        }

        main p {
            padding: 0rem;
            margin: 0em;
            /* font-size: 1.6rem; */
            font-size: 1rem;
        }

        .order__info {
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1.4rem;
            position: relative;
        }

        .order__info i {
            /* font-size: 2.4rem; */
            font-size: 1.6rem;
            position: absolute;
            top: 1rem;
            right: 1rem;
        }

        .order__info__user {
            padding: 0rem 3rem;
            /* display: flex;
            justify-content: center; */
        }

        .order__info__product {
            padding: 1rem 0rem;
        }

        .order__info__product__name {
            text-overflow: ellipsis;
            white-space: nowrap;
            overflow: hidden;
            font-weight: 450;
            width: 20rem;
        }

        .order__info__sum__type p {
            font-weight: 350;
            margin-bottom: .8rem;
        }

        .order__info__sum__price p {
            font-weight: 600;
            margin-bottom: .8rem;
        }


        .row-product {
            display: block;
            /* Để tạo hàng mới cho mỗi sản phẩm */
            margin-bottom: 10px;
            /* Khoảng cách giữa các sản phẩm */
        }

        .col-product {
            display: inline-block;
            vertical-align: top;
            /* Căn chỉnh theo chiều dọc */
            padding: 5px;
            box-sizing: border-box;
            /* Để padding không làm tăng width */
        }

        .col-product-sanpham {
            width: 20%;
            text-align: center;
        }

        .col-product-size {
            width: 10%;
            text-align: center;
        }
        .col-product-phanloai {
            width: 15%;
            text-align: center;
        }

        .col-product-dongia {
            width: 15%;
            text-align: center;
        }

        .col-product-soluong {
            width: 15%;
            text-align: center;
        }

        .col-product-thanhtien {
            width: 20%;
            text-align: center;
        }

        h4{
            margin: 5px;
        }
        hr {
            border: none;
            border-top: 1.4px solid #ccc;
            margin-top: 2px;
            margin-bottom: 2px;
        }
    </style>
</head>

<body>
    <main>
        <h3 style="text-align: center">VibeZ - TRENDY SNEAKER</h3>
        <hr>
        {{-- Thông tin khách hàng --}}
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model1" style="padding: 0rem">
            <h4>Địa chỉ nhận hàng</h4>
            <div class="order__info__user">
                <p id="selected-name">{{ $order->delivery_info['name'] }}</p>
                <p id="selected-phone">{{ $order->delivery_info['phone'] }}</p>
                <p id="selected-address">{{ $order->delivery_info['address'] }}
                </p>

            </div>
        </div>

        <hr>

        {{-- Danh mục --}}
        <div class="order-info" style="padding: 0rem;">
            <div class="row row-cols-md-4">
                <div class="col-product col-product-sanpham">
                    <h4>Sản phẩm</h4>
                </div>
                <div class="col-product col-product-phanloai">
                    <h4>Phân loại</h4>
                </div>
                <div class="col-product col-product-dongia">
                    <h4>Đơn giá</h4>
                </div>
                <div class="col-product col-product-soluong">
                    <h4>Số lượng</h4>
                </div>
                <div class="col-product col-product-thanhtien">
                    <h4>Thành tiền</h4>
                </div>
            </div>
        </div>

        @foreach ($order->order_details as $detail)
            <div class="order_info_product row-product" style="padding: 0rem;">
                <div class="col-product col-product-sanpham" style="text-align: left">
                        <p class="" >{{Str::limit($detail->product->name, 30, '...') }} </p>
                        <p class="" >Size: {{ $detail->size }} </p>
                </div>
                <div class="col-product col-product-phanloai">
                    <p>{{ $detail->product->category->name }}</p>
                </div>
                <div class="col-product col-product-dongia">
                    <p>{{ number_format($detail->price, 0, ',', '.') }}</p>
                </div>
                <div class="col-product col-product-soluong">
                    <p>{{ $detail->quantity }}</p>
                </div>
                <div class="col-product col-product-thanhtien">
                    <p>{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</p>
                </div>
            </div>
        @endforeach

        <hr >

        {{-- {{ dd($order->discounts->isNotEmpty()) }} --}}
        {{-- Khuyến mãi --}}
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model2" style="padding: 0rem">
            <h4>Khuyến mãi</h4>
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

        <hr>

        {{-- {{dd($order->payment_method)}} --}}
        {{-- Phương thức thanh toán --}}
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model3" style="padding: 0rem">
            <h4>Phương thức thanh toán</h4>
            <div class="order__info__user">
                <p id="selected-paymenthod">{{ $order->payment_method['name'] }}</p>
            </div>
        </div>

        <hr>

        {{-- {{dd($order->getTotalDiscount())}}  --}}
        {{-- Tổng hóa đơn --}}
        <div class="order_info_sum row mb-2">
            <div class="" style="display: flex; justify-content-end">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="text-align: right; padding-right: 10px;">Tổng tiền sản phẩm:</td>
                            <td style="text-align: right;">{{ number_format($order->getTotalPrice(), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding-right: 10px;">Tổng phí vận chuyển:</td>
                            <td style="text-align: right;">{{ number_format($priceDelivery, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding-right: 10px;">Tổng giảm giá:</td>
                            <td style="text-align: right;">{{ number_format($order->getTotalDiscount(), 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td style="text-align: right; padding-right: 10px; font-weight: bold;">Tổng thanh toán:</td>
                            <td style="text-align: right; font-weight: bold;">{{ number_format($order['total_price'], 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <style>
       
    </style>
</body>
