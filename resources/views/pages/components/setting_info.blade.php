@extends('pages.layouts.layout')

@section('title')
    <title>Tài khoản</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('css/setting.css') }}">
@endsection

@section('content')
    <main>
        <div class="row justify-content-center">
            <div class="settingUserInfo">
                <p class="settingUserInfo__title">Thông tin cá nhân</p>

                <!-- FLASH MESSAGE -->
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

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

                <div class="settingUserInfo__navWrapper row">
                    <div class="settingUserInfo__navWrapper__nav col-12 col-lg-10 offset-lg-1" data-bs-toggle="modal"
                        data-bs-target="#Model1">
                        <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                        <p class="settingUserInfo__navWrapper__nav__title">Thông tin liên lạc</p>
                        <p class="settingUserInfo__navWrapper__nav__info mb-0">
                            {{ $user['email'] ?? 'Địa chỉ email' }}
                            @if ($user['email'] && $user['email_active'] == 0)
                                <i> (Chưa kích hoạt)</i>
                            @endif
                        </p>
                        <p class="settingUserInfo__navWrapper__nav__info">{{ $user['phone'] ?? 'Số điện thoại' }}</p>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="Model1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                                <div class="modal-header">
                                    <strong>
                                        <h1 class="modal-title text-center ms-auto">
                                            Thông tin liên lạc</h1>
                                    </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('setting.updateEmailPhone') }}" method="POST"
                                    onsubmit="return formConfirm(['email','phone'])">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="row">
                                            <label for="email" class="form-label ">
                                                Email:</label>
                                            <div class="">
                                                <!-- Fix csrf -->
                                                @csrf
                                                <input type="text" name="email" id="email"
                                                    class="form-control mb-1
                                                settingUserInfo__navWrapper__modalBackground  
                                                @error('email') is-invalid @enderror"
                                                    placeholder="Nhập vào email" value="{{ old('email', $user['email']) }}">
                                                <span class="invalid-feedback" style="display: block">
                                                    @error('email')
                                                        <strong>{{ $message }}</strong>
                                                    @enderror
                                                </span>
                                                @if ($user['email'] && $user['email_active'] == 0)
                                                    <span id="check_active_email" class="text-danger mb-4">
                                                        Kích hoạt email
                                                        <a href="{{ route('sendEmail') }}" class="text-danger">
                                                            <strong>tại đây</strong></a></span>
                                                @endif
                                            </div>

                                            <label for="phone" class="form-label"> Số
                                                điện thoại:</label>
                                            <div class="">
                                                <input type="text" name="phone" id="phone"
                                                    class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground
                                                @error('phone') is-invalid @enderror"
                                                    placeholder="Nhập vào số điện thoại"
                                                    value="{{ old('phone', $user['phone']) }}">
                                                <span class="invalid-feedback mb-3" style="display: block">
                                                    @error('phone')
                                                        <strong>{{ $message }}</strong>
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                            bỏ</button>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="settingUserInfo__navWrapper__nav col-12 col-lg-10 offset-lg-1" data-bs-toggle="modal"
                        data-bs-target="#Model2">
                        <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                        <p class="settingUserInfo__navWrapper__nav__title">Tên</p>
                        <p class="settingUserInfo__navWrapper__nav__info">
                            {{ $user['name'] ?? 'Họ tên' }}
                        </p>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="Model2" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content settingUserInfo__navWrapper__modalBackground ">
                                <div class="modal-header">
                                    <strong>
                                        <h1 class="modal-title text-center ms-auto">
                                            Tên</h1>
                                    </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('setting.updateName') }}" method="POST"
                                    onsubmit="return formConfirm(['name'])">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="row">
                                            <label for="name" class="form-label ">
                                                Tên:</label>
                                            <div class="">
                                                <!-- Fix csrf -->
                                                @csrf
                                                <input type="text" name="name" id="name"
                                                    class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground
                                                @error('name') is-invalid @enderror"
                                                    placeholder="Nhập vào họ tên" value="{{ old('name', $user['name']) }}">
                                                <span class="invalid-feedback mb-3" style="display: block">
                                                    @error('name')
                                                        <strong>{{ $message }}</strong>
                                                    @enderror
                                                </span>

                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                            bỏ</button>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="settingUserInfo__navWrapper__nav col-12 col-lg-10 offset-lg-1" data-bs-toggle="modal"
                        data-bs-target="#Model3">
                        <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                        <p class="settingUserInfo__navWrapper__nav__title">Ngày sinh</p>
                        <p class="settingUserInfo__navWrapper__nav__info">
                            {{ $user['birthday'] ?? 'Ngày sinh ' }}
                        </p>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="Model3" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                                <div class="modal-header">
                                    <strong>
                                        <h1 class="modal-title text-center ms-auto">
                                            Ngày sinh</h1>
                                    </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('setting.updateBirthday') }}" method="POST"
                                    onsubmit="return formConfirm(['birthday'])">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="row">
                                            <label for="birthday" class="form-label ">
                                                Ngày:</label>
                                            <div class="">
                                                <!-- Fix csrf -->
                                                @csrf
                                                <input type="date" name="birthday" id="birthday"
                                                    class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground
                                                @error('birthday') is-invalid @enderror"
                                                    value="{{ old('birthday', $user['birthday']) }}">
                                                <span class="invalid-feedback mb-3" style="display: block">
                                                    @error('birthday')
                                                        @error('birthday')
                                                            <strong>{{ $message }}</strong>
                                                        @enderror
                                                    @enderror
                                                </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                            bỏ</button>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="settingUserInfo__navWrapper__nav settingUserInfo__navWrapper__nav--last col-12 col-lg-10 offset-lg-1"
                        data-bs-toggle="modal" data-bs-target="#Model4">
                        <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                        <p class="settingUserInfo__navWrapper__nav__title">Giới tính</p>
                        <p class="settingUserInfo__navWrapper__nav__info">
                            @if ($user['gender'] == 'male')
                                {{ 'Nam' }}
                            @elseif ($user['gender'] == 'female')
                                {{ 'Nữ' }}
                            @else
                                {{ 'Giới tính' }}
                            @endif
                        </p>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="Model4" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog ">
                            <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                                <div class="modal-header">
                                    <strong>
                                        <h1 class="modal-title text-center ms-auto">
                                            Giới tính</h1>
                                    </strong>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="{{ route('setting.updateGender') }}" method="POST"
                                    onsubmit="return genderValidate('gender')">
                                    @csrf
                                    @method('put')
                                    <div class="modal-body">
                                        <div class="row">
                                            <label for="gender" class="form-label ">
                                                Giới tính:</label>
                                            <div class="">
                                                <!-- Fix csrf -->
                                                @csrf
                                                <input type="radio" id="gender" name="gender"
                                                    class="form-check-input mb-3
                                                settingUserInfo__navWrapper__modalBackground"
                                                    value="male" @checked($user['gender'] == 'male')> Nam
                                                <input type="radio" id="gender" name="gender"
                                                    class="ms-1 form-check-input mb-3
                                                settingUserInfo__navWrapper__modalBackground
                                                @error('gender') is-invalid @enderror"
                                                    value="female" @checked($user['gender'] == 'female')> Nữ
                                                <span class="invalid-feedback mb-3" style="display: block">
                                                    @error('gender')
                                                        <strong>{{ $message }}</strong>
                                                    @enderror
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"> Hủy
                                            bỏ</button>
                                        <button type="submit" class="btn btn-primary">Cập nhật</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection

@section('js')
    <script src="{{ asset('/js/formConfirm.js') }}"></script>
@endsection
