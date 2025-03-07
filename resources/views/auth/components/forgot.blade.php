@extends('auth.layouts.layout')

@section('title')
    <title>Quên mật khẩu</title>
@endsection

@section('content')
    <div class="row">
        <div class="">
            <div class="form-wrapper">
                <form action="{{ route('handleForgot') }}" method="POST">
                    @csrf
                    <a href="{{ redirect()->back() }}"><i class="fa-solid fa-arrow-left back"></i></a>

                    <p class="text-center fs-3 fw-semibold fw-bolder">Quên mật khẩu?</p>

                    <p class="text-center">Nhập vào tên đăng nhập của bạn để lấy lại mật khẩu</p>

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

                    <button type="submit" class="btn btn-primary mg-btn">Tìm tài khoản</button>

                    <hr>
                    <p class=" text-center">Chưa có tài khoản?
                        <a class="text-decoration-none" href="{{ route('register') }}">Đăng ký</a>
                    </p>

                </form>
                <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a>
                </p>
            </div>
        </div>
    </div>
    </div>
@endsection
