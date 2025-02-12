<?php
include_once __DIR__ . '/../../includes/database.php';

class Order
{
    protected $db;

    public function __construct()
    {
        try {
            date_default_timezone_set('Asia/Ho_Chi_Minh');
            $this->db = db_connect();
        } catch (PDOException $e) {
            die("Kết nối thất bại: " . $e->getMessage());
        }
    }

    public function getOrder($offset = 0, $limit = 10)
    {
        $sql = "SELECT * FROM `orders` LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getOrderById($id)
    {
        $sql = "SELECT * FROM `orders` WHERE `id` = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function getTotalOrders()
    {
        $sql = "SELECT COUNT(*) as count FROM `orders`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function addOrder($data)
    {
        try {
            $user_id = $_SESSION['user']['id'];
            $total = 0;
            $cartSummary = [];
            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            foreach ($data['carts'] as $cart) {
                $productId = $cart['product_id'];
                if (!isset($cartSummary[$productId])) {
                    $cartSummary[$productId] = [
                        'quantity' => 0,
                        'price' => $cart['price'],
                        'size' => $cart['size']
                    ];
                }
                $cartSummary[$productId]['quantity'] += $cart['quantity'];
            }

            foreach ($cartSummary as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $status = '1'; // Trạng thái đơn hàng

            $sql = "INSERT INTO `orders` (`user_id`, `total`, `status`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id, $total, $status, $created_at, $updated_at]);
            $order_id = $this->db->lastInsertId();

            foreach ($cartSummary as $productId => $item) {
                $sql = "INSERT INTO `order_details` (`order_id`, `product_id`,`size`, `quantity`, `price`, `created_at`, `updated_at`) VALUES (?, ?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$order_id, $productId, $item['size'], $item['quantity'], $item['price'], $created_at, $updated_at]);
            }

            return ['success' => true, 'order_id' => $order_id];
        } catch (PDOException $e) {
            die("Lỗi khi thêm đơn hàng: " . $e->getMessage());
        }
    }

    public function deleteOrder($id)
    {
        try {
            $this->db->beginTransaction();

            $sql = "DELETE FROM `order_details` WHERE `order_id` = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            $sql = "DELETE FROM `orders` WHERE `id` = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);

            $this->db->commit();

            return ['success' => true];
        } catch (PDOException $e) {
            $this->db->rollBack();
            die("Lỗi khi xóa đơn hàng: " . $e->getMessage());
        }
    }

    public function order_detail($user_id)
    {
        try {
            $sql = "SELECT * FROM `users` WHERE `id` = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            $user = $stmt->fetch();

            if (!$user) {
                throw new Exception("Người dùng không tồn tại.");
            }

            $sql = "SELECT * FROM `orders` WHERE `user_id` = ? AND `status` = 1";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            $orders = $stmt->fetchAll();

            if (!$orders) {
                throw new Exception("Người dùng này không có đơn hàng chưa thanh toán.");
            }

            $order_details = [];
            foreach ($orders as $order) {
                $order_id = $order['id'];
                $sql = "SELECT * FROM `order_details` WHERE `order_id` = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$order_id]);
                $details = $stmt->fetchAll();

                foreach ($details as &$detail) {
                    $product_id = $detail['product_id'];
                    $sql = "SELECT * FROM `products` WHERE `id` = ?";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([$product_id]);
                    $product = $stmt->fetch();
                    $detail['product'] = $product;
                }

                $order['order_details'] = $details;
                $order_details[] = $order;
            }

            return [
                'user' => $user,
                'orders' => $order_details
            ];
        } catch (PDOException $e) {
            die("Lỗi khi lấy thông tin đơn hàng: " . $e->getMessage());
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    public function getOrderIdByUserId($userId)
    {
        $sql = "SELECT id FROM orders WHERE user_id = ? AND status = 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getTotalByOrderId($orderId)
    {
        $sql = "SELECT total FROM orders WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchColumn();
    }

    public function getOrderDetailsByOrderId($orderId)
    {
        $sql = "SELECT o.total, p.product_name as product_name, od.quantity, od.price, od.coupon
            FROM orders o
            JOIN order_details od ON o.id = od.order_id
            JOIN products p ON od.product_id = p.id
            WHERE o.id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateProductQuantity($productId, $quantity)
    {
        $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$quantity, $productId]);
    }

    public function cancelOrder($orderId)
    {
        $sql = "UPDATE bill SET status = 3 WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
    }

    public function startPayment($orderId)
    {
        $sql = "UPDATE bill SET status = 2 WHERE order_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$orderId]);
    }
}
