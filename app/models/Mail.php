<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../../includes/vendor/autoload.php';

class Mail
{
    public function sendOrderConfirmation($to, $fullName, $orderDetails)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Thay bằng host SMTP của bạn
            $mail->SMTPAuth = true;
            $mail->Username = 'hoangdang3210@gmail.com'; // Thay bằng email của bạn
            $mail->Password = 'isdvfxcktveakgxp'; // Thay bằng mật khẩu email của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // Thay bằng port SMTP của bạn

            // Người gửi và người nhận
            $mail->setFrom('hoangdang3210@gmail.com', 'HoangSport');
            $mail->addAddress($to, $fullName);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'Xác nhận đơn hàng';
            $mail->Body = $this->createEmailBody($fullName, $orderDetails);
            $mail->AltBody = 'Đơn hàng đã được đặt thành công.';

            $mail->send();
            unset($_SESSION['coupon']);
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $mail->ErrorInfo];
        }
    }

    private function createEmailBody($fullName, $orderDetails)
    {
        // Hàm định dạng số tiền sang đơn vị VND
        function formatVND($number)
        {
            return number_format($number, 0, '.', '.') . ' đ';
        }

        // Tính tổng số tiền thanh toán
        $totalAmount = array_reduce($orderDetails, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);

        $coupon = isset($_SESSION['coupon']) ? $_SESSION['coupon'] : null;

        $total_final = $coupon ? $totalAmount - $coupon['discount_amount'] : $totalAmount;

        // Thiết lập locale cho tiếng Việt
        setlocale(LC_TIME, 'vi_VN.UTF-8');

        // Định dạng ngày giờ
        $formatter = new IntlDateFormatter(
            'vi_VN',
            IntlDateFormatter::FULL,
            IntlDateFormatter::NONE,
            'Asia/Ho_Chi_Minh',
            IntlDateFormatter::GREGORIAN,
            'EEEE, d MMMM yyyy \'lúc\' h:mm a'
        );
        $formattedDate = $formatter->format(new DateTime());

        $body = '<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Xác Nhận Đơn Hàng</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
            -webkit-text-size-adjust: none;
            width: 100% !important;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            color: #007bff;
        }
        .order-details {
            margin-top: 20px;
        }
        .order-title {
            margin-bottom: 10px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .text-right {
            text-align: right;
        }
        .total td {
            font-weight: bold;
        }
        .your-details {
            margin-top: 20px;
        }
        .fw-bold {
            font-weight: bold;
        }
        .share-section {
            margin-top: 20px;
            text-align: center;
            background-color: #28a745;
            padding: 20px;
            border-radius: 5px;
            color: #ffffff;
        }
        .share-section a {
            color: #ffffff;
            text-decoration: none;
            margin: 0 10px;
        }
        .account-button {
            margin-top: 20px;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
        }
        .order-footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Cảm ơn bạn, ' . htmlspecialchars($fullName) . '!</h1>
        </div>
        <div class="order-details">
            <div class="order-title">
                <h3>Đơn hàng của bạn</h3>
                <p>' . htmlspecialchars($formattedDate) . '</p>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng</th>
                        <th class="text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>';

foreach ($orderDetails as $detail) {
    $total = $detail['price'] * $detail['quantity'];
    $body .= '
                    <tr>
                        <td>' . htmlspecialchars($detail['product_name']) . '</td>
                        <td>' . htmlspecialchars($detail['quantity']) . '</td>
                        <td class="text-right">' . formatVND($total) . '</td>
                    </tr>';
}

$body .= '
                </tbody>
            </table>
            <div class="footer">
                <h4>Giảm giá:' .' '. formatVND($coupon['discount_amount']) . '</h4>
                <h4>Tổng:'.' '. formatVND($total_final) .'</h4>
            </div>
            <hr>
            <p>Bạn thấy có gì sai không? <a href="https://www.facebook.com/dihxrid">Hãy liên hệ chúng tôi</a> và chúng tôi sẽ sẵn sàng trợ giúp.</p>
        </div>
        <div class="share-section">
            <h3>Chia sẻ website chúng tôi đến bạn bè của bạn</h3>
            <p>Chia sẻ URL duy nhất của bạn với bạn bè và mỗi khi họ đăng ký, bạn sẽ nhận được mã giảm giá đặc biệt</p>
        </div>
        <div class="account-button">
            <a href="http://localhost:3000/product" class="btn" style="color:#fff; text-decoration: none;">Trở lại mua hàng</a>
        </div>
        <div class="order-footer">
            <p>Cảm ơn bạn vì đã là một khách hàng tuyệt vời.</p>
        </div>
    </div>
</body>
</html>';

        return $body;
    }


    public function sendUser($to, $subject, $username, $password)
{
    $mail = new PHPMailer(true);
    try {
        $mail->CharSet = 'UTF-8';
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'hoangdang3210@gmail.com';
        $mail->Password = 'isdvfxcktveakgxp';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('hoangdang3210@gmail.com', 'HoangSport');
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "
            Xin Chào <b>$username</b>,<br><br>
            Tài khoản của bạn đã được tạo thành công.<br>
            Tên đăng nhập: <b>$username</b><br>
            Mật khẩu: <b>$password</b> (Vui lòng thay đổi mật khẩu sau khi đăng nhập)<br><br>
            Chúc bạn có một trải nghiệm tuyệt vời!<br><br>
            Trân trọng,<br>Địa chỉ: 106 Hoàng Tăng Bí, Hoà An, Cẩm Lệ, Đà Nẵng.
        ";

        $mail->send();
        return ['success' => true];
    } catch (Exception $e) {
        return ['success' => false, 'error' => $mail->ErrorInfo];
    }
}

    public function sendOtpMail($to, $otp)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'hoangdang3210@gmail.com';
            $mail->Password = 'isdvfxcktveakgxp';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Người gửi và người nhận
            $mail->setFrom('hoangdang3210@gmail.com', 'HoangSport');
            $mail->addAddress($to);

            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = 'OTP HoangSport';
            $mail->Body = 'OTP của bạn là:' . $otp;
            $mail->AltBody = 'Mã OTP của bạn là: ' . $otp;

            $mail->send();
            return ['success' => true];
        } catch (Exception $e) {
            return ['success' => false, 'error' => $mail->ErrorInfo];
        }
    }


    public function contact($data)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->CharSet = 'UTF-8';
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Thay bằng host SMTP của bạn
            $mail->SMTPAuth = true;
            $mail->Username = 'hoangdang3210@gmail.com'; // Thay bằng email của bạn
            $mail->Password = 'isdvfxcktveakgxp'; // Thay bằng mật khẩu email của bạn
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            //Recipients
            $mail->setFrom(''. $data['email'] . '', ''. $data['name'] . '');
            $mail->addAddress('hoangdang3210@gmail.com', 'Dinh Hoang');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Liên hệ mới: ' . $data['subject'];
            $mail->Body    = "Tên: {$data['name']}<br>Email: {$data['email']}<br><br>Tin nhắn:<br>{$data['message']}";
            $mail->AltBody = "Tên: {$data['name']}\nEmail: {$data['email']}\n\nTin nhắn:\n{$data['message']}";

            $mail->send();
            echo 'Email đã được gửi thành công';
            return ['success' => true];
        } catch (Exception $e) {
            echo "Email không thể gửi được. Lỗi: {$mail->ErrorInfo}";
            return ['success' => false, 'error' => $mail->ErrorInfo];
        }
    }
}
