@extends("auth.layouts.layout")

@section("title")
<title>Kích hoạt gmail</title>
@endsection

@section("content")
<div class="row">
    <div class="">
        <div class="form-wrapper">
            <form action="/active/sendEmailToken" method="POST">
                <a href="/setting"><i class="fa-solid fa-arrow-left back"></i></a>

                <!-- FLASH MESSAGES -->
                <?//php if (!empty($msg)): ?>
                    <?//php foreach ($msg as $key => $value): ?>
                        <div class="alert alert-<?//= e($key) ?> text-center">
                            <strong><?//= e($value) ?></strong>
                        </div>
                    <?//php endforeach; ?>
                <?//php endif ?>

                <p class="text-center fs-3 fw-semibold fw-bolder">Xác thực email</p>

                <!-- Fix CSRF -->
                <input type="hidden" name="token" value="<?//= $_SESSION['token'] ?>">

                <!-- Email -->
                <div class="form-group  mg-form">
                    <div class="form-floating mb-3 mt-3">
                        <input type="text" class="form-control" id="email" placeholder="Enter email" name="email"
                            autocomplete="off" disabled value="<?//= e($dataAccount['email']) ?? "" ?>">
                        <label class="label-input" for="email">Email</label>
                    </div>
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

                <button type="submit" class="btn btn-primary mg-btn">Gửi mã xác thực</button>

            </form>
            <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a></p>
        </div>
    </div>
</div>
@endsection