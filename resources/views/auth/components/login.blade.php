@extends('auth.layouts.auth')

@section('title')
    <title>Đăng nhập</title>
@endsection

@section('content')
    <div class="row ms-1 me-1">
        <div class="">
            <div class="form-wrapper">
                <form action="/login/store" method="POST">
                    @CSRF

                    {{-- LOGO --}}
                    <a href="{{ route("home") }}">
                        <img src="assets/images/logo/login-format.png" class="w-100 logo" alt="logo">
                    </a>
                    <div class="form-group  mg-form">

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

                        <?//php if (!empty($mustLogin)): ?>
                        <div class="alert alert-warning text-center">
                            <strong>
                                <?//= e($mustLogin) ?>
                            </strong>
                        </div>
                        <?//php endif ?>

                        <!-- Username -->
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control <?php //isset($errors['username']) ? 'is-invalid' : ''
                            ?>" id="username"
                                placeholder="Enter username" name="username" autocomplete="off"
                                value="<?= isset($oldForm) ? e($oldForm['username']) : '' ?>">
                            <label class="label-input" for="username">Tên đăng nhập</label>
                        </div>
                        <?php //if (isset($errors['username'])):
                        ?>
                        <?php //foreach ($errors['username'] as $value):
                        ?>
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
                        <div class="form-floating mt-3 mb-0">
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

                    <button type="submit" class="btn btn-primary mg-btn">Đăng nhập</button>

                    <hr>
                    <p class=" text-center">Chưa có tài khoản?
                        <a class="text-decoration-none" href="{{ route('register') }}">Đăng ký</a>
                    </p>
                    <p class=" text-center"><a class="text-decoration-none" href="{{ route('forgot') }}">Quên mật khẩu?</a>
                    </p>
                </form>
                <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a>
                </p>
            </div>
        </div>
    </div>
@endsection
