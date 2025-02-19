@extends('pages.layouts.layout')

@section('title')
    <title>Liên hệ</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/contact.css">
@endsection

@section('content')
    <main>
        <hr>
        <h1 style="margin-bottom: 2rem; margin-top: 3rem;">Liên hệ</h1>
        <form action="/_trangchu/trangchu.html" onsubmit="return frmConfirm() ">
            <div class="gopy">
                <label for="gopy">Chọn nội dung</label>
                <select name="gopy" class="form-select" id="gopy" size="1">
                    <option value="0">------------  Chọn nội dung  ------------</option>
                    <option value="1">Dịch Vụ</option>
                    <option value="1">Trang chủ</option>
                    <option value="1">Tin tức</option>
                    <option value="1">Yêu thích</option>
                    <option value="1">Đăng xuất/Đăng nhập</option>
                    <option value="1">Bảo mật tài khoản</option>
                    <option value="1">Tính năng mới</option>
                    <option value="1">Lỗi hệ thống</option>
                    <option value="1">Vấn đề khác</option>
                </select> 

                <div class="form-group ">
                    <label for="noidung">Nội dung</label>
                    <div class="input-icon">
                        <textarea class="form-control" id="noidung" cols="50" rows="4" placeholder="Không quá 200 ký tự !"></textarea>
                    </div>
                    <span class="error-message"></span>
                </div>

                <button class="form-gui" type="submit">Gửi</button>
            </div>
        </form>
        <hr>
        <div class="supports">
            <img src="header_img/support.jpg" alt="">
            <p> Nếu bạn cần hỗ trợ, góp ý, vui lòng
                liên hệ hoặc sử dụng biểu mẫu này. Xin cám ơn.<br>
                <b>Địa chỉ: </b> <a href="#map"><i class="address">Ấp Hòa Đức, xã
                        Hòa An, huyện Phụng Hiệp,
                        tình Hậu Giang.</i></a> <br>
               <b>Hotline: </b> <a href="#map"><i class="address">0918242085.</i></a> <br>
               <b>Email: </b> <a href="#map"> <i class="address">phucb2205955@student.ctu.edu.vn.</i></a>

            </p>

        </div>
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62910.84805023856!2d105.59758057597041!3d9.772159660356817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0f1a704ed5033%3A0x2653701cfe37b05e!2zSMOyYSBBbiwgUGjhu6VuZyBIaeG7h3AsIEjhuq11IEdpYW5nLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1701607511423!5m2!1svi!2s"
            width="100%" height="450" style="border:1px;" allowfullscreen="" loading="lazy"
            referrerpolicy="no-referrer-when-downgrade" id="map"></iframe>

    </main>
@endsection
