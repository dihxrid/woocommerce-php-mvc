<?php
include_once __DIR__ . '/../../includes/database.php';

class Category
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

    public function getCategory()
    {
        $sql = "SELECT * FROM category";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll();
        return $result;
    }

    public function addCategory($data)
    {
        $errors = [];
        $uploadedFile = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['name'])) {
                $errors['name'] = "Tên sản phẩm không được để trống";
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
                    $sql = "INSERT INTO category (name, image) VALUES (?, ?)";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $data['name'],
                        implode(',', $uploadedFile)
                    ]);
                    return ['success' => true];
                } catch (PDOException $e) {
                    $errors['db'] = "Lỗi khi thêm danh mục: " . $e->getMessage();
                }
            }

            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }

    public function deleteCategory($id)
    {
        $sql = "DELETE FROM `category` WHERE `id` = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getCategoryById($id)
    {
        $sql = "SELECT * FROM category WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    public function updateCategory($id, $data)
    {
        $errors = [];
        $uploadedFile = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (empty($data['name'])) {
                $errors['name'] = "Tên sản phẩm không được để trống";
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

                    $sql = "UPDATE category SET name = ?, image = ? WHERE id = ?";
                    $stmt = $this->db->prepare($sql);
                    $stmt->execute([
                        $data['name'],
                        $imagePath,
                        $id
                    ]);
                    return ['success' => true];
                } catch (PDOException $e) {
                    $errors['db'] = "Lỗi khi cập nhật danh mục: " . $e->getMessage();
                }
            }

            return ['success' => false, 'errors' => $errors, 'data' => $data];
        }
    }
}
