@extends('auth.layouts.layout')

@section('title')
    <title>Đăng nhập</title>
@endsection

@section('content')
    <div class="row ms-1 me-1">
        <div class="">
            <div class="form-wrapper">
                <form action="{{ route('login') }}" method="POST">
                    @CSRF

                    {{-- LOGO --}}
                    <a href="{{ route('home') }}">
                        <img src="assets/images/logo/login-format.png" class="w-100 logo" alt="logo">
                    </a>
                    <div class="form-group  mg-form">

                        <!-- FLASH MESSAGES -->
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

                        <!-- Username -->
                        <div class="form-group  mg-form">
                            <div class="form-floating mb-3 mt-3">
                                <input type="text"
                                    class="form-control 
                                @error('username') is-invalid @enderror"
                                    value="{{ old('username') }}" id="username" placeholder="Enter username"
                                    name="username" autocomplete="off">
                                <label class="label-input" for="username">Tên đăng nhập</label>
                            </div>
                            @error('username')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="form-group  mg-form">
                            <div class="form-floating mt-3 mb-3">
                                <input type="password"
                                    class="form-control pwd-mg
                                @error('password') is-invalid @enderror"
                                    id="password" placeholder="Enter password" name="password"
                                    style="background-image: none">
                                <i class="fa-solid fa-eye pwd-eye"></i>
                                <label class="label-input" for="password">Mật khẩu</label>
                            </div>
                            @error('password')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Capcha -->
                        <div class="form-group  mg-form mb-3" style="align-items: center">
                            <div class="form-floating mt-3 mb-0 d-flex justify-content-start" style="align-items: center"
                                id="capcha-group">
                                <input type="text"
                                    class="form-control 
                                 @error('captcha') is-invalid @enderror"
                                    placeholder="" name="captcha">
                                <label class="label-input" for="">Capcha</label>

                                <img id="capcha-img" src="{{ $captcha->inline() }}" style="height: 100%"
                                    class="ms-3 me-3" />

                                <i id="reload-capcha" onclick="reloadCapcha()" class="fa-solid fa-rotate-right"></i>
                            </div>
                            @error('captcha')
                                <span class="invalid-feedback" style="display: block">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary mg-btn">Đăng nhập</button>

                        <hr>
                        <p class=" text-center">Chưa có tài khoản?
                            <a class="text-decoration-none" href="{{ route('register') }}">Đăng ký</a>
                        </p>
                        <p class=" text-center"><a class="text-decoration-none" href="{{ route('forgot') }}">Quên mật
                                khẩu?</a>
                        </p>
                </form>
                <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a>
                </p>
            </div>
        </div>
    </div>
@endsection
