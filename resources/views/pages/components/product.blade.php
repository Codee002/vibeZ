@extends('pages.layouts.layout')

@section('title')
    <title>Danh sách sản phẩm</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/product.css">
@endsection

@section('content')
    <main>
        <p class="title">Sản Phẩm Cập Nhật Mới Nhất T2/2025</p>

        <div class="tonhat tay">
            <div class="row">
                <div class="col-6">
                    <div class="contentContainer ">
                        <div class="flex">
                            <img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp">
                        </div>
                        <div class="flex">
                            <p class="tieude" onclick="getLink('/_sp/sp3_1.html')">Giày PureBoost 23
                            </p>
                            <p class="an" onclick="getLink('/_sp/sp3_1.html')">Đường M1, Phường Bình Hưng Hòa, Quận
                                Bình
                                Tân, TPHCM
                            </p>
                            <p class="cword">3 triệu <i class="bx bxs-cart-add" id="sp5_1"
                                    onclick="save('sp5_1')"></i></p>
                        </div>
                        <div class="tim"></div>
                    </div>
                    <div class="contentContainer ">
                        <div class="flex"><img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                onclick="getLink('/_sp/sp3_2.html')">

                        </div>
                        <div class="flex">
                            <p class="tieude" onclick="getLink('/_sp/sp3_2.html')">Giày PureBoost 23
                            </p>
                            <p class="an" onclick="getLink('/_sp/sp3_2.html')">Đường M1, Phường Bình Hưng Hòa, Quận
                                Bình
                                Tân, TPHCM

                            </p>
                            <p class="cword">2 triệu 800 nghìn
                                <i class="bx bxs-cart-add" id="sp5_2" onclick="save('sp5_2')"></i>
                            </p>
                        </div>
                        <div class="tim"></div>
                    </div>


                    <div class="contentContainer ">
                        <div class="flex"><img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                onclick="getLink('/_sp/sp3_3.html')">
                        </div>
                        <div class="flex">
                            <p class="tieude" onclick="getLink('/_sp/sp3_3.html')">Giày PureBoost 23
                            </p>
                            <p class="an" onclick="getLink('/_sp/sp3_3.html')">Lê Trọng Tấn, Phường Bình Hưng Hòa,
                                Quận
                                Bình Tân, TPHCM

                            </p>
                            <p class="cword">2 triệu 800 nghìn
                                <i class="bx bxs-cart-add" id="sp5_3" onclick="save('sp5_3')"></i>
                            </p>
                        </div>
                        <div class="tim"></div>
                    </div></a>
                </div>

                <div class="col-6">

                    <div class="contentContainer ">
                        <div class="flex"><img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                onclick="getLink('/_sp/sp3_6.html')">

                        </div>
                        <div class="flex">
                            <p class="tieude" onclick="getLink('/_sp/sp3_6.html')">Giày PureBoost 23
                            </p>
                            <p class="an" onclick="getLink('/_sp/sp3_6.html')">Đường M1, Phường Bình Hưng Hòa,
                                Quận
                                Bình Tân, TPHCM
                            </p>
                            <p class="cword">2 triệu 800 nghìn
                                <i class="bx bxs-cart-add" id="sp5_6" onclick="save('sp5_6')"></i>

                            </p>
                        </div>
                        <div class="tim"></div>
                    </div>


                    <div class="contentContainer ">
                        <div class="flex"><img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                onclick="getLink('/_sp/sp3_7.html')">
                        </div>
                        <div class="flex">
                            <p class="tieude" onclick="getLink('/_sp/sp3_7.html')">Giày PureBoost 23
                            <p class="an" onclick="getLink('/_sp/sp3_7.html')">Phạm Đăng Giảng, Phường Bình Hưng
                                Hòa,
                                Quận Bình Tân, TPHCM
                            </p>
                            <p class="cword">3 triệu
                                <i class="bx bxs-cart-add" id="sp5_7" onclick="save('sp5_7')"></i>

                            </p>
                        </div>
                        <div class="tim"></div>
                    </div>

                    <div class="contentContainer ">
                        <div class="flex"><img src="https://trivela.vn/wp-content/uploads/2023/10/GIAY-PUREBOOST-23-IF2367.jpg.webp"
                                onclick="getLink('/_sp/sp3_8.html')">

                        </div>
                        <div class="flex">
                            <p class="tieude" onclick="getLink('/_sp/sp3_8.html')">Giày PureBoost 23
                            </p>
                            <p class="an" onclick="getLink('/_sp/sp3_8.html')">Nguyễn Thị Tú, Phường Bình Hưng Hòa
                                B,
                                Quận Bình Tân, TPHCM
                            </p>
                            <p class="cword">2 triệu 700 nghìn
                                <i class="bx bxs-cart-add" id="sp5_8" onclick="save('sp5_8')"></i>

                            </p>
                        </div>
                        <div class="tim"></div>
                    </div>



                </div>

                <div class="DieuHuong">
                    <ul class="pagination">
                        <!-- <li class="page-item"><a class="page-link" href="#">Previous</a></li> -->
                        <li class="page-item active"><a class="page-link" href="muaban1.html">1</a></li>
                        <li class="page-item"><a class="page-link" href="muaban2.html">2</a></li>
                        <li class="page-item"><a class="page-link" href="muaban3.html">3</a></li>
                        <li class="page-item"><a class="page-link" href="muaban4.html">4</a></li>
                        <li class="page-item"><a class="page-link" href="muaban5.html">5</a></li>
                        <li class="page-item"><a class="page-link" href="muaban6.html">6</a></li>
                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                        <li class="page-item"><a class="page-link" href="muaban100.html">100</a></li>
                        <!-- <li class="page-item"><a class="page-link" href="#">Next</a></li> -->
                    </ul>
                </div>
            </div>

        </div>
    </main>
@endsection
