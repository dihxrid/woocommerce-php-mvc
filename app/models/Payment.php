<?php
include_once __DIR__ . '/../../includes/database.php';

class Payment
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

    public function createBill($fullName, $email, $phone, $address, $orderId, $productDetails, $size, $total, $status, $user_id)
    {
        $sql = "INSERT INTO bill (full_name, email, phone, address, order_id, product_name, size, total, status, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$fullName, $email, $phone, $address, $orderId, $productDetails, $size, $total, $status, $user_id]);
    }

    public function updateOrderStatus($order_id, $status)
    {
        try {
            $updated_at = date('Y-m-d H:i:s');
            $sql = "UPDATE `orders` SET `status` = ?, `updated_at` = ? WHERE `id` = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$status, $updated_at, $order_id]);
        } catch (PDOException $e) {
            die("Lỗi khi cập nhật trạng thái đơn hàng: " . $e->getMessage());
        }
    }
}
