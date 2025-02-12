<?php include_once "includes/header.php";
if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] != "admin") {
    header("Location: /");
}
$db = new Count();
$data = $db->getChart();

// Chuẩn bị dữ liệu doanh thu hàng ngày
$dailyRevenue = [];

foreach ($data as $row) {
    $day = $row['day'];
    $revenue = $row['total_revenue'];

    $dailyRevenue[$day] = $revenue; // Ghi nhận doanh thu hàng ngày
}

// Tạo nhãn và dữ liệu cho biểu đồ
$dailyLabels = array_keys($dailyRevenue);
$dailyData = array_values($dailyRevenue);
$dailyJson = json_encode(['labels' => $dailyLabels, 'data' => $dailyData]);
// var_dump($dailyData);
?>





<style>
    .card-custom .card-body {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-custom .icon {
        font-size: 2rem;
        padding: 10px 25px;
        border-radius: 10px;
    }
</style>
<!-- Main Content -->
<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <div class="container-fluid" style="height: 150px;">
        <h1 class="h2">Trang chủ</h1>
        <div class="row">
            <div class="col-md-4 h-100">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-success text-white">
                                <i class="bi bi-cart"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title mb-0">Số đơn hàng</h5>
                                <?php
                                $countBill = $db->countBill();
                                echo '<p class="card-text text-muted mt-2">' . $countBill . ' đơn</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 h-100">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-info text-white">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title mb-0">Số thành viên</h5>
                                <?php
                                $countUser = $db->countUser();
                                echo '<p class="card-text text-muted mt-2">' . $countUser . ' người</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 h-100">
                <div class="card card-custom">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="icon bg-danger text-white">
                                <i class="bi bi-currency-dollar"></i>
                            </div>
                            <div class="ms-3">
                                <h5 class="card-title mb-0">Tổng doanh thu</h5>
                                <?php
                                function formatVND($number)
                                {
                                    return number_format($number, 0, ',', '.') . ' đ';
                                }
                                $countTotal = $db->countTotal();
                                echo '<p class="card-text text-muted mt-2">' . formatVND($countTotal) . '</p>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="mt-5 chartjs">
        <h3 class="text-center">Bộ dữ liệu doanh thu</h3>
        <div class="border p-3"><canvas id="revenueChart"></canvas></div>
    </section>
</main>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var dailyData = <?php echo $dailyJson; ?>;

        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'bar', // Bạn có thể thay đổi 'bar' thành 'line' nếu muốn biểu đồ đường
            data: {
                labels: dailyData.labels, // Hiển thị nhãn ngày tháng
                datasets: [{
                    label: 'Doanh thu hàng ngày',
                    data: dailyData.data,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?php include_once "includes/footer.php" ?>