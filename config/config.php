<?php
#db
define('DB_HOST', 'localhost'); // Thay đổi tên máy chủ cơ sở dữ liệu nếu cần
define('DB_USER', 'root'); // Thay đổi tên người dùng cơ sở dữ liệu nếu cần
define('DB_PASS', ''); // Thay đổi mật khẩu cơ sở dữ liệu nếu cần
define('DB_NAME', 'phptt'); // Thay đổi tên cơ sở dữ liệu của bạn
#vnpay
define("VNPAY_TMN_CODE", "9FHQFJV7");
define("VNPAY_HASH_SECRET", "51CNF74EOXHO7VEELB0W6Z8P6PI8G4MZ");
define("VNPAY_URL", "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html");
define("VNPAY_RETURN_URL", "http://localhost:3000/vnpay_return");
#google login
define('CLIENT_ID', '');//config google
define('CLIENT_SECRET', '');
define('REDIRECT_URI', 'http://localhost:3000/login/google/callback');
?>
