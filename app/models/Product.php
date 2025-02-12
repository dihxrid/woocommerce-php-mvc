<?php
include_once __DIR__ . '/../../includes/database.php';
class Product
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

    public function getProduct($offset = 0, $limit = 10)
    {
        $sql = "SELECT p.*, c.name AS category_name
        FROM products p
        LEFT JOIN category c ON p.category_id = c.id
        ORDER BY p.id DESC
        LIMIT :offset, :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function getTotalProducts()
    {
        $sql = "SELECT COUNT(*) as count FROM `products`";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getProductId($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function addProduct($data)
    {
        $errors = [];
        $uploadedFile = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['product_name'])) {
                $errors['product_name'] = "Tên sản phẩm không được để trống";
            }

            if (empty($data['price']) || !is_numeric($data['price'])) {
                $errors['price'] = "Giá sản phẩm không được để trống hoặc không hợp lệ";
            }

            if (empty($data['quantity']) || !is_numeric($data['quantity'])) {
                $errors['quantity'] = "Số lượng sản phẩm không được để trống hoặc không hợp lệ";
            }

            if (empty($data['description'])) {
                $errors['description'] = "Mô tả sản phẩm không được để trống";
            }

            if (empty($data['category_id'])) {
                $errors['category_id'] = "Danh mục sản phẩm không được để trống";
            }

            if (empty($data['size'])) {
                $errors['size'] = "Kích thước sản phẩm không được để trống";
            }

            if (empty($_FILES['image']['name'][0])) {
                $errors['image'] = "Hình ảnh sản phẩm không được để trống";
            } else {
                $target_dir = "uploads/";
                $file_count = count($_FILES['image']['name']);

                for ($i = 0; $i < $file_count; $i++) {
                    $file_name = pathinfo($_FILES['image']['name'][$i], PATHINFO_FILENAME);
                    $imageFileType = strtolower(pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION));
                    $unique_file_name = $file_name . '_' . time() . '_' . uniqid() . '.' . $imageFileType;
                    $target_file = $target_dir . $unique_file_name;

                    $check = getimagesize($_FILES['image']['tmp_name'][$i]);

                    if ($check === false) {
                        $errors['image'] = "Hình ảnh không đúng định dạng";
                        continue;
                    }

                    if ($_FILES['image']['size'][$i] > 500000) {
                        $errors['image'] = "Hình ảnh vượt quá kích thước cho phép";
                        continue;
                    }

                    if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                        $errors['image'] = "Chỉ chấp nhận file JPG, JPEG, PNG hoặc GIF";
                        continue;
                    }

                    if (empty($errors)) {
                        if (!move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_file)) {
                            $errors['image'] = "Không thể upload hình ảnh";
                        } else {
                            $uploadedFile[] = $unique_file_name;
                        }
                    }
                }
            }

            if (empty($errors)) {
                try {
                    $sql = "INSERT INTO products (product_name, price, quantity, description, image, category_id, size) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $data['product_name'],
                        $data['price'],
                        $data['quantity'],
                        $data['description'],
                        implode(',', $uploadedFile),
                        $data['category_id'],
                        $data['size'],
                    ]);
                    return ['success' => true];
                } catch (PDOException $e) {
                    $errors['db'] = "Lỗi khi thêm sản phẩm: " . $e->getMessage();
                }
            }

            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }
    public function deleteProduct($id)
    {
        $this->db->beginTransaction();

        try {
            // Xóa các bình luận liên quan đến sản phẩm
            $sql = "DELETE FROM comments WHERE product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $id);
            $stmt->execute();

            // Xóa các sản phẩm trong giỏ hàng liên quan đến sản phẩm
            $sql = "DELETE FROM cart WHERE product_id = :product_id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':product_id', $id);
            $stmt->execute();

            // Xóa sản phẩm
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            // Cam kết
            $this->db->commit();
        } catch (PDOException $e) {
            // Nếu có lỗi, hoàn tác
            $this->db->rollBack();
            error_log("Lỗi khi xóa sản phẩm: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateProduct($id, $data)
    {
        $errors = [];
        $uploadedFile = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['product_name'])) {
                $errors['product_name'] = "Tên sản phẩm không được để trống";
            }

            if (empty($data['price'])) {
                $errors['price'] = "Giá sản phẩm không được để trống";
            }

            if (empty($data['quantity'])) {
                $errors['quantity'] = "Số lượng sản phẩm không được để trống";
            }

            if (empty($data['description'])) {
                $errors['description'] = "Mô tả sản phẩm không được để trống";
            }

            if (empty($data['category_id'])) {
                $errors['category_id'] = "Danh mục sản phẩm không được để trống";
            }

            if (!empty($_FILES['image']['name'][0])) {
                $target_dir = "uploads/";
                $file_count = count($_FILES['image']['name']);

                for ($i = 0; $i < $file_count; $i++) {
                    $file_name = pathinfo($_FILES['image']['name'][$i], PATHINFO_FILENAME);
                    $imageFileType = strtolower(pathinfo($_FILES['image']['name'][$i], PATHINFO_EXTENSION));
                    $unique_file_name = $file_name . '_' . time() . '_' . uniqid() . '.' . $imageFileType;
                    $target_file = $target_dir . $unique_file_name;

                    $check = getimagesize($_FILES['image']['tmp_name'][$i]);

                    if ($check === false) {
                        $errors['image'] = "Hình ảnh không đúng định dạng";
                        continue;
                    }

                    if ($_FILES['image']['size'][$i] > 500000) {
                        $errors['image'] = "Hình ảnh vượt quá kích thước cho phép";
                        continue;
                    }

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $errors['image'] = "Chỉ chấp nhận file JPG, JPEG, PNG hoặc GIF";
                        continue;
                    }

                    if (empty($errors)) {
                        if (!move_uploaded_file($_FILES['image']['tmp_name'][$i], $target_file)) {
                            $errors['image'] = "Không thể upload hình ảnh";
                        } else {
                            $uploadedFile[] = $unique_file_name;
                        }
                    }
                }
            }

            if (empty($errors)) {
                try {
                    $imagePath = !empty($uploadedFile) ? implode(',', $uploadedFile) : $data['old_image'];

                    $sql = "UPDATE products SET name = ?, price = ?, quantity = ?, description = ?, image = ?, category_id = ? WHERE id = ?";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $data['product_name'],
                        $data['price'],
                        $data['quantity'],
                        $data['description'],
                        $data['category_id'],
                        $imagePath,
                        $id
                    ]);
                    return ['success' => true];
                } catch (PDOException $e) {
                    $errors['db'] = "Lỗi khi cập nhật sản phẩm: " . $e->getMessage();
                }
            }

            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }

    public function recommendProduct($id)
    {
        $sql = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $category = $stmt->fetch();

        if ($category) {
            $category_id = $category['category_id'];

            $sql = "SELECT * FROM products WHERE category_id = :category_id LIMIT 4";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['category_id' => $category_id]);
            $recommendProducts = $stmt->fetchAll();
            return $recommendProducts;
        } else {
            return [];
        }
    }

    public function select($categoris_id)
    {
        $sql = "SELECT products.id, products.product_name, products.image, products.price, products.quantity, products.description, category.name FROM products INNER JOIN category on products.category_id = category.id WHERE category.id = $categoris_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function selectByCategory($categoris_id)
    {
        $sql = "SELECT * FROM products WHERE category_id = $categoris_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
