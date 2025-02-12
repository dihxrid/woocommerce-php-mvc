<style>
    .payment-option {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        display: flex;
        align-items: center;
    }

    .payment-option input {
        margin-right: 10px;
    }

    .payment-option label {
        margin: 0;
    }
</style>
<?php
include_once "includes/header.php";
include_once "includes/navbar.php";

function formatVND($number)
{
    return number_format($number, 0, '', '.') . 'đ';
}

$total = 0;
$groupedProducts = [];
$product_names = [];
$product_size = [];

// Kiểm tra $_SESSION['cart'] và khởi tạo nếu không phải là mảng
$carts = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];

// Tính toán tổng tiền và thông tin sản phẩm
foreach ($carts as $productId => $product) {
    if (is_array($product)) {
        $groupedProducts[$productId] = [
            'product' => $product,
            'quantity' => $product['quantity'],
            'total_price' => $product['price'] * $product['quantity'],
            'size' => $product['size'],
        ];

        $total += $groupedProducts[$productId]['total_price'];
        $product_names[] = $product['name'];
        $product_size[] = $product['size'];
    }
}

// Kiểm tra xem có mã giảm giá trong session không
if (isset($_SESSION['coupon']) && isset($_SESSION['coupon']['discount_amount'])) {
    $discount_amount = $_SESSION['coupon']['discount_amount'];
    $total -= $discount_amount; // Áp dụng giảm giá
} else {
    $discount_amount = 0; // Không có giảm giá
}

echo "<pre>";
// var_dump($_SESSION);
// var_dump($total);
echo "</pre>";
?>
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
                            <span> Thanh toán </span>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<div class="container checkout-section" style="min-height: 34.25rem;">
    <div class="row">
        <div class="col-md-6">
            <h2>Xác nhận thanh toán</h2>
            <ul class="nav nav-tabs" id="checkoutTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="true">
                        <b>Thông tin đặt hàng</b>
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="checkoutTabsContent">
                <div class="tab-pane fade show active" id="address" role="tabpanel" aria-labelledby="address-tab">
                    <form class="mt-3" method="post" action="/payment?id=<?= htmlspecialchars($_GET['id']) ?>">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="firstName" name="full_name" required
                                placeholder="Nhập họ tên" minlength="2"
                                value="<?php echo isset($_SESSION['user']['full_name']) ? htmlspecialchars($_SESSION['user']['full_name']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="example@example.com"value="<?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="address" name="address" required
                                placeholder="Nhập địa chỉ"
                                value="<?php echo isset($_SESSION['user']['address']) ? htmlspecialchars($_SESSION['user']['address']) : ''; ?>">
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">Số điện thoại</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required
                                placeholder="Nhập số điện thoại" pattern="^0\d{9}$"
                                title="Số điện thoại phải gồm 10 chữ số và bắt đầu bằng số 0"
                                value="<?php echo isset($_SESSION['user']['phone']) ? htmlspecialchars($_SESSION['user']['phone']) : ''; ?>">
                        </div>

                        <input type="hidden" name="product_name" value="<?= htmlspecialchars(implode(', ', $product_names)) ?>">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['user']['id']) ?>">
                        <input type="hidden" name="total" value="<?= htmlspecialchars($total) ?>">
                        <input type="hidden" name="size" value="<?= htmlspecialchars(implode(', ', $product_size)) ?>">

                        <ul class="nav nav-tabs" id="checkoutTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab" aria-controls="address" aria-selected="true">
                                    <b>Phương thức thanh toán</b>
                                </button>
                            </li>
                        </ul>

                        <div class="mt-3">
                            <div class="d-block my-3">
                                <div class="custom-control custom-radio payment-option">
                                    <input id="credit" name="payment" type="radio" class="custom-control-input" value="cod" checked>
                                    <label class="custom-control-label" for="credit">
                                        <i class="bi bi-cash-stack"></i> Thanh toán khi nhận hàng
                                    </label>
                                </div>
                                <div class="custom-control custom-radio payment-option">
                                    <input id="debit" name="payment" type="radio" class="custom-control-input" value="vnpay">
                                    <label class="custom-control-label" for="debit">
                                        <i class="bi bi-qr-code"></i> VNPAY
                                    </label>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-dark">Tiến hành thanh toán</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Cart Summary -->
        <div class="col-md-6">
            <h2>Giỏ hàng</h2>
            <div class="card">
                <div class="card-body">
                    <?php foreach ($groupedProducts as $productInfo) : ?>
                        <?php $product = $productInfo['product']; ?>
                        <div class="d-flex justify-content-between">
                            <div>
                                <img src="/uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Product Image" class="img-fluid border" style="width: 50px;">
                                <span><?php echo htmlspecialchars($product['name']); ?></span><br>
                                <span class="text-muted d-block mt-2">Số lượng: <?php echo $productInfo['quantity']; ?></span>
                                <span class="text-muted d-block mt-2">Size: <?php echo $productInfo['product']['size']; ?></span>
                            </div>
                            <span class="text-muted d-block mt-2"><b><?php echo formatVND($productInfo['total_price']); ?></b></span>
                        </div>
                        <hr>
                    <?php endforeach; ?>
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">Giảm giá:</span>
                        <?php
                        if (isset($_SESSION['coupon'])) {
                            echo '<span class="text-muted">' . formatVND($_SESSION['coupon']['discount_amount']) . '</span>';
                        } else {
                            echo '<span class="text-muted">0đ</span>';
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="fw-semibold">Tổng cộng:</span>

                        <span class="text-muted"><?php echo formatVND($total) ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once "includes/footer.php"; ?>