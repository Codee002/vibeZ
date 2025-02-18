@extends('pages.layouts.layout')

@section('title')
    <title>Trang chủ</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/home.css">
@endsection

@section('content')
    <main>
        <img class="banner" src="/assets/images/banner/main_banner.jpg">
        </img>
        <div class="Content-container">
            <div class="KhamPha-container">
                <p class="KhamPha_title">Khám Phá VibeZ</p>
                <div class="KhamPha">
                    <a href="">
                        <div class="DieuHuong">
                            <div class="content">
                                <i class='bx bxs-food-menu'></i>
                                <a href="{{ route("product") }}">
                                    <p>Sản phẩm</p>
                                </a>
                            </div>
                        </div>
                    </a>

                    <a href="">

                    </a>

                    <a href="{{route("cart")}}">
                        <div class="DieuHuong">
                            <div class="content">
                                <i class='bx bxs-cart-alt'></i>
                                <a href="{{route("cart")}}">
                                    <p>Giỏ hàng</p>
                                </a>
                            </div>
                        </div>
                    </a>

                    <a href="/_yeuthich/yeuthich.html">
                        <div class="DieuHuong">
                            <div class="content">
                                <i class='bx bxs-shopping-bag-alt'></i>
                                <a href="">
                                    <p>Đơn hàng</p>
                                </a>
                            </div>
                        </div>
                    </a>
                    <a href="/_lienhe/lienhe.html">
                        <div class="DieuHuong">
                            <div class="content">
                                <i class='bx bx-support'></i>
                                <a href="">
                                    <p>Hỗ Trợ</p>
                                </a>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

            <div>
                <div class="DangBan">
                    <p class="XemTruoc_title">Converse</p>
                    <div class="XemTruoc">
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
                    <a href="" class="LienKet">
                        <p>Xem Thêm</p>
                    </a>
                </div>

                <div class="DangBan">
                    <p class="XemTruoc_title">Adidas</p>
                    <div class="XemTruoc">
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
                    <a href="" class="LienKet">
                        <p>Xem Thêm</p>
                    </a>
                </div>

                <div class="DangBan">
                    <p class="XemTruoc_title">Nike</p>
                    <div class="XemTruoc">
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
                    <a href="" class="LienKet">
                        <p>Xem Thêm</p>
                    </a>
                </div>
            </div>

            <div class="DangBan">
                <p class="XemTruoc_title">Đánh giá</p>
                <div class="XemTruoc">
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
            </div>
            {{-- <div>
                <div class="DangBan tienich-container">
                    <p class="XemTruoc_title">Tiện ích</p>
                    <div class="XemTruoc">
                        <div class="sanpham tienich">
                            <p class="mota"><i class='bx bxs-hard-hat'></i></p>
                            <p class="size">Nhà trọ gần trường</p>
                        </div>
                        <div class="sanpham tienich">
                            <p class="mota"><i class='bx bxs-graduation'></i></p>
                            <p class="size">Nhà trọ công nhân</p>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </main>
@endsection
