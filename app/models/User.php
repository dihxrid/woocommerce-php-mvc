<?php
include_once __DIR__ . '/../../includes/database.php';
class User
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



    public function addUser($data)
    {
        function RandomPassword($length = 12)
        {
            $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+';
            $password = '';
            for ($i = 0; $i < $length; $i++) {
                $randomIndex = rand(0, strlen($characters) - 1);
                $password .= $characters[$randomIndex];
            }
            return $password;
        }

        $errors = [];

        include_once __DIR__ . '/../../app/models/Mail.php';
        $mail = new Mail;
        if (empty($data['username'])) {
            $errors['username'] = 'Tên người dùng không được để trống.';
        } elseif (strlen($data['username']) < 3 || strlen($data['username']) > 50) {
            $errors['username'] = 'Tên người dùng phải từ 3 đến 50 ký tự.';
        }

        // Kiểm tra validate cho email
        if (empty($data['email'])) {
            $errors['email'] = 'Email không được để trống.';
        } elseif (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email không hợp lệ.';
        } else {
            $checkSql = "SELECT COUNT(*) FROM users WHERE email = :email";
            $checkStmt = $this->db->prepare($checkSql);
            $checkStmt->bindParam(':email', $data['email']);
            $checkStmt->execute();
            if ($checkStmt->fetchColumn() > 0) {
                $errors['email'] = 'Email này đã được sử dụng.';
            }
        }
        if (!in_array($data['role'], ['user', 'admin'])) {
            $errors['role'] = 'Vai trò không hợp lệ.';
        }
        if (!empty($errors)) {
            return ['success' => false, 'errors' => $errors];
        }
        try {
            $sql = "INSERT INTO users (username, email, password, role) 
                VALUES (:username, :email, :password, :role)";
            $stmt = $this->db->prepare($sql);
            $randomPassword = RandomPassword(12);
            $hashedPassword = password_hash($randomPassword, PASSWORD_DEFAULT);
            $stmt->bindParam(':username', $data['username']);
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $data['role']);
            $stmt->execute();
            $subject = "Thông tin tài khoản của bạn";
            $mail->sendUser($data['email'], $subject, $data['username'], $randomPassword);
            return ['success' => true];
        } catch (PDOException $e) {
            error_log("Error in addUser: " . $e->getMessage());
            return ['success' => false, 'errors' => ['general' => 'Đã xảy ra lỗi khi thêm người dùng.']];
        }
    }




    public function getUser()
    {
        $sql = "SELECT * FROM users ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    // public function updateUser($id)
    // {
    //     $sql = "DELETE FROM users WHERE id = :id";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(':id', $id);
    //     $stmt->execute();
    // }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getUserId($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function getUserIdAdmin($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function updateProfile($id, $data)
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['username'])) {
                $errors['username'] = "Username không được để trống";
            }

            if (empty($data['email'])) {
                $errors['email'] = "Email không được để trống";
            }

            if (empty($data['phone'])) {
                $errors['phone'] = "Phone không được để trống";
            }

            if (empty($data['address'])) {
                $errors['address'] = "Address không được để trống";
            }

            if (empty($data['full_name'])) {
                $errors['full_name'] = "Họ tên không được để trống";
            }

            if (count($errors) == 0) {
                try {
                    $sql = "UPDATE users SET username = :username, email = :email, phone = :phone, full_name = :full_name, address = :address WHERE id = :id";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        ':username' => $data['username'],
                        ':email' => $data['email'],
                        ':phone' => $data['phone'],
                        ':full_name' => $data['full_name'],
                        ':address' => $data['address'],
                        ':id' => $id
                    ]);

                    return ['success' => true];
                } catch (\Throwable $th) {
                    return ['success' => false, 'errors' => $th->getMessage()];
                }
            }
            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }

    public function getUserByOrderId($orderId)
    {
        $sql = "SELECT u.id, u.email, u.full_name, u.phone, u.address FROM users u 
                JOIN orders o ON u.id = o.user_id 
                WHERE o.id = :orderId";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['orderId' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePassword($data)
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['password'])) {
                $errors['password'] = "Password không được để trống";
            }

            if (empty($data['confirm_password'])) {
                $errors['confirm_password'] = "Confirm password không được để trống";
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $errors['confirm_password'] = "Confirm password phải trùng với password";
                }
            }

            if (count($errors) == 0) {
                try {
                    $sql = "UPDATE users SET password = :password WHERE id = :id";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
                        ':id' => $data['id']
                    ]);
                    return ['success' => true];
                } catch (\Throwable $th) {
                    return ['success' => false, 'errors' => $th->getMessage()];
                }
            }
            return ['success' => false, 'errors' => $errors];
        }
    }

    public function sendOtp($data)
    {
        $errors = [];

        include_once __DIR__ . '/../../app/models/Mail.php';

        $mail = new Mail();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['email'])) {
                $errors['email'] = "Email không được để trống";
            }

            if (count($errors) == 0) {
                try {
                    $otp = random_int(100000, 999999);
                    $sql = "UPDATE users SET otp = :otp, created_at = NOW() WHERE email = :email";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        ':otp' => $otp,
                        ':email' => $data['email']
                    ]);
                    $mail->sendOtpMail($data['email'], $otp);
                    return ['success' => true];
                } catch (\Throwable $th) {
                    return ['success' => false, 'errors' => $th->getMessage()];
                }
            }
            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }

    public function checkOtp($data)
    {
        $sql = "SELECT id FROM users WHERE email = :email AND otp = :otp AND created_at > NOW() - INTERVAL 50 MINUTE";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':email' => $data['email'],
            ':otp' => $data['otp']
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Nếu OTP hợp lệ, xóa OTP khỏi cơ sở dữ liệu
            $updateSql = "UPDATE users SET otp = NULL WHERE email = :email";
            $updateStmt = $this->db->prepare($updateSql);
            $updateStmt->execute([
                ':email' => $data['email']
            ]);

            // Trả về kết quả thành công với user id
            return ['success' => true, 'user_id' => $user['id']];
        } else {
            // Nếu OTP không hợp lệ hoặc đã hết hạn
            return ['success' => false, 'message' => 'OTP không hợp lệ hoặc OTP đã hết hạn'];
        }
    }

    public function updateNewPassWord($data)
    {
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['new_password'])) {
                $errors['new_password'] = "Mật khẩu mới không được để trống";
            }

            if (empty($data['old_password'])) {
                $errors['old_password'] = "Mật khẩu cũ không được để trống";
            }

            if (count($errors) == 0) {
                try {
                    // Lấy mật khẩu hiện tại của người dùng
                    $sql = "SELECT password FROM users WHERE id = :id";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([':id' => $data['id']]);
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);

                    // Kiểm tra mật khẩu cũ nhập vào có khớp không
                    if (password_verify($data['old_password'], $user['password'])) {
                        // Cập nhật mật khẩu mới
                        $sql = "UPDATE users SET password = :password WHERE id = :id";
                        $stmt = $this->db->prepare($sql);
                        $stmt->execute([
                            ':password' => password_hash($data['new_password'], PASSWORD_DEFAULT),
                            ':id' => $data['id']
                        ]);
                        return ['success' => true];
                    } else {
                        $errors['old_password'] = "Mật khẩu cũ không đúng";
                    }
                } catch (\PDOException $th) {
                    return ['success' => false, 'errors' => $th->getMessage()];
                }
            }
            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }
}
