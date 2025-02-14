@extends('auth.layouts.auth')

@section('title')
    <title>Đăng ký</title>
@endsection

@section('content')
    <div class="row">
        <div class="">
            <div class="form-wrapper">
                <form action="register/store" method="POST">

                    {{-- LOGO --}}
                    <a href="{{ route("home") }}">
                        <img src="assets/images/logo/register-format.png" class="w-100 logo" alt="">
                    </a>

                    <!-- FLASH MESSAGES -->
                    <?//php if (!empty($msg)): ?>
                    <?//php foreach ($msg as $key => $value): ?>
                    <div class="alert alert-<?//= e($key) ?> text-center">
                        <strong>
                            <?//= e($value) ?>
                        </strong>
                    </div>
                    <?//php endforeach; ?>
                    <?//php endif ?>

                    <!-- Fix CSRF -->
                    <input type="hidden" name="token" value="<?//= $_SESSION['token'] ?>">

                    <!-- Name -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control <?//= isset($errors['name']) ? 'is-invalid' : '' ?>"
                                id="name" placeholder="Enter name" name="name" autocomplete="off"
                                value="<?//= isset($oldForm) ? e($oldForm['name']) : '' ?>">
                            <label class="label-input" for="name">Họ tên</label>
                        </div>
                        <?//php if (isset($errors['name'])): ?>
                        <?//php foreach ($errors['name'] as $value): ?>
                        <span class="invalid-feedback" style="display: block">
                            <strong>
                                <?//= e($value) ?>
                            </strong>
                        </span>
                        <?//php endforeach ?>
                        <?//php endif ?>
                    </div>

                    <!-- Username -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text"
                                class="form-control <?//= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username"
                                placeholder="Enter username" name="username" autocomplete="off"
                                value="<?//= isset($oldForm) ? e($oldForm['username']) : '' ?>">
                            <label class="label-input" for="username">Tên đăng nhập</label>
                        </div>
                        <?//php if (isset($errors['username'])): ?>
                        <?//php foreach ($errors['username'] as $value): ?>
                        <span class="invalid-feedback" style="display: block">
                            <strong>
                                <?//= e($value) ?>
                            </strong>
                        </span>
                        <?//php endforeach ?>
                        <?//php endif ?>
                    </div>

                    <!-- Password -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mt-3 mb-3">
                            <input type="password"
                                class="form-control <?//= isset($errors['password']) ? 'is-invalid' : '' ?> pwd-mg"
                                id="password" placeholder="Enter password" name="password" style="background-image: none">
                            <i class="fa-solid fa-eye pwd-eye"></i>
                            <label class="label-input" for="password">Mật khẩu</label>
                        </div>
                        <?//php if (isset($errors['password'])): ?>
                        <?//php foreach ($errors['password'] as $value): ?>
                        <span class="invalid-feedback" style="display: block">
                            <strong>
                                <?//= e($value) ?>
                            </strong>
                        </span>
                        <?//php endforeach ?>
                        <?//php endif ?>
                    </div>

                    <!-- PassConfirm -->
                    <div class="form-group  mg-form">
                        <div class="form-floating mt-3 mb-3">
                            <input type="password"
                                class="form-control <?//= isset($errors['password_confirm']) ? 'is-invalid' : '' ?> password-mg"
                                id="password_confirm" placeholder="Enter password_confirm" name="password_confirm"
                                style="background-image: none">
                            <i class="fa-solid fa-eye pwd-eye"></i>
                            <label class="label-input" for="password_confirm">Nhập lại mật khẩu</label>
                        </div>
                        <?//php if (isset($errors['password_confirm'])): ?>
                        <?//php foreach ($errors['password_confirm'] as $value): ?>
                        <span class="invalid-feedback" style="display: block">
                            <strong>
                                <?//= e($value) ?>
                            </strong>
                        </span>
                        <?//php endforeach ?>
                        <?//php endif ?>
                    </div>

                    <!-- Capcha -->
                    <div class="form-group  mg-form mb-3" style="align-items: center">
                        <div class="form-floating mt-3 mb-0 d-flex justify-content-start" style="align-items: center"
                            id="capcha-group">
                            <input type="text"
                                class="form-control  <?//= isset($errors['capcha']) ? 'is-invalid' : '' ?>" placeholder=""
                                name="capcha">
                            <label class="label-input" for="">Capcha</label>

                            <img id="capcha-img" src="<?//php echo $capcha->inline(); ?>" style="height: 100%"
                                class="ms-3 me-3" />

                            <i id="reload-capcha" onclick="reloadCapcha()" class="fa-solid fa-rotate-right"></i>
                        </div>
                        <?//php if (isset($errors['capcha'])): ?>
                        <?//php foreach ($errors['capcha'] as $value): ?>
                        <span class="invalid-feedback" style="display: block">
                            <strong>
                                <?//= e($value) ?>
                            </strong>
                        </span>
                        <?//php endforeach ?>
                        <?//php endif ?>
                    </div>

                    <div class="form-group  mg-form">
                        <label for="accept"><input required type="checkbox" value="1" id="accept" name="accept"
                                class="form-check-input"> Bằng
                            việc Đăng ký, bạn đã đọc và đồng ý với
                            <a href="" class="text-decoration-none">Điều khoản sử dụng</a> và
                            <a href="" class="text-decoration-none">Chính sách bảo mật</a> của chúng tôi</label>
                    </div>

                    <button type="submit" class="btn btn-primary mg-btn">Đăng ký</button>

                    <hr>

                    <p class=" text-center">Đã có tài khoản?
                        <a class="text-decoration-none" href="{{ route('login') }}">Đăng nhập</a>
                    </p>

                </form>

                <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo
                        mật</a></p>
            </div>
        </div>
    </div>
@endsection
