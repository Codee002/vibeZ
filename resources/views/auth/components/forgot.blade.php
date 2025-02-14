@extends("auth.layouts.auth")

@section("title")
<title>Quên mậ khẩu</title>
@endsection

@section("content")
<div class="row">
    <div class="">
        <div class="form-wrapper">
            <form action="/forgot/findUser" method="POST">

                <a href="/login"><i class="fa-solid fa-arrow-left back"></i></a>

                <p class="text-center fs-3 fw-semibold fw-bolder">Quên mật khẩu?</p>

                <p class="text-center">Nhập vào tên đăng nhập của bạn để lấy lại mật khẩu</p>

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
                        <input type="text" class="form-control <?//= isset($errors['username']) ? 'is-invalid' : '' ?>"
                            id="username" placeholder="Enter username" name="username" autocomplete="off"
                            value="<?//= !empty($oldForm['username']) ? e($oldForm['username']) : "" ?>">
                        <label class="label-input" for="username">Tên đăng nhập</label>
                    </div>
                    <?//php if (isset($errors['username'])): ?>
                        <?//php foreach ($errors['username'] as $value): ?>
                            <span class="invalid-feedback" style="display: block">
                                <strong><?//= e($value) ?></strong>
                            </span>
                        <?//php endforeach ?>
                    <?//php endif ?>
                </div>

                <!-- Capcha -->
                <div class="form-group  mg-form mb-3" style="align-items: center">
                    <div class="form-floating mt-3 mb-0 d-flex justify-content-start" style="align-items: center"
                        id="capcha-group">
                        <input type="text" class="form-control  <?//= isset($errors['capcha']) ? 'is-invalid' : '' ?>"
                            placeholder="" name="capcha">
                        <label class="label-input" for="">Capcha</label>

                        <img id="capcha-img" src="<?//php echo $capcha->inline(); ?>" style="height: 100%"
                            class="ms-3 me-3" />

                        <i id="reload-capcha" onclick="reloadCapcha()" class="fa-solid fa-rotate-right"></i>
                    </div>
                    <?//php if (isset($errors['capcha'])): ?>
                        <?//php foreach ($errors['capcha'] as $value): ?>
                            <span class="invalid-feedback" style="display: block">
                                <strong><?//= e($value) ?></strong>
                            </span>
                        <?//php endforeach ?>
                    <?//php endif ?>
                </div>

                <button type="submit" class="btn btn-primary mg-btn">Tìm tài khoản</button>

                <hr>
                <p class=" text-center">Chưa có tài khoản?
                    <a class="text-decoration-none" href="{{ route("register") }}">Đăng ký</a>
                </p>

            </form>
            <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a></p>
        </div>
    </div>
</div>
</div>
@endsection