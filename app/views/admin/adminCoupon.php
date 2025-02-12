<?php include_once "includes/header.php" ?>
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h1>Quản lý mã giảm giá</h1>
    <p>Chào mừng đến trang quản trị!</p>
    <a href="/admin/coupon/add" class="btn btn-primary mb-3"><i class="bi bi-plus-circle"></i> Thêm mã giảm giá</a>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-primary text-white text-center">
                <th>#</th>
                <th>Mã giảm giá</th>
                <th>Số tiền giảm giá</th>
                <th>Số lần sử dụng tối đa</th>
                <th>Ngày tạo</th>
                <th>Ngày kết thúc</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function formatVND($number)
            {
                return number_format($number, 0, ',', '.') . 'đ';
            }

            function formatDate($date)
            {
                return date('d/m/Y', strtotime($date));
            }

            // $coupon = $coupon;

            foreach ($coupon as $key => $value) {
                echo "<tr class='text-center'>";
                echo "<td>" . ($key + 1) . "</td>";
                echo "<td>" . $value['code'] . "</td>";
                echo "<td>" . formatVND($value['discount_amount']) . "</td>";
                echo "<td>" . $value['max_uses'] . "</td>";
                echo "<td>" . formatDate($value['created_at']) . "</td>";
                echo "<td>" . formatDate($value['end_date']) . "</td>";
                echo "<td>
                <a href='/admin/coupon/update/" . $value['id'] . "' class='btn btn-success btn-sm'><i class='bi bi-pencil-square'></i> Sửa</a> 
                <a href='/admin/coupon/delete?id=" . $value['id'] . "' class='btn btn-danger btn-sm'><i class='bi bi-trash'></i> Xóa</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</main>
<?php include_once "includes/footer.php" ?>