<?php include_once "includes/header.php" ?>
<section class="section-1">
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
            </div>
            <div class="carousel-inner" style="z-index: -1;">
                <div class="carousel-item active">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_1.jpg?1720275862057" class="d-block w-100 desktop-img" alt="...">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_1.png?1717181462123" class="d-block w-100 mobile-img" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_2.jpg?1722078914172" class="d-block w-100 desktop-img " alt="...">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_2.png?1717181462123" class="d-block w-100 mobile-img" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_3.jpg?1722078914172" class="d-block w-100 desktop-img" alt="...">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_3.png?1717181462123" class="d-block w-100 mobile-img" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/slider_4.jpg?1722078914172" class="d-block w-100 desktop-img" alt="...">
                    <img src="https://bizweb.dktcdn.net/100/483/998/themes/904984/assets/silde_m_4.png?1717181462123" class="d-block w-100 mobile-img" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
</section>

<section class="section-2 mt-5">
    <div class="container">
        <div class="row">
            <?php
            $danhmuc = $danhmuc;
            foreach ($danhmuc as $value) {
            ?>
                <div class="col-md-4">
                    <div class="product-card">
                        <div class="product-info">
                            <h3><?php echo $value['name'] ?></h3>
                            <p>Áo bóng đá, giày bóng đá, tất bóng đá,...</p>
                            <a href="/product?id=<?php echo $value['id'] ?>" class="btn btn-custom">Mua Ngay</a>
                        </div>
                        <div class="product-image">
                            <img src="/uploads/<?php echo $value['image'] ?>" alt="Đồ bóng đá">
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>
<?php
// var_dump($_SESSION);
?>
<section class="section-3 mt-5">
    <div class="container">
        <div class="row">
            <?php
            function formatVND($number)
            {
                return number_format($number, 0, '', '.',) . 'đ';
            }
            $danhmuc = $danhmuc;
            foreach ($danhmuc as $category) {
                $categoryId = $category['id'];
                $categoryName = $category['name'];
                $product = new Product();
                $products = $product->selectByCategory($categoryId);
            ?>
                <div class="col-md-12 mb-4">
                    <h2><?php echo $categoryName ?></h2>


                    <div class="slider-container">
                        <div class="slider-wrapper">
                            <?php
                            foreach ($products as $product) {
                                $images = explode(',', $product['image']);
                                $firstImage = $images[0]; // Bức ảnh đầu tiên
                            ?>
                                <div class="slider-slide">
                                    <a href="/detail?id=<?php echo $product['id'] ?>" class="text-decoration-none text-black">
                                        <div class="card border-0">
                                            <img src="/uploads/<?php echo $firstImage ?>" class="border">
                                            <div class="card-body">
                                                <div class="rating">
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star checked"></span>
                                                    <span class="fa fa-star"></span>
                                                </div>
                                                <p class="card-title text-left"><?php echo $product['product_name'] ?></p>
                                                <p class="card-text text-left"><span class="text-decoration-line-through">300.000đ</span>
                                                    <span class="text-danger"><?php echo formatVND($product['price']) ?></span>
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                        <!-- điều hướng -->
                        <button class="slider-button-prev">❮</button>
                        <button class="slider-button-next">❯</button>
                    </div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</section>

<section class="section-6 mt-5">
    <div class="home-two-banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 content_banner">
                    <div class="title_banner">
                        <h3>
                            ĐẶT IN ÁO LIÊN HỆ NGAY
                        </h3>
                        <span>Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox
                            để SHOP hỗ trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt</span>
                    </div>

                    <div class="group-banner">
                        <a class="banner-1" href="#" title="ĐẶT IN ÁO LIÊN HỆ NGAY">
                            <img class="img-responsive lazyload loaded" src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_1.png?1720275862057" data-src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_1.png?1720275862057" width="350" height="204" alt="Handmade" data-was-processed="true">
                        </a>
                        <div class="des">
                            <a href="#" class="lien-he btn btn-danger mb-4 btn-lg" title="Xem thêm">Liên hệ ngay</a>
                            <p>Hỗ trợ, tư vấn ngay qua messenger FB hoặc qua SĐT: 0987654321
                            </p>
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 content_banner_2">
                    <a href="#" title="">
                        <img class="img-responsive lazyload loaded" src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_2.png?1720275862057" data-src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/twobanner_2.png?1720275862057" alt="Hang Thể Thao" data-was-processed="true" width="100%">
                    </a>

                </div>
            </div>
        </div>
    </div>
</section>

<?php include_once "includes/footer.php" ?>