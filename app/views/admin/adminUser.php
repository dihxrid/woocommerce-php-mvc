<?php include_once "includes/header.php" ?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h1>Quản lý người dùng</h1>
    <p>Chào mừng đến trang quản trị!</p>
    <a href="/admin/User/add" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Thêm người dùng</a>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-primary text-white">
                <th>#</th>
                <th>Username</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($users as $key => $value) {
                echo "<tr>";
                echo "<td>" . ($key +1) . "</td>";
                echo "<td>" . $value['username'] . "</td>";
                echo "<td>" . $value['email'] . "</td>";
                echo "<td>" . $value['phone'] . "</td>";
                echo "<td>
                <a class='btn btn-danger' href='/admin/User/delete?id=" . $value['id'] . "'><i class='bi bi-trash-fill'></i></a>
                
                </td>";
                echo "</tr>";
            }
            // <a class='btn btn-primary' href='/admin/User/update?id=" . $value['id'] . "'><i class='bi bi-pencil-square'></i></a>
            if(empty($users)) {
                echo "<tr>";
                echo "<td class='text-center' colspan='11'>Không tìm thấy người dùng</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</main>

<?php include_once "includes/footer.php" ?>