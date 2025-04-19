@extends('auth.layouts.layout')

@section('title')
    <title>Kích hoạt gmail</title>
@endsection

@section('content')
    <div class="row">
        <div class="">
            <div class="form-wrapper">
                <form action=" {{ route('sendEmail') }}" method="POST">
                    <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left back"></i></a>
                    @csrf
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

                    <p class="text-center fs-3 fw-semibold fw-bolder">Xác thực email</p>

                    <!-- Email -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="email" placeholder="Enter email"
                                name="email" autocomplete="off" disabled value="{{ $user['email'] }}">
                            <label class="label-input" for="email">Email</label>
                        </div>
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

                    <button type="submit" class="btn btn-primary mg-btn">Gửi mã xác thực</button>

                </form>
                <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a>
                </p>
            </div>
        </div>
    </div>
@endsection
