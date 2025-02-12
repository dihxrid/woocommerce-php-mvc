<?php include_once "includes/header.php" ?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h1>Quản lý danh mục</h1>
    <p>Chào mừng đến trang quản trị!</p>
    <a href="/admin/category/add" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Thêm danh mục</a>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-primary text-white">
                <th>#</th>
                <th>Tên danh mục</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($categories as $key => $value) {
                echo "<tr>";
                echo "<td>" .($key+1) . "</td>";
                echo "<td>" . $value['name'] . "</td>";
                echo "<td><img width='100' height='100' src='../uploads/$value[image]' alt='anh'></td>";
                echo "<td>
                 <a class='btn btn-danger' href='/delete-category?id=$value[id]'><i class='bi bi-trash-fill'></i></a>
                 <a class='btn btn-primary' href='/admin/category/update?id=$value[id]'><i class='bi bi-pencil-square'></i></a>
                 </td>";
                echo "</tr>";
            }
            if(empty($categories)) {
                echo "<tr>";
                echo "<td class='text-center' colspan='11'>Không tìm thấy danh mục</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</main>


<?php include_once "includes/footer.php" ?>