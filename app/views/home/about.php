<?php include_once "includes/header.php" ?>

<!-- start about  -->
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
                            <span> Về chúng tôi </span>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="about-section">
    <section class="bg-light py-5">
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-md-8">
                    <h1>Về Chúng Tôi</h1>
                    <p class="lead mb-0 text-muted" id="about">
                        Chào mừng bạn đến với SHOP MALL, điểm đến lý tưởng cho những ai đam mê thể thao và phong
                        cách sống năng động! Tại SHOP MALL, chúng tôi tự hào mang đến cho khách hàng những sản phẩm
                        thể thao chất lượng cao, đa dạng và phong phú.
                    </p>
                </div>
                <div class="col-md-4">
                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSJ9OItwYmGuAQ2LDNYs0RHNitGd_JXkCWj5A&s">
                </div>
            </div>
        </div>
    </section>

    <section class="container py-5">
        <div class="row text-center">
            <div class="col-lg-6 m-auto">
                <h1 id="h1_our">Dịch Vụ Của Chúng Tôi</h1>
                <p id="p_our">
                    Chúng tôi cam kết mang đến trải nghiệm mua sắm tốt nhất, từ việc giao hàng nhanh chóng, chính
                    sách đổi trả linh hoạt
                    đến các chương trình khuyến mãi hấp dẫn và dịch vụ hỗ trợ 24/7. Khám phá các dịch vụ của chúng
                    tôi để thấy sự khác biệt!
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 service-item bg-light rounded p-4" onclick="toggleContent('content1')">
                    <div class="h1 text text-center">
                        <i class="fa fa-truck fa-lg"></i>
                    </div>
                    <h2 class="mt-4 text-center">Dịch vụ giao hàng</h2>
                    <div id="content1" class="service-content">
                        <p class="text-center">Chúng tôi cung cấp dịch vụ giao hàng nhanh chóng và tiện lợi đến mọi
                            nơi.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 service-item bg-light rounded p-4" onclick="toggleContent('content2')">
                    <div class="h1 text text-center">
                        <i class="fa-solid fa-right-left"></i>
                    </div>
                    <h2 class="mt-4 text-center">Mua sắm & Trả lại</h2>
                    <div id="content2" class="service-content">
                        <p class="text-center">Chính sách mua sắm và trả lại linh hoạt, đảm bảo quyền lợi khách
                            hàng.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 service-item bg-light rounded p-4" onclick="toggleContent('content3')">
                    <div class="h1 text text-center">
                        <i class="fa-solid fa-percent"></i>
                    </div>
                    <h2 class="mt-4 text-center">Khuyến mãi</h2>
                    <div id="content3" class="service-content">
                        <p class="text-center">Nhiều chương trình khuyến mãi hấp dẫn dành cho khách hàng thân thiết.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3 pb-5">
                <div class="h-100 service-item bg-light rounded p-4" onclick="toggleContent('content4')">
                    <div class="h1 text text-center">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    <h2 class="mt-4 text-center">Hỗ trợ 24/7</h2>
                    <div id="content4" class="service-content">
                        <p class="text-center">Dịch vụ hỗ trợ khách hàng 24/7, luôn sẵn sàng giải đáp mọi thắc mắc.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about  -->


    <?php include_once "includes/footer.php" ?>