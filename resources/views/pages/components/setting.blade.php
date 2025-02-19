@extends('pages.layouts.layout')

@section('title')
    <title>Tài khoản</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/setting.css">
@endsection

@section('content')
<main>
    <div class="row justify-content-center">
        <div class="settingUserInfo">
        <p class="settingUserInfo__title">Thông tin cá nhân</p>

        <!-- FLASH MESSAGE -->
        <div class="settingUserInfo__navWrapper row">
            <div class="settingUserInfo__navWrapper__nav col-12 col-lg-10 offset-lg-1" data-bs-toggle="modal"
                data-bs-target="#Model1">
                <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                <p class="settingUserInfo__navWrapper__nav__title">Thông tin liên lạc</p>
                <p class="settingUserInfo__navWrapper__nav__info mb-0">
                    <?php// if (isset($dataAccount['email'])) {
                       // if ($dataAccount['email_active'] == 0) {
                        //    echo e($dataAccount['email'] . '    (chưa kích hoạt)');
                        //} else {
                         //   echo e($dataAccount['email']);
                       // }
                    //} else {
                     //   echo e('Địa chỉ email');
                    //} ?>
                    kakashivncm123@gmail.com
                </p>
                <p class="settingUserInfo__navWrapper__nav__info">
                    {{-- <?= //isset($dataAccount['phone_number']) ? e($dataAccount['phone_number']) : e('Số điện thoại') ?> --}}
                    0918242085
                </p>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/setting/storeAccount" method="POST"
                            onsubmit="return formConfirm(['email','phone_number'])">
                            <div class="modal-body">
                                <div class="row">
                                    <label for="email" class="form-label ">
                                        Email:</label>
                                    <div class="">
                                        <!-- Fix csrf -->
                                        @csrf
                                        <input type="text" name="email" id="email"
                                            class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground"
                                            {{-- value="<?= //isset($dataAccount['email']) ? e($dataAccount['email']) : e('') ?>" --}}
                                            placeholder="Nhập vào email">
                                        <?php// if ($dataAccount['email_active'] == 0 && !empty($dataAccount['email']) && !empty($dataAccount)): ?>
                                        <span id="check_active_email" class="text-danger">Kích hoạt email <a
                                                href="{{route("active_email")}}" class="text-danger"><strong>tại đây</strong></a></span>
                                        <?php// endif ?>
                                        <span class="mb-3 invalid-feedback" style="display: block">

                                        </span>
                                    </div>

                                    <label for="phone_number" class="form-label"> Số
                                        điện thoại:</label>
                                    <div class="">
                                        <input type="text" name="phone_number" id="phone_number"
                                            class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground"
                                            {{-- value="<?= //isset($dataAccount['phone_number']) ? e($dataAccount['phone_number']) : e('') ?>" --}}
                                            placeholder="Nhập vào số điện thoại">
                                        <span class="mb-3 invalid-feedback" style="display: block">

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
                    {{-- <?=// isset($dataUser['name']) ? e($dataUser['name']) : e('Họ tên') ?> --}}
                    Trần Thanh Phúc
                </p>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="Model2" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h1 class="modal-title text-center ms-auto">
                                    Tên</h1>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/setting/storeUser" method="POST" onsubmit="return formConfirm(['name'])">
                            <div class="modal-body">
                                <div class="row">
                                    <label for="name" class="form-label ">
                                        Tên:</label>
                                    <div class="">
                                        <!-- Fix csrf -->
                                        @csrf
                                        <input type="text" name="name" id="name"
                                            class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground"
                                            {{-- value="<?= //isset($dataUser['name']) ? e($dataUser['name']) : e('') ?>" --}}
                                            placeholder="Nhập vào họ tên">
                                        <span class="mb-3 invalid-feedback" style="display: block">

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
                    {{-- <?=// isset($dataUser['birth']) ? e($dataUser['birth']) : e('mm/dd/yy') ?> --}}
                    16/10/2004
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
                        <form action="/setting/storeUser" method="POST" onsubmit="return birthdayValidate('birth')">
                            <div class="modal-body">
                                <div class="row">
                                    <label for="birth" class="form-label ">
                                        Ngày:</label>
                                    <div class="">
                                        <!-- Fix csrf -->
                                        @csrf

                                        <input type="date" name="birth" id="birth"
                                            class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground"
                                            {{-- value="<?=// isset($dataUser['birth']) ? e($dataUser['birth']) : e('') ?>" --}}
                                            >
                                        <span class="mb-3 invalid-feedback" style="display: block">
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
                data-bs-target="#Model4">
                <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                <p class="settingUserInfo__navWrapper__nav__title">Giới tính</p>
                <p class="settingUserInfo__navWrapper__nav__info">
                    <?php// if ($dataUser['gender'] == 'none') {
                      // echo e('Giới tính');
                  //  } else {
                  //      echo $dataUser['gender'] == 'male' ? e('Nam') : e('Nữ');
                   // } ?>
                   Nam
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
                        <form action="/setting/storeUser" method="POST" onsubmit="return genderValidate('gender')">
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
                                            {{-- <?=// $dataUser['gender'] == 'male' ? 'checked' : '' ?>  --}}
                                            value="male"> Nam
                                        <input type="radio" id="gender" name="gender"
                                            class="ms-1 form-check-input mb-3
                                                settingUserInfo__navWrapper__modalBackground"
                                            {{-- <?=// $dataUser['gender'] == 'female' ? 'checked' : '' ?> --}}
                                             value="female"> Nữ
                                        <span class="mb-3 invalid-feedback" style="display: block"></span>

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
                data-bs-toggle="modal" data-bs-target="#Model5">
                <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                <p class="settingUserInfo__navWrapper__nav__title">Địa chỉ</p>
                <p class="settingUserInfo__navWrapper__nav__info">
                    {{-- <?=// isset($dataUser['address']) ? e($dataUser['address']) : e('Quê quán') ?> --}}
                    Cà Mau
                </p>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="Model5" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h1 class="modal-title text-center ms-auto">
                                   Địa chỉ</h1>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="/setting/storeUser" method="POST" onsubmit="return formConfirm(['address'])">
                            <div class="modal-body">
                                <div class="row">
                                    <label for="address" class="form-label ">
                                        Địa chỉ:</label>
                                    <div class="">
                                        <!-- Fix csrf -->
                                        @csrf

                                        <input type="text" id="address" name="address"
                                            class="form-control mb-3
                                                settingUserInfo__navWrapper__modalBackground"
                                            {{-- value="<?= //isset($dataUser['address']) ? e($dataUser['address']) : e('') ?>" --}}
                                            placeholder="Nhập vào địa chỉ">
                                        <span class="mb-3 invalid-feedback" style="display: block">

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

@section("js")
<script src="/js/formConfirm.js"></script>
@endsection
