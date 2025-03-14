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

                @foreach ($cartDetails as $detail)
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
                            <p class="col-8 d-flex align-items-center order__info__product_name">
                                {{ $detail->product->name }}</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>{{ $detail->product->category->name }}</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center order__info__product__size">
                            {{-- <select class="form-select" id="size-select" name="size">
                                    <option>{{ $detail['size'] }}</option>
                                </select> --}}
                            <p>{{ $detail['size'] }}</p>
                            {{-- <input type="hidden" value="{{ $detail['size'] }}" name="size"> --}}
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <div class="order__info__product__quantity">
                                {{-- <div class="order__info__product__quantity__prepend">
                                    <a href="{{route("updateQuantity", $detail['quantity'] - 1)}}" class="btn btn-outline-secondary minusQuantity" type="button">-</a>
                                </div> --}}
                                <input type="text" class="form-control" min="1" value="{{ $detail['quantity'] }}"
                                    disabled>
                                {{-- <div class="order__info__product__quantity__apend">
                                    <a href="{{route("updateQuantity", $detail['quantity'] + 1)}}" class="btn btn-outline-secondary" type="button">+</a>
                                </div> --}}
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            @foreach ($detail->product->sale_prices as $sale_price)
                                @if ($sale_price['size'] == $detail['size'])
                                    <p>{{ $sale_price['price'] }}</p>
                                @endif
                            @endforeach

                        </div>
                        <div class="col-1 d-flex" style="position: relative">
                            {{-- Radio --}}
                            <div class="form-check">
                                <input class="form-check-input cartCheckBox" type="checkbox" name="cartDetailId[]"
                                    value="{{$detail['id']}}">
                            </div>

                            {{-- Tùy chọn --}}
                            <i class="fa-solid fa-caret-down friendList__main__info__menu__activeMenu"
                                data-bs-toggle="dropdown"></i>
                            <ul class="dropdown-menu friendList__main__info__dropdownMenu">
                                <li><a class="dropdown-item" href="" style="color: var(--font-color)">Xem sản
                                        phẩm</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                    </hr>
                                </li>
                                <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                        data-bs-target="#modal1"><strong>Xóa sản phẩm</strong></a></li>
                            </ul>
                        </div>

                        <!-- Modal -->
                        <div class="modal" id="modal1">
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
                                        Size <b>{{$detail['size']}}</b>?
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
        @endif
    </main>
@endsection

@section('js')
    <script src="/js/product.js"></script>
    <script src="/js/cart.js"></script>
@endsection
