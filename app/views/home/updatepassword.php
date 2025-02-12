<?php
include_once "includes/header.php";
?>
<section class="update-password-section">
    <div class="container" style="min-height: 50vh; margin-top: 10rem;">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Đổi mật khẩu
                    </div>
                    <div class="card-body">
                        <form action="/update-new-password" method="POST">
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">Mật khẩu mới</label>
                                <input name="password" type="password" class="form-control" id="newPassword" placeholder="Nhập mật khẩu mới">
                            </div>
                            <div class="mb-3">
                                <label for="confirmNewPassword" class="form-label">Xác nhận mật khẩu mới</label>
                                <input name="confirm_password" type="password" class="form-control" id="confirmNewPassword" placeholder="Xác nhận mật khẩu mới">
                            </div>
                            <input type="hidden" name="id" value="<?php echo $_GET['id'] ?>">
                            <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
include_once "includes/footer.php";
?>