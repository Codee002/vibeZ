@extends('pages.layouts.layout')

@section('title')
    <title>Bảo mật</title>
@endsection

@section('css')
    <link rel="stylesheet" href="css/setting.css">
@endsection

@section('content')
<main>
    <div class="row justify-content-center">
        <div class="settingUserInfo">
        <p class="settingUserInfo__title">Bảo mật</p>

        <!-- FLASH MESSAGE -->
        <div class="settingUserInfo__navWrapper row">
            <div class="settingUserInfo__navWrapper__nav col-12 col-lg-10 offset-lg-1" data-bs-toggle="modal"
                data-bs-target="#Model1">
                <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                <p class="settingUserInfo__navWrapper__nav__title">Đổi mật khẩu</p>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="Model1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h1 class="modal-title text-center ms-auto">
                                    Đổi mật khẩu</h1>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="getPassword" method="POST" action="/setting/changePassword"
                            action="/setting/changePassword"
                            onsubmit="return formConfirm(['oldpass', 'password', 'password_confirm'])">
                            <div class="modal-body">
                                <div class="row">
                                    <!-- Fix CSRF -->
                                    @csrf
    
                                    <label for="oldpass" class="form-label ">
                                        Mật khẩu cũ:</label>
                                    <div class="form-group">
                                        <input type="password" name="oldpass" id="oldpass" placeholder="Nhập mật khẩu"
                                            class="form-control mb-3
                                                    settingUserInfo__navWrapper__modalBackground 
                                                    ">
                                        <i class="fa-solid fa-eye pwd-eye"></i>
    
                                        <span class="mb-3 invalid-feedback" style="display: block"></span>
    
                                    </div>
    
    
                                    <label for="password" class="form-label"> Mật khẩu mới:</label>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" placeholder="Nhập mật khẩu"
                                            class="form-control mb-3
                                                    settingUserInfo__navWrapper__modalBackground 
                                                   ">
                                        <i class="fa-solid fa-eye pwd-eye"></i>
    
                                        <span class="mb-3 invalid-feedback" style="display: block"></span>
    
                                    </div>
    
    
                                    <label for="password_confirm" class="form-label"> Nhập lại mật khẩu:</label>
                                    <div class="form-group">
                                        <input type="password" name="password_confirm" id="password_confirm"
                                            placeholder="Nhập lại mật khẩu" class="form-control mb-3
                                                    settingUserInfo__navWrapper__modalBackground 
                                                   ">
                                        <i class="fa-solid fa-eye pwd-eye"></i>
    
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
                data-bs-toggle="modal" data-bs-target="#Modal2">
                <i class="fa-solid fa-angle-right settingUserInfo__navWrapper__next"></i>
                <p class="settingUserInfo__navWrapper__nav__title">Xác thực 2 bước</p>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="Modal2" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog ">
                    <div class="modal-content settingUserInfo__navWrapper__modalBackground">
                        <div class="modal-header">
                            <strong>
                                <h1 class="modal-title text-center ms-auto">
                                    Xác thực 2 bước</h1>
                            </strong>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
    
                        <div class="modal-body mt-2 mb-2">
                            <p class="">Khi bật xác thực 2 bước. Bạn sẽ phải xác thực gmail trước khi đăng nhập.</p>
                        </div>
                        <div
                            class="modal-footer d-flex justify-content-between settingUserInfo__navWrapper__modalBackground">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Hủy bỏ</button>
                            <div>
                                <a href="/setting/authTwoStep/off"><button type="button"
                                        class="btn btn-secondary">Tắt</button></a>
                                <a href="/setting/authTwoStep/on"><button type="submit"
                                        class="btn btn-primary ms-2">Bật</button></a>
                            </div>
                        </div>
    
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