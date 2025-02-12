<?php
echo '
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
';
?>

<div class="container mt-5">
    <h1 class="mb-4">Thêm Người Dùng</h1>
    <form action="/admin/User/addUser" method="post">
        <!-- Tên người dùng -->
        <div class="mb-3">
            <label for="username" class="form-label">Tên Người Dùng</label>
            <input name="username" type="text" class="form-control" id="username" placeholder="Nhập tên người dùng">
            <?php
            if (isset($errors['username'])) {
                echo '<p class="text-danger">' . $errors['username'] . '</p>';
            }
            ?>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input name="email" type="email" class="form-control" id="email" placeholder="Nhập email">
            <?php
            if (isset($errors['email'])) {
                echo '<p class="text-danger">' . $errors['email'] . '</p>';
            }
            ?>
        </div>

        <!-- Vai trò (Role) -->
        <div class="mb-3">
            <label for="role" class="form-label">Vai Trò</label>
            <select name="role" class="form-select" id="role">
                <option value="user" selected>Người dùng</option>
                <option value="admin">Quản trị viên</option>
            </select>
            <?php
            if (isset($errors['role'])) {
                echo '<p class="text-danger">' . $errors['role'] . '</p>';
            }
            ?>
        </div>

        <!-- Nút gửi -->
        <button type="submit" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Thêm Người Dùng</button>
        <a href="/admin/User" class="btn btn-danger"><i class="bi bi-arrow-left-circle"></i> Trở Về Trang Quản Trị</a>
    </form>
</div>

