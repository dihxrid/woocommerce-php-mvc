<?php
include_once __DIR__ . '/../../includes/database.php';

class Coupon
{
    protected $db;

    public function __construct()
    {
        try {
            $this->db = db_connect();
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function addCoupon($data)
    {
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            if (empty($data['code'])) {
                $errors['code'] = 'Vui lý nhập mã giảm giá';
            }

            if (empty($data['discount_amount'])) {
                $errors['discount_amount'] = 'Vui lý điền số tiền giảm giá';
            }

            if (empty($data['max_uses'])) {
                $errors['max_uses'] = 'Vui lý điền số lần sử dụng tối đa';
            }

            if (empty($data['end_date'])) {
                $errors['end_date'] = 'Vui lý điền ngày kết thúc';
            }

            if (empty($errors)) {
                try {
                    $sql = "INSERT INTO coupons (code, discount_amount, max_uses, end_date) VALUES (?, ?, ?, ?)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $data['code'],
                        $data['discount_amount'],
                        $data['max_uses'],
                        $data['end_date']
                    ]);
                    return ['success' => true];
                } catch (PDOException $e) {
                    $errors['db'] = "Lỗi khi thêm mã giảm giá: " . $e->getMessage();
                }
            }
            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }

    public function activeCoupon($data)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $sql = "SELECT * FROM coupons WHERE code = ? AND end_date > NOW()";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    $data['code']
                ]);
                $coupon = $stmt->fetch();
                if ($coupon) {
                    if ($coupon['max_uses'] > 0) {
                        $sql = "UPDATE coupons SET max_uses = max_uses - 1 WHERE code = ?";
                        $stmt = $this->db->prepare($sql);
                        $stmt->execute([
                            $data['code']
                        ]);
                    }
                    $_SESSION['coupon'] = $coupon;
                    return ['success' => true, 'coupon' => $coupon];
                } else {
                    return ['success' => false, 'message' => 'Không tiếm được giảm giá'];
                }
            } catch (PDOException $e) {
                return ['success' => false, 'message' => 'Không tiếm được giảm giá: ' . $e->getMessage()];
            }
        }
    }

    public function deleteCoupon($id)
    {
        try {
            $sql = "DELETE FROM coupons WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Kết nối thểat bị: " . $e->getMessage());
        }
    }
}
