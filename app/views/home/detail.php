<?php include_once "includes/header.php" ?>
<?php
function formatVND($number)
{
    return number_format($number, 0, '', '.',) . 'đ';
}

function daysSinceComment($commentDate)
{
    // Ngày hiện tại
    $currentDate = new DateTime();

    // Ngày bình luận (chuyển đổi từ chuỗi ngày tháng sang đối tượng DateTime)
    $commentDate = new DateTime($commentDate);

    // Tính khoảng cách giữa hai ngày
    $interval = $currentDate->diff($commentDate);

    // Trả về số ngày
    return $interval->days;
}

// Tách các đường dẫn ảnh thành một mảng
$images = explode(',', $detailProduct['image']);
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
                            <span><?php echo $detailProduct['product_name'] ?></span>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>


<section class="py-5 bg-light section-detail">
    <div class="container my-5">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center">
                        <!-- Ảnh chính -->
                        <img id="mainImage" src="/uploads/<?php echo $images[0]; ?>" class="product-image11" alt="BDN Home Jersey">
                    </div>
                    <div class="col-12 mt-3 d-flex">
                        <!-- Ảnh nhỏ -->
                        <?php
                        for ($i = 0; $i < count($images); $i++) {
                            echo '<img src="/uploads/' . $images[$i] . '" class="product-image-small me-2 mx-2 border" alt="Additional Image" width="150">';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h2><?php echo $detailProduct['product_name'] ?></h2>
                <p><b>Hãng:</b> Đang cập nhật</p>
                <div class="mb-3">
                    <label for="size" class="form-label"><b>Size:</b></label>
                    <div id="size" class="d-flex size-option">
                        <?php
                        $sizes = explode(',', $detailProduct['size']);
                        foreach ($sizes as $s) {
                            echo '<input type="radio" name="size" id="size' . $s . '" value="' . $s . '">
                            <label for="size' . $s . '">' . $s . '</label>';
                        }
                        ?>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="mo-ta" class="form-label"><b>Mô tả:</b></label>
                    <p class="text-muted"><?php echo $detailProduct['description'] ?></p>
                </div>
                <div class="mb-3">
                    <label for="soluongtrongkhi"><b>Số lượng trong kho:</b> <span class="badge text-bg-danger"><?php echo $detailProduct['quantity'] ?></span>
                    </label>
                </div>
                <div class="mt-3">
                    <p><b>Giá tiền:</b><strong class="text-danger text-nowrap fs-5"> <?php echo formatVND($detailProduct['price']) ?></strong></p>
                    <form action="/add_to_cart" method="post">
                        <div class="d-flex">
                            <input type="hidden" name="product_id" value="<?php echo $detailProduct['id']; ?>">
                            <input type="hidden" name="user_id" value="<?php if (isset($_SESSION['user']['id']) && !empty($_SESSION['user']['id'])) {
                                                                            echo ($_SESSION['user']['id']);
                                                                        } ?>">
                            <input type="hidden" name="image" value="<?php echo $images[0]; ?>">
                            <input type="hidden" name="name" value="<?php echo $detailProduct['product_name']; ?>">
                            <input type="hidden" name="price" value="<?php echo $detailProduct['price']; ?>">
                            <input type="hidden" name="size" id="selectedSize" value="">
                            <label for="inputQuantity" class="form-label me-3 text-center"><b>Số lượng:</b></label>
                            <input type="hidden" name="storage" value="<?php echo $detailProduct['quantity']; ?>">
                            <input class="form-control text-center me-3" id="inputQuantity" name="quantity" type="number" min="1" max="<?php echo $detailProduct['quantity']; ?>" value="1" style="max-width: 70px" /><br>
                            <?php
                            if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
                                $error_message = $_SESSION['error'];
                                echo '<p class="text-danger">' . $error_message . '</p>';
                            
                                // Kiểm tra xem trang đã được tải lại chưa
                                if (isset($_SESSION['error_displayed'])) {
                                    unset($_SESSION['error']); // Unset thông báo lỗi sau khi trang được tải lại
                                    unset($_SESSION['error_displayed']); // Unset cờ sau khi xóa lỗi
                                } else {
                                    $_SESSION['error_displayed'] = true; // Đặt cờ để biết rằng trang đã hiển thị lỗi
                                }
                            }
                            ?>
                        </div>
                        <div>
                            <button class="btn btn-danger mt-3" type="submit">
                                Thêm Vào Giỏ Hàng <i class="bi bi-basket2"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.querySelectorAll('.product-image-small').forEach(function(image) {
        image.addEventListener('click', function() {
            document.getElementById('mainImage').src = this.src;
        });
    });

    document.querySelectorAll('input[name="size"]').forEach(function(sizeInput) {
        sizeInput.addEventListener('change', function() {
            document.getElementById('selectedSize').value = this.value;
        });
    });
</script>

<!-- Comments Section -->
<section>
    <div class="container px-4 px-lg-5 my-5">
        <h2 class="fw-bolder mb-4">Bình luận</h2>
        <?php if (!empty($comments)) : ?>
            <?php foreach ($comments as $comment) : ?>
                <div class="comment-card border">
                    <div class="comment-user">
                        <img src="https://www.hotelbooqi.com/wp-content/uploads/2021/12/128-1280406_view-user-icon-png-user-circle-icon-png.png" alt="Avatar" class="rounded-circle me-2" width="40" height="40">
                        <span><?php echo htmlspecialchars($comment['username']); ?></span>
                    </div>
                    <div class="comment-text">
                        <?php echo htmlspecialchars($comment['text']); ?>
                    </div>
                    <div class="comment-actions">
                        <a href="/delete-comment?id=<?php echo $comment['id'] ?>&product_id=<?php echo $detailProduct['id'] ?>">Xóa</a>
                        <a href="#">Trả lời</a>
                        <div class="comment-icon">
                            <span class="comment-time"><?php echo daysSinceComment($comment['date']) . ' ngày trước' ?></span>
                            <i class="bi bi-star-fill"></i>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>Chưa có bình luận nào.</p>
        <?php endif; ?>



        <h3 class="fw-bolder mt-4">Thêm bình luận</h3>
        <form action="/add-comment" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Tên của bạn</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Nhập tên của bạn" required>
            </div>
            <div class="mb-3">
                <label for="commentText" class="form-label">Bình luận của bạn</label>
                <textarea class="form-control" id="commentText" name="comment" rows="3" placeholder="Nhập bình luận..." required></textarea>
            </div>
            <input type="hidden" name="product_id" value="<?php echo $detailProduct['id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $_SESSION['user']['id'] ?? ''; ?>">
            <button type="submit" class="btn btn-primary">Gửi bình luận</button>
        </form>
    </div>
</section>
<!-- Related items section-->

<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Các sản phẩm tương tự</h2>

        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            $recommendProduct = $recommendProduct;

            foreach ($recommendProduct as $value) {
                // Tách chuỗi hình ảnh và lấy hình ảnh đầu tiên
                $pictures = explode(',', $value['image']);
                $firstImage = $pictures[0];
            ?>
                <div class="col mb-5">
                    <a href="/detail?id=<?php echo $value['id'] ?>" class="text-decoration-none text-black">
                        <div class="card h-100 border-0">
                            <img class="card-img-top" src="/uploads/<?php echo $firstImage ?>" alt="..." />
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <div class="star-rating" style="color: orange;">
                                        &#9733; &#9733; &#9733; &#9733; &#9733;
                                    </div>
                                    <h5 class="fw-bolder"><?php echo $value['product_name'] ?></h5>
                                    <?php echo formatVND($value['price']) ?>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<!-- ... -->
<?php include_once "includes/footer.php" ?>