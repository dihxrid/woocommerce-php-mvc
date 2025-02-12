<?php include_once "includes/header.php" ?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h1>Quản lý sản phẩm</h1>
    <p>Chào mừng đến trang quản trị!</p>
    <a href="/admin/product/add" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Thêm sản phẩm</a>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-primary text-white">
                <th>#</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Danh mục</th>
                <!-- <th>Mô tả sản phẩm</th> -->
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function formatVND($number){
                return number_format($number, 0, '', '.',) . 'đ';
            }
            foreach ($products as $key => $value) {
                echo "<tr>";
                echo "<td>" . ($key+1) . "</td>";
                echo "<td>" . $value['product_name'] . "</td>";
                echo "<td><img width='100' height='100' src='../uploads/$value[image]' alt='anh'></td>";
                echo "<td>" . formatVND($value['price']) . "</td>";
                echo "<td>" . $value['quantity'] . "</td>";
                echo "<td>" . $value['category_name'] . "</td>";
                // echo "<td>" . $value['description'] . "</td>";
                echo "<td>
                <a class='btn btn-danger' href='/admin/product/delete?id=$value[id]'><i class='bi bi-trash-fill'></i></a>
                <a class='btn btn-primary' href='/admin/product/update?id=$value[id]'><i class='bi bi-pencil-square'></i></a>
                </td>";
                echo "</tr>";
            }
            if(empty($products)) {
                echo "<tr>";
                echo "<td class='text-center' colspan='11'>Không tìm thấy sản phẩm</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <!-- Hiển thị các nút phân trang -->
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</main>


<?php include_once "includes/footer.php" ?>