@extends('pages.layouts.layout')

@section('title')
    <title>Lịch sử đặt hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/cart.css">
@endsection

@section('content')
    <main>
        <p class="title">Các đơn hàng đã đặt</p>

        {{-- Danh mục --}}
        <div class="order__info">
            <div class="row mb-4 p-4">
                <div class="col-4">
                    <h3>Sản phẩm</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Phân loại</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Số lượng</h3>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <h3>Size</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Thành tiền</h3>
                </div>
            </div>

            <a href="{{route("order_detail")}}">
                {{-- Thoong tin sản phẩm --}}
                <div class="order__info__product p-4 mb-5">
                    <div class=" d-flex row mb-4">
                        <div class="col-4 d-flex">
                            <div class="col-4">
                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                    class="" alt="">
                            </div>
                            <div class="col-8 d-flex flex-column align-items-center">
                                <div>
                                    <p>Giày PureBoost 23</p>
                                    <p>Size: 42</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>Giày Nike</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>1</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>42</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>4.200.000</p>
                        </div>
                    </div>

                    <div class=" d-flex row mb-4">
                        <div class="col-4 d-flex">
                            <div class="col-4">
                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                    class="" alt="">
                            </div>
                            <div class="col-8 d-flex flex-column align-items-center">
                                <div>
                                    <p>Giày PureBoost 23</p>
                                    <p>Size: 42</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>Giày Nike</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>1</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>42</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>4.200.000</p>
                        </div>
                    </div>

                    <div class="d-flex order__info__sum row">
                        <div class="col-7"></div>
                        <div class="col-5 d-flex">
                            <div class="col-6 order__info__sum__type">
                                <p>Tổng sản phẩm: </p>
                                <p>Tổng tiền: </p>
                                <p>Thời gian mua hàng: </p>
                                <p>Thời gian giao hàng: </p>
                                <p>Trạng thái: </p>
                            </div>
                            <div class="col-6 text-end col-4 order__info__sum__price">
                                <p>2</p>
                                <p>8.400.000</p>
                                <p>10-10-2004</p>
                                <p>16-10-2004</p>
                                <p>Giao hàng thành công</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
            <a href="{{route("order_detail")}}">
                {{-- Thoong tin sản phẩm --}}
                <div class="order__info__product p-4 mb-5">
                    <div class=" d-flex row mb-4">
                        <div class="col-4 d-flex">
                            <div class="col-4">
                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                    class="" alt="">
                            </div>
                            <div class="col-8 d-flex flex-column align-items-center">
                                <div>
                                    <p>Giày PureBoost 23</p>
                                    <p>Size: 42</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>Giày Nike</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>1</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>42</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>4.200.000</p>
                        </div>
                    </div>

                    <div class=" d-flex row mb-4">
                        <div class="col-4 d-flex">
                            <div class="col-4">
                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                    class="" alt="">
                            </div>
                            <div class="col-8 d-flex flex-column align-items-center">
                                <div>
                                    <p>Giày PureBoost 23</p>
                                    <p>Size: 42</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>Giày Nike</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>1</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>42</p>
                        </div>
                        <div class="col-2 d-flex justify-content-center">
                            <p>4.200.000</p>
                        </div>
                    </div>

                    <div class="d-flex order__info__sum row">
                        <div class="col-7"></div>
                        <div class="col-5 d-flex">
                            <div class="col-6 order__info__sum__type">
                                <p>Tổng sản phẩm: </p>
                                <p>Tổng tiền: </p>
                                <p>Thời gian mua hàng: </p>
                                <p>Thời gian giao hàng: </p>
                                <p>Trạng thái: </p>
                            </div>
                            <div class="col-6 text-end col-4 order__info__sum__price">
                                <p>2</p>
                                <p>8.400.000</p>
                                <p>10-10-2004</p>
                                <p>16-10-2004</p>
                                <p>Giao hàng thành công</p>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </main>
@endsection
