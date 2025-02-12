<footer class="footer mt-5">
    <div class="container">
        <div class="mid-footer row">
            <div class="footer-left col-xs-12 col-md-4 col-lg-5">
                <a href="/" class="logo" title="Logo">
                    <img width="88" height="37" src="//bizweb.dktcdn.net/100/483/998/themes/904984/assets/logo.png?1720275862057" alt="Hang Thể Thao">
                </a>
                <p>
                    Khách hàng có nhu cầu IN TÊN SỐ, đặt đội hoặc mua số lượng lớn từ 7 bộ vui lòng inbox để SHOP hỗ
                    trợ với giá tốt nhất cùng nhiều ưu đãi quà tặng đặc biệt
                </p>
            </div>
            <div class="footer-center col-xs-12 col-sm-6 col-md-4 col-lg-5">
                <h4>
                    Hỗ Trợ Khách Hàng
                </h4>
                <ul class="ul_menu_fot">

                    <li>
                        <a href="/chinh-sach" title="Chính sách bảo mật">Chính sách bảo mật</a>
                    </li>

                    <li>
                        <a href="/coc-giu-nhiet" title="Cốc Giữ Nhiệt">Cốc Giữ Nhiệt</a>
                    </li>

                    <li>
                        <a href="/gioi-thieu" title="Liên hệ">Liên hệ</a>
                    </li>

                    <li>
                        <a href="/pre-order" title="Pre Order">Pre Order</a>
                    </li>

                    <li>
                        <a href="#" title="Hỗ trợ trực tiếp">Hỗ trợ trực tiếp</a>
                    </li>

                </ul>
            </div>
            <div class="footer-right col-xs-12 col-sm-6 col-md-4 col-lg-2">
                <ul class="footer-contact">
                    <li>
                        <i class="bi bi-telephone-fill"></i>
                        <p>
                            0555 555 555
                        </p>
                    </li>
                    <li>
                        <i class="bi bi-globe"></i>
                        <p>
                            https://hangsport.online
                        </p>
                    </li>
                    <li>
                        <i class="bi bi-facebook"></i>
                        <a href="https://Fb.com/hangthethao88" class="text-decoration-none text-white">fb.com/hangsport88</a>
                    </li>
                    <li>
                        <i class="bi bi-envelope"></i>
                        <p>
                            shop@hangsport.com
                        </p>
                    </li>
                </ul>
            </div>

        </div>
        <div class="copyright">
            Hangsport copyright © 2024
        </div>
    </div>
</footer>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    function openNav() {
        document.getElementById("mySidenav").style.width = "250px";
    }

    function closeNav() {
        document.getElementById("mySidenav").style.width = "0";
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliderContainers = document.querySelectorAll('.slider-container');

        sliderContainers.forEach(container => {
            const prevButton = container.querySelector('.slider-button-prev');
            const nextButton = container.querySelector('.slider-button-next');
            const sliderWrapper = container.querySelector('.slider-wrapper');
            const slides = container.querySelectorAll('.slider-slide');
            const slideWidth = slides[0].getBoundingClientRect().width + parseInt(window.getComputedStyle(slides[0]).marginRight); // Include margin-right in calculation
            const totalSlides = slides.length;
            let slidesToShow = 4; // Default number of slides visible at once
            let currentIndex = 0;

            // Adjust slidesToShow based on screen size
            const updateSlidesToShow = () => {
                const screenWidth = window.innerWidth;
                if (screenWidth < 576) {
                    slidesToShow = 1; // 1 slide for very small screens
                } else if (screenWidth < 768) {
                    slidesToShow = 2; // 2 slides for small screens
                } else if (screenWidth < 992) {
                    slidesToShow = 3; // 3 slides for medium screens
                } else {
                    slidesToShow = 4; // 4 slides for larger screens
                }
                updateSliderPosition();
            };

            function updateSliderPosition() {
                const offset = -currentIndex * slideWidth;
                sliderWrapper.style.transform = `translateX(${offset}px)`;
            }

            nextButton.addEventListener('click', () => {
                if (currentIndex < totalSlides - slidesToShow) {
                    currentIndex++;
                } else {
                    currentIndex = 0;
                }
                updateSliderPosition();
            });

            prevButton.addEventListener('click', () => {
                if (currentIndex > 0) {
                    currentIndex--;
                } else {
                    currentIndex = totalSlides - slidesToShow;
                }
                updateSliderPosition();
            });

            window.addEventListener('resize', updateSlidesToShow); // Update slidesToShow on window resize

            updateSlidesToShow();
        });
    });
</script>

</body>

</html>