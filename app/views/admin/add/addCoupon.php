<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
';
?>

<div class="container mt-5">
    <h1 class="mb-4">Thêm Mã Giảm Giá</h1>
    <form action="/admin/coupon/addCoupon" method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="productName" class="form-label">Mã giảm giá:</label>
            <input name="code" type="text" class="form-control" id="productName" placeholder="Nhập mã giảm giá">
            <?php
            if (isset($errors['code'])) {
                echo '<p class="text-danger">' . $errors['code'] . '</p>';
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="productName" class="form-label">Số tiền giảm giá:</label>
            <input name="discount_amount" type="text" class="form-control" id="productName" placeholder="Nhập số tiền giảm giá">
            <?php
            if (isset($errors['discount_amount'])) {
                echo '<p class="text-danger">' . $errors['discount_amount'] . '</p>';
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="productName" class="form-label">Số lần sử dụng tối đa:</label>
            <input name="max_use" type="text" class="form-control" id="productName" placeholder="Nhập số lần sử dụng tối đa">
            <?php
            if (isset($errors['max_use'])) {
                echo '<p class="text-danger">' . $errors['max_use'] . '</p>';
            }
            ?>
        </div>
        <div class="mb-3">
            <label for="productName" class="form-label">Ngày kết thúc:</label>
            <input name="end_date" type="date" class="form-control" id="productName">
            <?php
            if (isset($errors['end_date'])) {
                echo '<p class="text-danger">' . $errors['end_date'] . '</p>';
            }
            if (isset($errors['db'])) {
                echo '<p class="text-danger">' . $errors['db'] . '</p>';
            }
            ?>
        </div>
        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm mã giảm giá</button>
        <a href="/admin/coupon" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Trở về trang quản trị</a>
    </form>
</div>