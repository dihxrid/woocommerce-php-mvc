<?php 
include_once "includes/header.php";
 ?>

<style>
    .section-login {
        margin-top: 100px;
        margin-bottom: 136px;
    }
</style>

<body>

    <section class="section-login">
        <div class="container px-4 px-lg-5 mb-lg-0">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mt-5">
                        <div class="card-header text-center">
                            <h2>Đăng nhập</h2>
                        </div>
                        <div class="card-body">
                            <form action="/admin/users/login" method="post">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Tên đăng nhập</label>
                                    <input name="username" type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập" value="<?= htmlspecialchars($data['username'] ?? '') ?>">
                                    <?php if (!empty($errors['username'])) : ?>
                                        <div class="text-danger"><?= htmlspecialchars($errors['username']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Mật khẩu</label>
                                    <input name="password" type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" value="<?= htmlspecialchars($data['password'] ?? '') ?>">
                                    <?php if (!empty($errors['password'])) : ?>
                                        <div class="text-danger"><?= htmlspecialchars($errors['password']) ?></div>
                                    <?php endif; ?>
                                </div>
                                <?php if (!empty($errors['login'])) : ?>
                                    <div class="text-danger"><?= htmlspecialchars($errors['login']) ?></div>
                                <?php endif; ?>
                                <div class="mb-3">
                                    <input type="checkbox" class="form-check-input">
                                    <label class="form-check-label">Ghi nhớ mật khẩu</label>
                                    <a href="/reset-password" class="float-end">Quên mật khẩu</a>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
                                <hr>
                                <a href="/login/google" class="btn btn-danger w-100"><i class="bi bi-google"></i> Đăng nhập bằng google</a>
                            </form>
                        </div>
                        <div class="card-footer text-center">
                            <small>Chưa có tài khoản? <a href="/register">Đăng ký</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php include_once "includes/footer.php" ?>