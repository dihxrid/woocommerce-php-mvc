<?php include_once "includes/header.php" ?>

<style>
    .section-register {
        margin-top: 100px;
        margin-bottom: 130spx;
    }
</style>

<section class="section-register">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h2>Đăng ký</h2>
                    </div>
                    <div class="card-body">
                        <form id="registerForm" action="/admin/users/register" method="post">
                            <div class="mb-3">
                                <label for="username" class="form-label">Tên đăng nhập</label>
                                <input name="username" type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập" required>
                                <div class="text-danger" id="error-username"></div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input name="email" type="email" class="form-control" id="email" placeholder="Nhập email" required>
                                <div class="text-danger" id="error-email"></div>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input name="phone" type="text" class="form-control" id="phone" placeholder="Nhập số điện thoại" required pattern="^\d{10}$" title="Số điện thoại phải có 10 chữ số">
                                <div class="text-danger" id="error-phone"></div>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input name="password" type="password" class="form-control" id="password" placeholder="Nhập mật khẩu" required minlength="6" title="Mật khẩu phải có ít nhất 6 ký tự">
                                <div class="text-danger" id="error-password"></div>
                            </div>
                            <div class="mb-3">
                                <label for="confirm-password" class="form-label">Xác nhận mật khẩu</label>
                                <input name="confirm_password" type="password" class="form-control" id="confirm_password" placeholder="Xác nhận mật khẩu" required minlength="6" title="Mật khẩu phải giống với mật khẩu đã nhập ở trên">
                                <div class="text-danger" id="error-confirm_password"></div>
                            </div>
                            <div class="mb-3">
                                <input type="checkbox" class="form-check-input" id="terms" required>
                                <label class="form-check-label" for="terms">Chấp nhận điều khoản</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Đăng ký</button>
                        </form>

                    </div>
                    <div class="card-footer text-center">
                        <small>Đã có tài khoản? <a href="/login">Đăng nhập</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once "includes/footer.php" ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
    $(document).ready(function() {
    $('#registerForm').on('submit', function(e) {
        e.preventDefault();

        // Kiểm tra xác thực của form
        if (this.checkValidity() === false) {
            this.classList.add('was-validated');
            return;
        }

        $.ajax({
            type: 'POST',
            url: '/admin/users/register',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Đăng ký thành công',
                        text: 'Thành công',
                        icon: 'success'
                    }).then(function() {
                        window.location.href = '/otp-register';
                    });
                } else if (response.errors) {
                    // Clear previous error messages
                    $('.text-danger').text('');

                    // Display new error messages
                    $.each(response.errors, function(key, value) {
                        $('#error-' + key).text(value);
                    });
                }
            },
            error: function() {
                alert('Đã xảy ra lỗi khi gửi yêu cầu. Vui lòng thử lại.');
            }
        });
    });
});

</script> -->