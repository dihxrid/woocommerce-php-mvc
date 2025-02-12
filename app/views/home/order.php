<?php include_once "includes/header.php";
$bill = $bill;
?>
<!-- end header  -->
<section class="shop2 text-left">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="/" class="text-decoration-none" style="color: #dc3545;">
                            <span>Trang Chủ</span>
                        </a>
                        <span class="icon-arrow-right"> -> </span>
                    </li>
                    <li>
                        <strong>
                            <span> Lịch sử mua hàng </span>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="vieworder-section">
    <h1 class="text-center mb-5">Lịch sử mua hàng</h1>

    <!-- Table for desktop -->
    <div class="table-responsive d-none d-md-block">
        <table class="table table-striped">
            <thead class="text-center bg-white thead-bordered">
                <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">Họ tên</th>
                    <th class="text-center">Số điện thoại</th>
                    <th class="text-center">Địa chỉ</th>
                    <th class="text-center">ID đơn hàng</th>
                    <th class="text-center">Tên sản phẩm</th>
                    <th class="text-center">Kích cỡ</th>
                    <th class="text-center">Giá tiền</th>
                    <th class="text-center">Trạng thái</th>
                    <th class="text-center">Hành động</th>
                </tr>
            </thead>
            <tbody class="text-center bg-white">
                <?php
                function formatVND($number)
                {
                    return number_format($number, 0, ',', '.') . ' đ';
                }

                echo "<pre>";
                // var_dump($bills);
                echo "</pre>";
                foreach ($bill as $key => $value) {
                    echo "<tr>";
                    echo "<td class='text-center'>" . ($key + 1) . "</td>";
                    echo "<td class='text-center'>" . $value['full_name'] . "</td>";
                    echo "<td class='text-center'>" . $value['phone'] . "</td>";
                    echo "<td class='text-center'>" . $value['address'] . "</td>";
                    echo "<td class='text-center'>" . $value['order_id'] . "</td>";
                    echo "<td class='text-center'>" . $value['product_name'] . "</td>";
                    echo "<td class='text-center'>" . $value['size'] . "</td>";
                    echo "<td class='text-center'>" . formatVND($value['total']) . "</td>";
                    echo "<td class='text-center'>"
                        . ($value['status'] == 1 ? '<span class="badge text-bg-warning">Chưa thanh toán</span>' : ($value['status'] == 2 ? '<span class="badge text-bg-success">Đã thanh toán</span>' : '<span class="badge text-bg-danger">Hủy thanh toán</span>'))
                        . "</td>";
                    echo "<td>"
                        . ($value['status'] == 1 ? '<a class="btn btn-danger btn-sm" href="/cancel-order?id=' . $value['order_id']
                            . '"><i class="bi bi-trash-fill"></i></a>' : '')
                        . "
                    " . ($value['status'] != 1 ? '<a class="btn btn-primary btn-sm" href="/product"><i class="bi bi-arrow-counterclockwise"></i></a>' : '')
                        . ($value['status'] == 1 ? '<a class="btn btn-success btn-sm" href="/start-payment?id=' . $value['order_id'] . '"><i class="bi bi-credit-card"></i></a>' : '') . "</td>";
                    echo "</tr>";
                }
                if (empty($bill)) {
                    echo "<tr>";
                    echo "<td class='text-center' colspan='11'>Không tìm thấy đơn hàng</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Cards for mobile -->
    <div class="d-block d-md-none">
        <?php
        foreach ($bill as $key => $value) {
        ?>
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Đơn hàng #<?php echo $value['order_id']; ?></strong>
                    <button class="btn btn-link float-right toggle-details btn-sm" data-target="#order<?php echo $value['order_id']; ?>">Xem thêm</button>
                </div>
                <div class="card-body">
                    <p><strong>Họ tên:</strong> <?php echo $value['full_name']; ?></p>
                    <p><strong>Số điện thoại:</strong> <?php echo $value['phone']; ?></p>
                    <div id="order<?php echo $value['order_id']; ?>" class="details" style="display: none;">
                        <p><strong>Địa chỉ:</strong> <?php echo $value['address']; ?></p>
                        <p><strong>Tên sản phẩm:</strong> <?php echo $value['product_name']; ?></p>
                        <p><strong>Kích cỡ:</strong> <?php echo $value['size']; ?></p>
                        <p><strong>Giá tiền:</strong> <?php echo formatVND($value['total']); ?></p>
                        <p><strong>Trạng thái:</strong> <?php echo ($value['status'] == 1 ? '<span class="badge text-bg-warning">Chưa thanh toán</span>' : ($value['status'] == 2 ? '<span class="badge text-bg-success">Đã thanh toán</span>' : '<span class="badge text-bg-danger">Hủy thanh toán</span>')); ?></p>
                        <a class="btn btn-danger btn-sm" href="?id=<?php echo $value['id']; ?>"><i class="bi bi-x"></i> Hủy</a>
                        <a class="btn btn-primary btn-sm" href="/product"><i class="bi bi-arrow-return-left"></i> Mua lại</a>
                    </div>
                </div>
            </div>
        <?php
        }

        if (empty($bill)) {
        ?>
            <div class="alert alert-warning text-center" role="alert">
                Không tìm thấy đơn hàng
            </div>
        <?php
        }
        ?>
    </div>
</section>
<!-- start footer  -->
<?php include_once "includes/footer.php" ?>

<!-- JavaScript for toggle functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var toggleButtons = document.querySelectorAll('.toggle-details');

        toggleButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var target = document.querySelector(button.getAttribute('data-target'));
                if (target.style.display === 'none' || target.style.display === '') {
                    target.style.display = 'block';
                    button.textContent = 'Ẩn bớt';
                } else {
                    target.style.display = 'none';
                    button.textContent = 'Xem thêm';
                }
            });
        });
    });
</script>