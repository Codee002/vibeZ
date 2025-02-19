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
        {{-- Danh mục --}}
        <div class="order__info">
            <div class="row mb-4">
                <div class="col-3">
                    <h3>Sản phẩm</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Phân loại</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Kích thước</h3>
                </div>
                <div class="col-2  d-flex justify-content-center">
                    <h3>Số lượng</h3>
                </div>
                <div class="col-2 d-flex justify-content-center">
                    <h3>Đơn giá</h3>
                </div>
                <div class="col-1">
                </div>
            </div>


            {{-- Thoong tin sản phẩm --}}
            <form action="">
                <div class="order__info__product d-flex row">
                    <div class="col-3 d-flex">
                        <div class="col-4">
                            <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                class="" alt="">
                        </div>
                        <p class="col-8 d-flex justify-content-center">Giày PureBoost 23</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <p>Giày Nike</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center order__info__product__size">
                        <select class="form-select" id="size-select" name="size[]">
                            <option>40</option>
                            <option>41</option>
                            <option>42</option>
                            <option>43</option>
                        </select>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <div class="order__info__product__quantity">
                            <div class="order__info__product__quantity__prepend">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                            </div>
                            <input type="text" class="form-control" value="1" min="1">
                            <div class="order__info__product__quantity__apend">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <p>4.200.000</p>
                    </div>
                    <div class="col-1 d-flex">
                        {{-- Radiao --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check1" name="option1" value="something">
                        </div>

                        {{-- Tùy chọn --}}
                        <i class="fa-solid fa-caret-down friendList__main__info__menu__activeMenu"
                            data-bs-toggle="dropdown"></i>
                        <ul class="dropdown-menu friendList__main__info__dropdownMenu">
                            <li><a class="dropdown-item" href="" style="color: var(--font-color)">Xem sản phẩm</a>
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
                                    <h4 class="modal-title">Xóa sản phẩm</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Bạn có chắc chắn xóa sản phẩm .... ?
                                </div>

                                <!-- Modal footer -->
                                <form action="/friend/removeFriend" method="POST">
                                    <!-- Fix CSRF -->
                                    @CSRF
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Xóa</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="order__info__product d-flex row">
                    <div class="col-3 d-flex">
                        <div class="col-4">
                            <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                class="" alt="">
                        </div>
                        <p class="col-8 d-flex justify-content-center">Giày PureBoost 23</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <p>Giày Nike</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center order__info__product__size">
                        <select class="form-select" id="size-select" name="size[]">
                            <option>40</option>
                            <option>41</option>
                            <option>42</option>
                            <option>43</option>
                        </select>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <div class="order__info__product__quantity">
                            <div class="order__info__product__quantity__prepend">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                            </div>
                            <input type="text" class="form-control" value="1" min="1">
                            <div class="order__info__product__quantity__apend">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <p>4.200.000</p>
                    </div>
                    <div class="col-1 d-flex">
                        {{-- Radiao --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check1" name="option1"
                                value="something">
                        </div>

                        {{-- Tùy chọn --}}
                        <i class="fa-solid fa-caret-down friendList__main__info__menu__activeMenu"
                            data-bs-toggle="dropdown"></i>
                        <ul class="dropdown-menu friendList__main__info__dropdownMenu">
                            <li><a class="dropdown-item" href="" style="color: var(--font-color)">Xem sản phẩm</a>
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
                                    <h4 class="modal-title">Xóa sản phẩm</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Bạn có chắc chắn xóa sản phẩm .... ?
                                </div>

                                <!-- Modal footer -->
                                <form action="/friend/removeFriend" method="POST">
                                    <!-- Fix CSRF -->
                                    @CSRF
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-danger"
                                            data-bs-dismiss="modal">Xóa</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="order__info__product d-flex row">
                    <div class="col-3 d-flex">
                        <div class="col-4">
                            <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                class="" alt="">
                        </div>
                        <p class="col-8 d-flex justify-content-center">Giày PureBoost 23</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <p>Giày Nike</p>
                    </div>
                    <div class="col-2 d-flex justify-content-center order__info__product__size">
                        <select class="form-select" id="size-select" name="size[]">
                            <option>40</option>
                            <option>41</option>
                            <option>42</option>
                            <option>43</option>
                        </select>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <div class="order__info__product__quantity">
                            <div class="order__info__product__quantity__prepend">
                                <button class="btn btn-outline-secondary" type="button">-</button>
                            </div>
                            <input type="text" class="form-control" value="1" min="1">
                            <div class="order__info__product__quantity__apend">
                                <button class="btn btn-outline-secondary" type="button">+</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-2 d-flex justify-content-center">
                        <p>4.200.000</p>
                    </div>
                    <div class="col-1 d-flex">
                        {{-- Radiao --}}
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="check1" name="option1"
                                value="something">
                        </div>

                        {{-- Tùy chọn --}}
                        <i class="fa-solid fa-caret-down friendList__main__info__menu__activeMenu"
                            data-bs-toggle="dropdown"></i>
                        <ul class="dropdown-menu friendList__main__info__dropdownMenu">
                            <li><a class="dropdown-item" href="" style="color: var(--font-color)">Xem sản phẩm</a>
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
                                    <h4 class="modal-title">Xóa sản phẩm</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <!-- Modal body -->
                                <div class="modal-body">
                                    Bạn có chắc chắn xóa sản phẩm .... ?
                                </div>

                                <!-- Modal footer -->
                                <form action="/friend/removeFriend" method="POST">
                                    <!-- Fix CSRF -->
                                    @CSRF
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-danger"
                                            data-bs-dismiss="modal">Xóa</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- Lựa chọn --}}
                <div class="row mt-5">
                    <div class="col-8"></div>
                    <div class="col-4 d-flex">
                        <div class="order__info__option d-flex justify-content-end">
                            <button class="btn" type="submit"
                                style="font-size: 2rem; font-weight:600; color: var(--extra1-color)">Đặt hàng</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </main>
@endsection

@section('js')
    <script src="/js/product.js"></script>
@endsection
