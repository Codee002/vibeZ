@extends('pages.layouts.layout')

@section('title')
    <title>Xác nhận đơn hàng</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/order_detail.css">
@endsection

@section('content')
    <main>
        {{-- Thông tin khách hàng --}}
        <div class="order__info">
            <h3>Địa chỉ đặt hàng</h3>
            <div class="order__info__user">
                <p>Trần Phúc</p>
                <p>0918242085</p>
                <p>
                    Nhà trọ Hoàng Thy, Ấp Hòa Đức, Xã Hòa An, Huyện Phụng Hiệp, tỉnh Hậu Giang
                </p>
            </div>
            <i class='bx bx-right-arrow-alt'></i>
        </div>


        {{-- Danh mục --}}
        <div class="order__info">
            <div class="row mb-4">
                <div class="col-4">
                    <h3>Sản phẩm</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Phân loại</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Đơn giá</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Số lượng</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Thành tiền</h3>
                </div>
            </div>


            {{-- Thoong tin sản phẩm --}}
            <div class="order__info__product d-flex row">
                <div class="col-4 d-flex">
                    <div class="col-4">
                        <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                            class="" alt="">
                    </div>
                    <p class="col-8 d-flex justify-content-center">Giày PureBoost 23</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>Giày Nike</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>4.200.000</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>1</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>4.200.000</p>
                </div>
            </div>
            <div class="order__info__product d-flex row">
                <div class="col-4 d-flex">
                    <div class="col-4">
                        <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                            class="" alt="">
                    </div>
                    <p class="col-8 d-flex justify-content-center">Giày PureBoost 23</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>Giày Nike</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>4.200.000</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>1</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>4.200.000</p>
                </div>
            </div>
            <div class="order__info__product d-flex row">
                <div class="col-4 d-flex">
                    <div class="col-4">
                        <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                            class="" alt="">
                    </div>
                    <p class="col-8 d-flex justify-content-center">Giày PureBoost 23</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>Giày Nike</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>4.200.000</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>1</p>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <p>4.200.000</p>
                </div>
            </div>
        </div>


        {{-- Khuyến mãi --}}
        <div class="order__info">
            <h3>Khuyến mãi</h3>
            <div class="order__info__user">
                <p>Chưa áp dụng mã khuyến mãi nào</p>
            </div>
            <i class='bx bx-right-arrow-alt'></i>
        </div>

        {{-- Phương thức thanh toán --}}
        <div class="order__info">
            <h3>Phương thức thanh toán</h3>
            <div class="order__info__user">
                <p>Thanh toán khi nhận hàng</p>
            </div>
            <i class='bx bx-right-arrow-alt'></i>
        </div>


        {{-- Tổng hóa đơn --}}
        <div class="order__info__sum row mb-5">
            <div class="col-8"></div>
            <div class="col-4 d-flex">
                <div class="col-8 order__info__sum__type">
                    <p>Tổng tiền sản phẩm</p>
                    <p>Tổng phí vận chuyển</p>
                    <p>Tổng giảm giá</p>
                    <hr>
                    <p style="font-size: 2.4rem; font-weight:600; color: var(--extra1-color)">Tổng thanh toán</p>
                </div>
                <div class="col-4 order__info__sum__price" style="text-align:end;">
                    <p>4200</p>
                    <p>30</p>
                    <p>50</p>
                    <hr>
                    <p style="font-size: 2.4rem;">4180</p>
                </div>
            </div>
        </div>

        {{-- Lựa chọn --}}
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 d-flex">
                <form action="" style="width:100%">
                    <div class="order__info__option">
                        <button class="btn" style="font-size: 2rem; font-weight:600; ">Hủy</button>
                        <button class="btn" type="submit"
                            style="font-size: 2rem; font-weight:600; color: var(--extra1-color)">Đặt hàng</button>
                    </div>
                </form>
            </div>
        </div>

    </main>
@endsection
