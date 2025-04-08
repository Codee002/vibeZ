@extends('pages.layouts.layout')

@section('title')
    <title>Liên hệ</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endsection

@section('content')
    <main>
        <div class="">
            <h1 style="margin-bottom: 2rem; margin-top: 3rem;">Liên hệ</h1>
            <form action="{{ route('handleContact') }}" method="POST">
                @csrf

                <div class="contactContent">

                    {{-- FLASH MESSAGES --}}
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

                    <label for="type">Chọn nội dung</label>
                    <select name="type" class="form-select" id="type" size="1">
                        <option>------------ Chọn nội dung ------------</option>
                        <option value="1">Chính sách mua hàng</option>
                        <option value="2">Bảo mật tài khoản</option>
                        <option value="3">Lỗi hệ thống</option>
                        <option value="4">Liên hệ hợp tác</option>
                        <option value="5">Vấn đề khác</option>
                    </select>

                    <div class="form-group ">
                        <label for="content">Nội dung</label>
                        <div class="input-icon">
                            <textarea class="form-control" id="content"
                            name="content" cols="50" rows="4" placeholder="Không quá 200 ký tự !"></textarea>
                        </div>
                        <span class="error-message"></span>
                    </div>

                    <div class="d-flex justify-content-center">
                        <button class="myBtn" type="submit">Gửi</button>
                    </div>
                </div>
            </form>
            <hr>
            <div class="supportContact">
                <img src="header_img/support.jpg" alt="">
                <p> Nếu bạn cần hỗ trợ, góp ý, vui lòng
                    liên hệ hoặc sử dụng biểu mẫu này. Xin cám ơn.</p>
                <p>
                    <b>Địa chỉ: </b> <a href="#map"><i>Ấp Hòa Đức, xã
                            Hòa An, huyện Phụng Hiệp,
                            tình Hậu Giang.</i></a>
                </p>
                <p>
                    <b>Hotline: </b> <a href="#map"><i>0918242085.</i></a> <br>
                </p>
                <p>
                    <b>Email: </b> <a href="#map"> <i>phucb2205955@student.ctu.edu.vn.</i></a>
                </p>

                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d62910.84805023856!2d105.59758057597041!3d9.772159660356817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31a0f1a704ed5033%3A0x2653701cfe37b05e!2zSMOyYSBBbiwgUGjhu6VuZyBIaeG7h3AsIEjhuq11IEdpYW5nLCBWaeG7h3QgTmFt!5e0!3m2!1svi!2s!4v1701607511423!5m2!1svi!2s"
                    width="100%" height="450" style="border:1px;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade" id="map"></iframe>
            </div>
        </div>

    </main>
@endsection
