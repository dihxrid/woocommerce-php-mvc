<?php
include_once "includes/header.php";
?>
<section class="d-flex align-items-center" style="min-height: 69vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header text-center">
                        <h3>Forgot Password</h3>
                    </div>
                    <div class="card-body">
                        <form action="/send-otp" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Nhập email của bạn tại đây">
                                <?php
                                if (!empty($errors['email'])) {
                                    echo '<div class="text-danger">' . $errors['email'] . '</div>';
                                }
                                ?>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
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