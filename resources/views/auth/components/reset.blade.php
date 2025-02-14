<div class="row">
    <div class="">
        <div class="form-wrapper">
            <form action="/reset/store" method="POST">

                <p class="text-center fs-3 fw-semibold fw-bolder">Đặt Lại Mật Khẩu</p>

                <!-- FLASH MESSAGES -->
                <?//php if (!empty($msg)): ?>
                    <?//php foreach ($msg as $key => $value): ?>
                        <div class="alert alert-<?//= e($key) ?> text-center">
                            <strong><?//= e($value) ?></strong>
                        </div>
                    <?//php endforeach; ?>
                <?//php endif ?>

                <!-- Fix CSRF -->
                <input type="hidden" name="token" value="<?//= $_SESSION['token'] ?>">

                <!-- Username -->
                <div class="form-group  mg-form">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="username" placeholder="" name="username" disabled
                            value="<?//= !empty($account['username']) ? e($account['username']) : e("") ?>">
                        <label class="label-input" for="username">Tên đăng nhập</label>
                    </div>
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
                                <strong><?//= e($value) ?></strong>
                            </span>
                        <?//php endforeach ?>
                    <?//php endif ?>
                </div>

                <!-- Password Confirm -->
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
                                <strong><?//= e($value) ?></strong>
                            </span>
                        <?//php endforeach ?>
                    <?//php endif ?>
                </div>

                <button type="submit" class="btn btn-primary mg-btn">Đổi mật khẩu</button>

                <hr>

                <p class=" text-center">Đã có tài khoản?
                    <a class="text-decoration-none" href="">Đăng nhập</a>
                </p>

            </form>

            <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a></p>

        </div>
    </div>
</div>