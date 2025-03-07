@extends('auth.layouts.layout')

@section('title')
    <title>Đặt lại mật khẩu</title>
@endsection

@section('content')
    <div class="row ms-1 me-1">
        <div class="">
            <div class="form-wrapper">
                <form action="{{ route('handleReset', $user) }}" method="POST">
                    @csrf
                    <a href="{{ route('forgot') }}"><i class="fa-solid fa-arrow-left back"></i></a>

                    <p class="text-center fs-3 fw-semibold fw-bolder">Đặt lại mật khẩu</p>

                    <p class="text-center">Xin chào <strong>{{ $user['name'] }}</strong></p>
                    <p class="text-center">Vui lòng đặt lại mật khẩu mới cho tài khoản</p>
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
                            <input type="text" class="form-control" value="{{ $user['username'] }}" name="username"
                                autocomplete="off" disabled>
                            <label class="label-input" for="username">Tên đăng nhập</label>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" value="{{ $user['email'] }}" name="email"
                                autocomplete="off" disabled>
                            <label class="label-input" for="email">Email</label>
                        </div>
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

                    <button type="submit" class="btn btn-primary mg-btn">Đổi mật khẩu</button>
                </form>
                <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a>
                </p>
            </div>
        </div>
    </div>
@endsection
