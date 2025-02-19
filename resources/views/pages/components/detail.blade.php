@extends('pages.layouts.layout')

@section('title')
    <title>Chi tiết sản phẩm</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/detail.css">
    <link rel="stylesheet" href="/css/home.css">
@endsection

@section('content')
    <main>
        <div class="daunao">
            <div class="boss">
                <div class="card-wrap">
                    <div class="d-flex row" style="width: 100%">
                        <div class="card col-6 p-0">
                            <!--head-card-->
                            <div id="demo" class="carousel slide" data-bs-ride="carousel">

                                <!-- Indicators/dots -->
                                <div class="carousel-indicators">
                                    <button type="button" data-bs-target="#demo" data-bs-slide-to="0"
                                        class="active"></button>
                                    <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                                    <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
                                    <button type="button" data-bs-target="#demo" data-bs-slide-to="3"></button>
                                </div>

                                <!-- The slideshow/carousel -->
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                            alt="" class="d-block">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                            alt="" class="d-block">
                                    </div>
                                    <div class="carousel-item">
                                        <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                            alt="" class="d-block">
                                    </div>
                                </div>

                                <!-- Left and right controls/icons -->
                                <button class="carousel-control-prev" type="button" data-bs-target="#demo"
                                    data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon"></span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#demo"
                                    data-bs-slide="next">
                                    <span class="carousel-control-next-icon"></span>
                                </button>
                            </div>
                        </div>
                        <div class="card__choice col-5">
                            <h3 class="product-title">
                                Giày PureBoost 23 – IF2367
                            </h3>
                            <div class="product-price">
                                <p>4 triệu 200 nghìn</p>
                            </div>
                            <p class="card__choice__detail">
                                Giày Nike SP dunk luôn là một trong những mẫu giày sneaker bán chạy nhất thị trường, vận
                                chuyển toàn quốc,
                                kiểm tra hàng trước khi nhận, phục vụ 24/24, các kênh thanh toán online thuận tiện
                            </p>
                            <div class="card__choice__detail__option">
                                <label class="d-block" for="size-select">
                                    <b>Size</b>
                                </label>
                                <div class="order__info__product__size">
                                    <select class="form-select" id="size-select" name="size[]">
                                        <option>40</option>
                                        <option>41</option>
                                        <option>42</option>
                                        <option>43</option>
                                    </select>
                                </div>
                            </div>

                            <div class="card__choice__detail__option">
                                <label class="d-block card__choice__quantity" for="quantity-select">
                                    <b>Số lượng</b>
                                </label>
                                <div class="d-flex justify-content-start">
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
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="card__choice__submit">
                                    <button type="submit" class="btn">
                                        Thêm vào giỏ
                                    </button>
                                </div>

                                <div class="card__choice__submit">
                                    <button type="submit" class="btn">
                                        Mua ngay
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-items mt-5">
                        <!--card-bottom-->
                        <div class="d-flex">
                            <div class="card__choice product-content">

                                {{-- Thông tin sản phẩm --}}
                                <h3 class="product-title">Thông Tin Sản Phẩm</h3>
                                <div class="product-content__info p-3">
                                    <p style="font-size: 1.6rem;color: black;"><b>Tên sản phẩm </b></p>
                                    <p class="card__choice__detail">Giày PureBoost 23 – IF2367</p>
                                    <p style="font-size: 1.6rem;color: black;"><b>Danh mục </b></p>
                                    <p class="card__choice__detail">Giày Nike</p>
                                    <p style="font-size: 1.6rem;color: black;"><b>Mô tả </b></p>
                                    <p class="card__choice__detail">
                                        Giày Nike SP dunk luôn là một trong những mẫu giày sneaker bán chạy nhất thị trường,
                                        vận
                                        chuyển toàn quốc,
                                        kiểm tra hàng trước khi nhận, phục vụ 24/24, các kênh thanh toán online thuận tiện
                                    </p>
                                </div>

                                {{-- Thông tin cửa hàng --}}
                                <h3 class="product-title">VibeZ</h3>
                                <div class="product-content__info p-3">
                                    <p class="card__choice__detail">
                                        Shop bán giày giá rẻ tại Việt Nam
                                        <br>
                                        • Real bao check, check fake thì trả hàng thẳng luôn nha
                                        <br>
                                        • Ship COD kiểm tra hàng toàn quốc luôn nha mọi người ơi !!
                                        <br>
                                        - - - CAM KẾT HÌNH THẬT - GIÁ THẬT - - - <br>
                                        <br>
                                        Liên hệ ngay cho mình ( Zalo ) Trần Phúc theo số điện thoại
                                        0918242085 hoặc nhắn tin trực tiếp<br>
                                        <br>
                                        #shopgiaygiare #shopgiayhaugiang #sneakergiare
                                    </p>
                                </div>


                                {{-- Đánh giá --}}
                                <h3 class="product-title">Đánh giá</h3>
                                <div class="product-content__info p-3">
                                    <p class="card__choice__detail">
                                        Đánh giá
                                    </p>
                                </div>

                                {{-- Gọi ý sản phẩm --}}
                                <div class="DangBan">
                                    <h3 class="product-title">Sản Phẩm Khác</h3>
                                    <div class="XemTruoc d-flex" style="width:95%">
                                        <a href="/_sp/sp2_1.html">
                                            <div class="sanpham">
                                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                                    alt="">
                                                <p class="mota">Giày PureBoost 23 – IF2367</p>
                                                <p class="size">Size: 40 - 42</p>
                                                <p class="giatien">4 triệu 200 nghìn</p>
                                            </div>
                                        </a>

                                        <a href="/_sp/sp2_2.html">
                                            <div class="sanpham">
                                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                                    alt="">
                                                <p class="mota">Giày PureBoost 23 – IF2367</p>
                                                <p class="size">Size: 40 - 42</p>
                                                <p class="giatien">4 triệu 200 nghìn</p>
                                            </div>
                                        </a>

                                        <a href="/_sp/sp2_3.html">
                                            <div class="sanpham">
                                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                                    alt="">
                                                <p class="mota">Giày PureBoost 23 – IF2367</p>
                                                <p class="size">Size: 40 - 42</p>
                                                <p class="giatien">4 triệu 200 nghìn</p>
                                            </div>
                                        </a>

                                        <a href="/_sp/sp2_7.html">
                                            <div class="sanpham">
                                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                                    alt="">
                                                <p class="mota">Giày PureBoost 23 – IF2367</p>
                                                <p class="size">Size: 40 - 42</p>
                                                <p class="giatien">4 triệu 200 nghìn</p>
                                            </div>
                                        </a>
                                        <a href="/_sp/sp2_10.html">
                                            <div class="sanpham">
                                                <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                                    alt="">
                                                <p class="mota">Giày Adidas PureBoost 23 – IF2367</p>
                                                <p class="size">Size: 40 - 42</p>
                                                <p class="giatien">4 triệu 200 nghìn</p>
                                            </div>
                                        </a>
                                    </div>
                                    <a href="" class="LienKet" style=" ">
                                        <p style="width:fit-content; margin:auto;">Xem Thêm</p>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('js')
    <script src="/js/product.js"></script>
@endsection
