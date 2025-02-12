<?php
include_once __DIR__ . '/../../includes/database.php';

class Cart
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

    public function getCart()
    {
        $sql = "SELECT * FROM `cart`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function addCart($data)
{
    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Kiểm tra số lượng
        if (!isset($data['quantity']) || $data['quantity'] <= 0) {
            $errors['quantity'] = 'Số lượng phải lớn hơn 0';
        }

        // Kiểm tra tồn kho
        if ($data['quantity'] > $data['storage']) {
            $errors['quantity'] = 'Số lượng không đủ';
            $_SESSION['error'] = 'Số lượng không đủ';
        }

        if (count($errors) == 0) {
            try {
                // Kiểm tra sản phẩm đã có trong giỏ hàng với kích cỡ tương ứng
                $sql = "SELECT * FROM `cart` WHERE `product_id` = ? AND `user_id` = ? AND `size` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$data['product_id'], $data['user_id'], $data['size']]);
                $existingCart = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($existingCart) {
                    // Cập nhật số lượng nếu sản phẩm đã có trong giỏ hàng
                    $newQuantity = $existingCart['quantity'] + $data['quantity'];
                    $sql = "UPDATE `cart` SET `quantity` = ? WHERE `id` = ?";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([$newQuantity, $existingCart['id']]);

                    // Cập nhật giỏ hàng trong session
                    foreach ($_SESSION['cart'] as &$item) {
                        if ($item['product_id'] == $data['product_id'] && $item['user_id'] == $data['user_id'] && $item['size'] == $data['size']) {
                            $item['quantity'] = $newQuantity;
                            break;
                        }
                    }
                } else {
                    // Nếu sản phẩm chưa có trong giỏ hàng, thêm mới
                    $sql = "INSERT INTO `cart` (`product_id`, `user_id`, `quantity`, `name`, `image`, `price`, `size`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $data['product_id'],
                        $data['user_id'],
                        $data['quantity'],
                        $data['name'],
                        $data['image'],
                        $data['price'],
                        $data['size'],
                    ]);

                    // Lưu lại ID của sản phẩm vừa thêm
                    $data['id'] = $this->db->lastInsertId();

                    // Khởi tạo session cart nếu chưa có
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    $_SESSION['cart'][] = $data;
                }
                return ['success' => true];
            } catch (PDOException $e) {
                error_log("Lỗi SQL: " . $e->getMessage());
                error_log("Câu lệnh SQL: " . $sql);
                error_log("Tham số: " . json_encode($data));
                return ['success' => false, 'errors' => $e->getMessage()];
            }
        }
        return ['success' => false, 'errors' => $errors];
    }
}


    public function deleteCart($id)
    {
        $sql = "DELETE FROM `cart` WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$id])) {
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $item) {
                    if ($item['id'] == $id) {
                        unset($_SESSION['cart'][$key]);
                        unset($_SESSION['cart']['subtotal']);
                        unset($_SESSION['coupon']);
                        break;
                    }
                }
            }

            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => $stmt->errorInfo()];
        }
    }

    public function deleteCartUserId($user_id)
    {
        $sql = "DELETE FROM `cart` WHERE `user_id` = ?";
        $stmt = $this->db->prepare($sql);

        if ($stmt->execute([$user_id])) {
            if (isset($_SESSION['cart'])) {
                unset($_SESSION['cart']);
            }
            return ['success' => true];
        } else {
            return ['success' => false, 'errors' => $stmt->errorInfo()];
        }
    }
}
