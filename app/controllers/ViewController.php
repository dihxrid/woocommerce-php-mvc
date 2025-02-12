<?php

class ViewController
{
    public function index()
    {
        include __DIR__ . '/../../app/models/Views.php';
        $view = new Views();
        $sanpham = $view->viewProduct();
        $danhmuc = $view->viewCategory();
        include __DIR__ . '/../../app/views/home/index.php';
    }
    public function viewProduct()
    {
        include __DIR__ . '/../../app/models/Views.php';
        $view = new Views();

        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $recordsPerPage = 12;

        $totalProducts = $view->getTotalPageProduct();
        $totalPages = ceil($totalProducts / $recordsPerPage);
        $offset = ($currentPage - 1) * $recordsPerPage;

        $sanpham = $view->getPageProduct($offset, $recordsPerPage);
        $danhmuc = $view->viewCategory();

        include __DIR__ . '/../../app/views/home/product.php';
    }

    public function viewProductId($id)
    {
        include __DIR__ . '/../../app/models/Views.php';
        include __DIR__ . '/../../app/models/Product.php';
        include __DIR__ . '/../../app/models/Comment.php';
        $view = new Views();
        $detailProduct = $view->viewProductId($id);
        $product = new Product();
        $recommendProduct = $product->recommendProduct($id);
        $comment = new Comment();
        $comments = $comment->getCommentsByProductId($id);
        include __DIR__ . '/../../app/views/home/detail.php';
    }
    public function viewCategory()
    {
        include __DIR__ . '/../../app/models/Views.php';
        $view = new Views();
        $categories = $view->viewCategory();
        include __DIR__ . '/../../app/views/admin/update/updateCategory.php';
    }
    public function viewCart()
    {
        include __DIR__ . '/../../app/models/Views.php';
        $view = new Views();
        $cartss = $view->viewCart();
        $url = $_SERVER['REQUEST_URI'];
        if ($url == '/cart') {
            include __DIR__ . '/../../app/views/home/cart.php';
        }
    }
    public function viewUserId($id)
    {
        include __DIR__ . '/../../app/models/Views.php';
        $view = new Views();
        $users = $view->viewUserId($id);
        include __DIR__ . '/../../app/views/home/profile.php';
    }

    public function viewCoupon()
    {
        include __DIR__ . '/../../app/models/Views.php';
        $view = new Views();
        $coupon = $view->viewCoupon();
        include __DIR__ . '/../../app/views/admin/adminCoupon.php';
    }
}
