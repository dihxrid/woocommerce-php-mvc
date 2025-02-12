<?php include_once "includes/header.php" ?>

<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h1>Quản lý đơn hàng</h1>
    <p>Chào mừng đến trang quản trị!</p>
    <table class="table table-bordered">
        <thead>
            <tr class="bg-primary text-white">
                <th>#</th>
                <th>ID khách hàng</th>
                <th>Tổng cộng</th>
                <th>Thời gian tạo</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            <?php
            function formatVND($number)
            {
                return number_format($number, 0, ',', '.') . ' đ';
            }
            foreach ($orders as $key => $value) {
                echo "<tr>";
                echo "<td>" . ($offset + $key + 1) . "</td>";
                echo "<td>" . $value['user_id'] . "</td>";
                echo "<td>" . formatVND($value['total']) . "</td>";
                echo "<td>" . $value['created_at'] . "</td>";
                if ($value['status'] == 1) {
                    echo '<td><span class="badge text-bg-warning">Chưa thanh toán</span></td>';
                } elseif ($value['status'] == 2) {
                    echo '<td><span class="badge text-bg-success">Đã thanh toán</span></td>';
                } else {
                    echo '<td><span class="badge text-bg-danger">Hủy thanh toán</span></td>';
                }
                echo "<td>
                 <a class='btn btn-danger' href='/admin/order/delete?id=$value[id]'><i class='bi bi-trash-fill'></i></a>
                 </td>";
                echo "</tr>";
            }
            if (empty($orders)) {
                echo "<tr>";
                echo "<td class='text-center' colspan='6'>Không có đơn hàng</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Hiển thị các nút phân trang -->
    <ul class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</main>

<?php include_once "includes/footer.php" ?>