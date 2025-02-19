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
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model1">
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

        <!-- Modal -->
        <div class="modal fade" id="Model1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog ">
                <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                    <div class="modal-header">
                        <strong>
                            <h1 class="modal-title text-center ms-auto">
                                Nhập thông tin giao hàng</h1>
                        </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="getPassword" method="POST" action="/setting/changePassword" action="/setting/changePassword"
                        onsubmit="return formConfirm(['oldpass', 'password', 'password_confirm'])">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Fix CSRF -->
                                @csrf

                                <label for="oldpass" class="form-label ">
                                    Họ tên:</label>
                                <div class="form-group">
                                    <input type="password" name="oldpass" id="oldpass" placeholder="Nhập họ tên"
                                        class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground 
                                                ">
                                    <span class="mb-3 invalid-feedback" style="display: block"></span>

                                </div>


                                <label for="password" class="form-label"> Số điện thoại:</label>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" placeholder="Nhập số điện thoại"
                                        class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground 
                                               ">
                                    <span class="mb-3 invalid-feedback" style="display: block"></span>
                                </div>

                                <label for="password_confirm" class="form-label"> Địa chỉ:</label>
                                <div class="form-group">
                                    <input type="password" name="password_confirm" id="password_confirm"
                                        placeholder="Nhập địa chỉ"
                                        class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground 
                                               ">
                                    <span class="mb-3 invalid-feedback" style="display: block"></span>

                                </div>

                            </div>
                        </div>
                        <div
                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                bỏ</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
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
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model2">
            <h3>Khuyến mãi</h3>
            <div class="order__info__user">
                <p>Chưa áp dụng mã khuyến mãi nào</p>
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
                    <form id="getPassword" method="POST" action="/setting/changePassword"
                        action="/setting/changePassword"
                        onsubmit="return formConfirm(['oldpass', 'password', 'password_confirm'])">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Fix CSRF -->
                                @csrf
                                <label for="oldpass" class="form-label ">
                                    Khuyến mãi:</label>
                                <div class="form-group">
                                    <select class="form-select">
                                        <option>Khuyến mãi 1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                    <span class="mb-3 invalid-feedback" style="display: block"></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                bỏ</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Phương thức thanh toán --}}
        <div class="order__info" data-bs-toggle="modal" data-bs-target="#Model3">
            <h3>Phương thức thanh toán</h3>
            <div class="order__info__user">
                <p>Thanh toán khi nhận hàng</p>
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
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="getPassword" method="POST" action="/setting/changePassword"
                        action="/setting/changePassword"
                        onsubmit="return formConfirm(['oldpass', 'password', 'password_confirm'])">
                        <div class="modal-body">
                            <div class="row">
                                <!-- Fix CSRF -->
                                @csrf
                                <label for="oldpass" class="form-label ">
                                    Phương thức thanh toán</label>
                                <div class="form-group">
                                    <select class="form-select">
                                        <option>Phương thức 1</option>
                                        <option>2</option>
                                        <option>3</option>
                                        <option>4</option>
                                    </select>
                                    <span class="mb-3 invalid-feedback" style="display: block"></span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                bỏ</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
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
