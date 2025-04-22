@extends('admin.layouts.admin')

@section('title')
    <title>Duyệt đơn hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/order_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('css/config.css?ver=3') }}">
@endsection

@section('content')
    <div class="container">
        <h2 class="text-center fw-bolder text-">Duyệt đơn hàng</h2>
        <div class="row mb-4" style="margin: auto 5rem">
            <form action="{{ route('admin.order.handle', $order) }}" method="POST">
                @csrf
                @if ($errors->any())
                    <div class="alert alert-danger">
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
                        <div>
                            @foreach ($warehouses as $warehouse)
                                {{-- {{ dd($productId, $size, $warehouse) }} --}}
                                <div class="form-group mb-2 row d-flex align-items-center warehouse-row disabled">
                                    <div class="col-2">
                                        <span class="checkbox" style="opacity: 1">
                                            <input style="opacity: 1" type="checkbox"
                                                name="warehouseCheck[{{ $detail['product_id'] }}][{{ $detail['size'] }}][{{ $warehouse['id'] }}]"
                                                class="form-check-input warehouse-checkbox me-3 
                                                @error('quantity' . '.' . $detail['product_id'] . '.' . $detail['size'] . '.' . $warehouse['id']) is-invalid @enderror">
                                        </span>
                                        <label for="warehouse[{{ $warehouse['id'] }}]">Kho:
                                            <b>{{ $warehouse['address'] }}</b></label>
                                    </div>

                                    <div class="col-3">
                                        <input type="number" placeholder="Nhập vào số lượng"
                                            name="quantity[{{ $detail['product_id'] }}][{{ $detail['size'] }}][{{ $warehouse['id'] }}]"
                                            id="warehouse[{{ $warehouse['id'] }}]"
                                            class="form-control  quantity-input 
                                             @error('quantity' . '.' . $detail['product_id'] . '.' . $detail['size'] . '.' . $warehouse['id']) is-invalid @enderror">
                                        @error('quantity' . '.' . $detail['product_id'] . '.' . $detail['size'] . '.' .
                                            $warehouse['id'])
                                            <span class="invalid-feedback" style="display: block">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                        {{-- {{ dd($errors, 'quantity' . '.' . $detail['product_id'] . '.' . $detail['size'] . "." . 
                                            $warehouse['id']) }} --}}
                                    </div>
                                    <span class="col-6">Số lượng trong kho:
                                        {{ $warehouse->getProductActiveQuantity($detail['product_id'], $detail['size']) }}
                                        <em>(có
                                            {{ $warehouse->getProductDisableQuantity($detail['product_id'], $detail['size']) }}
                                            sản phẩm
                                            chưa kích hoạt )</span></em>

                                </div>
                            @endforeach

                        </div>
                    @endforeach
                </div>

                {{-- Lựa chọn --}}
                <div class="row">
                    <div class="col-8"></div>
                    <div class="col-4 d-flex">
                        <div class="order__info__option">
                            @if ($order['status'] == 'pending')
                                <button class="btn " type="button" style="font-weight:600;">
                                    <a href="{{ url()->previous() }}">Quay lại</a>
                                </button>
                                <button class="btn " type="submit" style="font-weight:600; "
                                    style="font-weight:600; color: var(--extra1-color)">
                                    Duyệt đơn
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>

    <style>
        .title {
            font-size: 1rem;
            font-weight: 700;
            margin-right: 1rem;
            display: flex;
            justify-content: start;
            align-items: center;
        }

        h5 {
            font-weight: 600
        }

        .warehouse-row.disabled {
            opacity: 0.5;
            /* Làm mờ dòng */
        }

        .warehouse-row.disabled .quantity-input {
            background-color: #eee;
            /* Màu nền xám nhạt cho input bị vô hiệu hóa */
            cursor: not-allowed;
            /* Thay đổi con trỏ chuột */
        }
    </style>
    <script>
        const warehouseRows = document.querySelectorAll('.warehouse-row');

        warehouseRows.forEach(row => {
            const checkbox = row.querySelector('.warehouse-checkbox');
            const quantityInput = row.querySelector('.quantity-input');

            if (checkbox.checked) {
                row.classList.remove('disabled');
                quantityInput.disabled = false;
            }

            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    row.classList.remove('disabled');
                    quantityInput.disabled = false;
                } else {
                    row.classList.add('disabled');
                    quantityInput.disabled = true;
                }
            });

            // Kiểm tra trạng thái ban đầu nếu có class 'disabled'
            if (row.classList.contains('disabled')) {
                quantityInput.disabled = true;
            } else if (checkbox.checked) {
                quantityInput.disabled = false;
            }
        });
    </script>
@endsection
