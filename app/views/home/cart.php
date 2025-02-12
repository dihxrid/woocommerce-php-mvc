<?php
include_once "includes/header.php"; ?>
<style>
    .coupon-form {
        display: flex;
        gap: 10px;
    }

    .coupon-form .form-control,
    .coupon-form .btn {
        height: 100%;
        padding: 10px;
    }

    .coupon-form .form-control {
        flex: 1;
    }

    .coupon-form .btn {
        flex: none;
        border: none;
    }
</style>
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
                            <span> Giỏ hàng </span>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="yourcart-section">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Giỏ hàng</h2>
                <hr>
                <?php
                echo "<pre>";
                // var_dump($_SESSION['cart']);
                echo "</pre>";
                function formatVND($number)
                {
                    return number_format($number, 0, '', '.') . 'đ';
                }

                if (isset($_SESSION['cart'])) {
                    $carts = $_SESSION['cart'];
                } else {
                    $carts = null;
                }

                if ($carts) {
                    foreach ($carts as $cart) {
                ?>
                        <div class="cart-item">
                            <div class="image-placeholder">
                                <img src="/uploads/<?php echo $cart['image'] ?>" width="100" height="100" alt="Product Image">
                            </div>
                            <div class="item-details">
                                <h5><?php echo $cart['name'] ?></h5>
                                <p>Số lượng: <?php echo $cart['quantity'] ?></p>
                                <p>Size: <?php echo $cart['size'] ?></p>
                            </div>
                            <div class="item-price">
                                <p><?php echo formatVND($cart['price']) ?></p>
                                <a href="/delete-cart?id=<?php echo $cart['id'] ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo '<p class="text-center">Giỏ hàng trống</p>';
                }
                ?>
            </div>
            <div class="col-md-4">
                <div class="order-summary">
                    <h4>Tóm tắt đơn hàng</h4>
                    <form action="/active-coupon" method="post" class="coupon-form">
                        <input type="text" name="code" class="form-control" placeholder="Nhập mã giảm giá ở đây">
                        <button type="submit" class="btn btn-dark">Áp dụng</button>
                    </form>
                    <div class="d-flex justify-content-between mt-3">
                        <p>Tổng phụ:</p>
                        <p><?php
                            $subtotal = 0;
                            $carts = isset($_SESSION['cart']) && is_array($_SESSION['cart']) ? $_SESSION['cart'] : [];
                            foreach ($carts as $cart) {
                                $subtotal += $cart['price'] * $cart['quantity'];
                            }
                            echo formatVND($subtotal);
                            ?></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>Giảm giá:</p>
                        <?php
                        if (isset($_SESSION['coupon'])) {
                            $subtotal -= $_SESSION['coupon']['discount_amount'];
                            echo '<p>' . formatVND($_SESSION['coupon']['discount_amount']) . '</p>';
                        } else {
                            echo '<p>0đ</p>';
                        }
                        ?>
                    </div>
                    <div class="d-flex justify-content-between total">
                        <p>Tổng cộng:</p>
                        <p><?php
                            echo formatVND($subtotal);
                            ?></p>
                    </div>
                    <form action="/add-order?id=<?php echo isset($_SESSION['user']['id']) ? $_SESSION['user']['id'] : 'No user ID found'; ?>" method="post">
                        <?php
                        foreach ($carts as $index => $cart) {
                        ?>
                            <input type="hidden" name="carts[<?php echo $index; ?>][product_id]" value="<?php echo $cart['product_id']; ?>">
                            <input type="hidden" name="carts[<?php echo $index; ?>][name]" value="<?php echo $cart['name']; ?>">
                            <input type="hidden" name="carts[<?php echo $index; ?>][quantity]" value="<?php echo $cart['quantity']; ?>">
                            <input type="hidden" name="carts[<?php echo $index; ?>][price]" value="<?php echo $cart['price']; ?>">
                            <input type="hidden" name="carts[<?php echo $index; ?>][size]" value="<?php echo $cart['size']; ?>">
                        <?php
                        }
                        if (empty($carts)) {
                            echo "<p class='text-center'>Giỏ hàng trống</p>";
                        }
                        ?>
                        <button class="btn btn-dark" type="submit">Tiếp tục đến trang thanh toán <i class="bi bi-arrow-right"></i></button>
                        <a href="/product" class="btn btn-danger mt-2"><i class="bi bi-arrow-left"></i> Quay lại mua hàng</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once "includes/footer.php" ?>