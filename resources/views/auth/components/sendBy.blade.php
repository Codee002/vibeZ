<div class="row">
    <div class="">
        <div class="form-wrapper">

            <a href="/forgot"><i class="fa-solid fa-arrow-left back"></i></a>

            <p class="text-center fs-3 fw-semibold fw-bolder">Quên mật khẩu?</p>

            <p class="text-center">Xin chào <strong><?//= e($user['name']) ?? e("noname") ?></strong></p>
            <p class="text-center">Vui lòng chọn phương thức để lấy lại mật khẩu</p>

            <!-- FLASH MESSAGES -->
            <?//php if (!empty($msg)): ?>
                <?//php foreach ($msg as $key => $value): ?>
                    <div class="alert alert-<?//= e($key) ?> text-center">
                        <strong><?//= e($value) ?></strong>
                    </div>
                <?//php endforeach; ?>
            <?//php endif ?>

            <div class="form-group  mg-form">
                <!-- Email -->
                <div class="form-floating mb-3 mt-3" data-bs-toggle="modal" data-bs-target="#Model1">
                    <p type="text" class="form-control" id="email" name="email">
                        <?//= !empty($account['email']) ? e($account['email']) : e("(Chưa có email)") ?>
                    </p>
                    <label class="label-input" for="email">Email</label>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="Model1" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Email</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form action="/forgot/sendMail" method="POST">
                                <!-- Fix CSRF -->
                                <input type="hidden" name="token" value="<?//= $_SESSION['token'] ?>">
                                <div class="modal-body">
                                    <p>
                                        <?//php if (isset($account['email'])) {
                                            if ($account['email_active'] == 0)
                                                echo e($account['email'] . "    (chưa kích hoạt)");
                                            else
                                                echo e($account['email']);
                                        } else
                                            echo e("Địa chỉ email") ?>
                                        </p>
                                        <p class="fw-light"><i>Với phương thức này, sẽ có đường link cấp lại mật khẩu gửi về
                                                email của bạn</i></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Đóng</button>
                                        <button type="submit" class="btn btn-primary">Gửi</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group  mg-form" data-bs-toggle="modal" data-bs-target="#Model2">
                    <div class="form-floating mt-3 mb-3">
                        <p type="text" class="form-control" id="phone" name="phone">
                        <?//= !empty($account['phone_number']) ? e($account['phone_number']) : e("(Chưa có SĐT)") ?>
                    </p>
                    <label class="label-input" for="phone">Số điện thoại</label>

                    <!-- Modal -->
                    <div class="modal fade" id="Model2" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Số điện thoại</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <form action="" method="POST" onsubmit="return false">
                                    <!-- Fix CSRF -->
                                    <input type="hidden" name="token" value="<?//= $_SESSION['token'] ?>">
                                    <div class="modal-body">
                                        <p>
                                            <?//php if (isset($account['phone_number'])) {
                                                if ($account['phone_active'] == 0)
                                                    echo e($account['phone_number'] . "    (chưa kích hoạt)");
                                                else
                                                    echo e($account['phone_number']);
                                            } else
                                                echo e("Số điện thoại") ?>
                                            </p>
                                            <p class="fw-light"><i>Hiện tại phương thức này chưa được hỗ trợ</i></p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Đóng</button>
                                            <!-- <button type="submit" class="btn btn-primary">Gửi</button> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <p class="text-center footer-form"><a href="">Hỗ trợ</a> | <a href="">Chính sách & bảo mật</a></p>
        </div>
    </div>


    <style>
        .modal-content {
            background-color: var(--extra-bg) !important;
            color: var(--font-color);
        }

        .form-group:hover {
            cursor: pointer;
            box-shadow: 0 0 0 .05rem var(--main-color) !important;
            background-color: var(--main-extra-bg) !important;
            border-radius: 0.6rem;
        }
    </style>