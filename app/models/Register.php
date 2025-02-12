<?php
include_once __DIR__ . '/../../includes/database.php';
require_once __DIR__ . '/../../google/vendor/autoload.php';
class LoginRegister
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = db_connect();
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
    public function register($data)
    {
        include_once __DIR__ . '/../../app/models/Mail.php';
        session_start();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Kiểm tra sự tồn tại của username và email
                $checkSql = "SELECT username, email FROM users WHERE username = ? OR email = ?";
                $stmt = $this->db->prepare($checkSql);
                $stmt->execute([$data['username'], $data['email']]);
                $existingUser = $stmt->fetch(PDO::FETCH_ASSOC);

                $errors = [];
                if ($existingUser) {
                    if ($existingUser['username'] == $data['username']) {
                        $errors['username'] = "Username đã tồn tại!";
                    }
                    if ($existingUser['email'] == $data['email']) {
                        $errors['email'] = "Email đã tồn tại!";
                    }
                    return ['success' => false, 'errors' => $errors];
                }

                $otp = rand(100000, 999999);

                // Thêm người dùng mới vào cơ sở dữ liệu
                $sql = "INSERT INTO users (username, email, phone, password,otp) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $data['username'],
                    $data['email'],
                    $data['phone'],
                    password_hash($data['password'], PASSWORD_DEFAULT),
                    $otp
                ]);

                // Gửi email với mã OTP
                $mail = new Mail();
                $emailSent = $mail->sendOtpMail($data['email'], $otp);

                if ($emailSent) {
                    // Nếu gửi email thành công, chuyển hướng đến trang OTP
                    header('Location: /otp-register');
                    exit();
                } else {
                    // Nếu gửi email thất bại, hiển thị thông báo lỗi
                    return ['success' => false, 'errors' => ['email' => 'Không thể gửi OTP qua email.']];
                }
            } catch (PDOException $e) {
                return ['success' => false, 'errors' => ['db' => "Lỗi khi thêm người dùng: " . $e->getMessage()]];
            } catch (Exception $e) {
                return ['success' => false, 'errors' => ['general' => "Lỗi: " . $e->getMessage()]];
            }
        }

        return ['success' => false, 'errors' => ['general' => 'Phương thức yêu cầu không hợp lệ']];
    }




    // public function login($data)
    // {
    //     $errors = [];

    //     if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //         if (empty($data['username'])) {
    //             $errors['username'] = "Username không được để trống!";
    //         }

    //         if (empty($data['password'])) {
    //             $errors['password'] = "Password không được để trống!";
    //         }
    //     }

    //     if (empty($errors)) {
    //         try {
    //             $sql = "SELECT * FROM users WHERE username = ?";
    //             $stmt = $this->db->prepare($sql);

    //             if ($stmt) {
    //                 $stmt->execute([$data['username']]);
    //                 $user = $stmt->fetch(PDO::FETCH_ASSOC);

    //                 if ($user) {
    //                     if (password_verify($data['password'], $user['password'])) {
    //                         $_SESSION['user'] = $user;
    //                         return ['success' => true, 'user' => $user];
    //                     } else {
    //                         $errors['login'] = "Password không đúng!";
    //                     }
    //                 } else {
    //                     $errors['login'] = "Không tìm thấy người dùng với username này!";
    //                 }
    //             } else {
    //                 $errors['db'] = "Lỗi chuẩn bị câu lệnh SQL.";
    //             }
    //         } catch (PDOException $e) {
    //             $errors['db'] = "Lỗi khi thực thi truy vấn: " . $e->getMessage();
    //         }
    //     }

    //     return ['success' => false, 'errors' => $errors, 'data' => $data];
    // }

    //     public function saveOtp($email, $otp)
    // {
    //     // Lưu OTP vào database
    //     $sql = "UPDATE users SET otp = :otp, created_at = NOW() WHERE email = :email";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->execute([':otp' => $otp, ':email' => $email]);
    // }

    public function login($data)
{
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($data['username'])) {
            $errors['username'] = "Username không được để trống!";
        }

        if (empty($data['password'])) {
            $errors['password'] = "Password không được để trống!";
        }
    }

    if (empty($errors)) {
        try {
            $sql = "SELECT * FROM users WHERE username = ?";
            $stmt = $this->db->prepare($sql);

            if ($stmt) {
                $stmt->execute([$data['username']]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Kiểm tra mật khẩu
                    if (password_verify($data['password'], $user['password'])) {
                        
                        // Kiểm tra trường OTP
                        if (!empty($user['otp'])) {
                            // Nếu OTP không rỗng, yêu cầu xác thực OTP trước khi đăng nhập
                            $_SESSION['email'] = $user['email']; 
                            return [
                                'success' => false, 
                                'errors' => ['otp' => 'Cần xác thực OTP trước khi tiếp tục đăng nhập.']
                            ];
                        }

                        // Nếu không có OTP, đăng nhập thành công
                        $_SESSION['user'] = $user;
                        return ['success' => true, 'user' => $user];
                    } else {
                        $errors['login'] = "Password không đúng!";
                    }
                } else {
                    $errors['login'] = "Không tìm thấy người dùng với username này!";
                }
            } else {
                $errors['db'] = "Lỗi chuẩn bị câu lệnh SQL.";
            }
        } catch (PDOException $e) {
            $errors['db'] = "Lỗi khi thực thi truy vấn: " . $e->getMessage();
        }
    }

    return ['success' => false, 'errors' => $errors, 'data' => $data];
}

}
