<?php include_once "includes/header.php" ?>
<!-- end header  -->
<!-- start contact  -->
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
                            <span> Liên hệ </span>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section class="contact-section">
    <div class="contact-header">
        <h1 class="text-center mt-5">Contact</h1>
        <p class="text-center">
            Bạn muốn khiếu nại gì ở đây!.
        </p>
        <!-- thêm Map -->
        <div id="map"></div>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&v=weekly"></script>
    </div>
    </div>
</section>
<section>
    <div class="container py-5">
        <div class="row py-5">
            <form class="col-md-9 m-auto" method="post" role="form" action="/contact-form">
                <div class="row">
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputname">Name</label>
                        <input type="text" class="form-control mt-1" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6 mb-3">
                        <label for="inputemail">Email</label>
                        <input type="email" class="form-control mt-1" id="email" name="email"
                            placeholder="Email">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="inputsubject">Subject</label>
                    <input type="text" class="form-control mt-1" id="subject" name="subject"
                        placeholder="Subject">
                </div>
                <div class="mb-3">
                    <label for="inputmessage">Message</label>
                    <textarea class="form-control mt-1" id="message" name="message" placeholder="Message"
                        rows="8"></textarea>
                </div>
                <div class="row">
                    <div class="col text-end mt-2">
                        <button type="submit" class="btn btn-success btn-lg px-3">Let’s Talk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<!-- end contact  -->
<?php include_once "includes/footer.php" ?>