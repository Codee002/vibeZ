@extends('auth.layouts.layout')

@section('title')
    <title>Đăng ký</title>
@endsection

@section('content')
    <div class="row">
        <div class="">
            <div class="form-wrapper">
                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    {{-- LOGO --}}
                    <a href="{{ route('home') }}">
                        {{-- <img src="assets/images/logo/register-format.png" class="w-100 logo" alt=""> --}}
                        <img src="{{ \Storage::url(\App\Models\GeneralImage::getRegister()) }}" class="w-100 logo" alt="">
                    </a>
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

                    <!-- Name -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text"
                                class="form-control
                              @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" id="name" placeholder="Enter name" name="name"
                                autocomplete="off">
                            <label class="label-input" for="name">Họ tên</label>
                        </div>
                        @error('name')
                            <span class="invalid-feedback" style="display: block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Username -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text"
                                class="form-control 
                                @error('username') is-invalid @enderror"
                                value="{{ old('username') }}" id="username" placeholder="Enter username" name="username"
                                autocomplete="off">
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
                                id="password" placeholder="Enter password" name="password" style="background-image: none">
                            <i class="fa-solid fa-eye pwd-eye"></i>
                            <label class="label-input" for="password">Mật khẩu</label>
                        </div>
                        @error('password')
                            <span class="invalid-feedback" style="display: block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- PassConfirm -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mt-3 mb-3">
                            <input type="password"
                                class="form-control password-mg
                                @error('password_confirmation') is-invalid @enderror"
                                id="password_confirmation" placeholder="Enter password_confirm" name="password_confirmation"
                                style="background-image: none">
                            <i class="fa-solid fa-eye pwd-eye"></i>
                            <label class="label-input" for="password_confirmation">Nhập lại mật khẩu</label>
                        </div>
                        @error('password_confirmation')
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

                            <img id="capcha-img" src="{{ $captcha->inline() }}" style="height: 100%" class="ms-3 me-3" />

                            <i id="reload-capcha" onclick="reloadCapcha()" class="fa-solid fa-rotate-right"></i>
                        </div>
                        @error('captcha')
                            <span class="invalid-feedback" style="display: block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group  mg-form">
                        <label for="accept"><input type="checkbox" value="1" id="accept" name="accept"
                                class="form-check-input 
                                 @error('accept') is-invalid @enderror">
                            Bằng
                            việc Đăng ký, bạn đã đọc và đồng ý với
                            <a href="" class="text-decoration-none">Điều khoản sử dụng</a> và
                            <a href="" class="text-decoration-none">Chính sách bảo mật</a> của chúng tôi</label>
                        @error('accept')
                            <span class="invalid-feedback" style="display: block">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mg-btn">Đăng ký</button>

                    <hr>

                    <p class=" text-center">Đã có tài khoản?
                        <a class="text-decoration-none" href="{{ route('login') }}">Đăng nhập</a>
                    </p>
                    <p class=" text-center"><a class="text-decoration-none" href="{{ route('forgot') }}">Quên mật
                            khẩu?</a>
                    </p>
                </form>

                <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo
                        mật</a></p>
            </div>
        </div>
    </div>
@endsection
