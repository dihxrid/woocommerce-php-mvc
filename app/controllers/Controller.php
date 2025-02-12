<?php
// HomeController.php
// include __DIR__ . '/../../app/models/User.php';
class HomeController
{

    public function index(): void
    {
        include __DIR__ . '/../../app/views/home/index.php';
    }
    public function admin()
    {
        include __DIR__ . '/../../app/views/admin/index.php';
    }
    public function login()
    {
        include __DIR__ . '/../../app/views/home/login.php';
    }

    public function register()
    {
        include __DIR__ . '/../../app/views/home/register.php';
    }

    public function logout()
    {
        include __DIR__ . '/../../app/views/home/logout.php';
    }

    public function product()
    {
        include __DIR__ . '/../../app/views/home/product.php';
    }

    public function contact()
    {
        include __DIR__ . '/../../app/views/home/contact.php';
    }

    public function checkout()
    {
        include __DIR__ . '/../../app/views/home/checkout.php';
    }

    public function order()
    {
        include __DIR__ . '/../../app/views/home/order.php';
    }

    public function cart()
    {
        include __DIR__ . '/../../app/views/home/cart.php';
    }

    public function detail()
    {
        include __DIR__ . '/../../app/views/home/detail.php';
    }

    public function about()
    {
        include __DIR__ . '/../../app/views/home/about.php';
    }

    public function profile()
    {
        include __DIR__ . '/../../app/views/home/profile.php';
    }
    # admin template controller

    public function adminProduct()
    {
        include __DIR__ . '/../../app/views/admin/adminProduct.php';
    }

    public function addProduct()
    {
        include __DIR__ . '/../../app/views/admin/add/addProduct.php';
    }

    public function adminUser()
    {
        include __DIR__ . '/../../app/views/admin/adminUser.php';
    }

    public function addUserAdmin()
    {
        include __DIR__ . '/../../app/views/admin/add/addUser.php';
    }

    public function adminCategory()
    {
        include __DIR__ . '/../../app/views/admin/adminCategory.php';
    }

    public function addCategory()
    {
        include __DIR__ . '/../../app/views/admin/add/addCategory.php';
    }

    public function adminOrder()
    {
        include __DIR__ . '/../../app/views/admin/adminOrder.php';
    }

    public function test()
    {
        include __DIR__ . '/../../app/views/home/test.php';
    }

    public function adminBill()
    {
        include __DIR__ . '/../../app/views/admin/adminBill.php';
    }

    public function vnpayReturn()
    {
        include __DIR__ . '/../../app/models/Vnpay_return.php';
    }

    public function resetPassword()
    {
        include __DIR__ . '/../../app/views/home/forgotpassword.php';
    }

    public function otpRegister()
    {
        include __DIR__ . '/../../app/views/home/otp_register.php';
    }

    public function otpCheck()
    {
        include __DIR__ . '/../../app/views/home/otp_check.php';
    }

    public function otp()
    {
        include __DIR__ . '/../../app/views/home/otp.php';
    }

    public function update_password()
    {
        include __DIR__ . '/../../app/views/home/updatepassword.php';
    }

    public function coupon()
    {
        include __DIR__ . '/../../app/views/admin/adminCoupon.php';
    }

    public function addCoupon()
    {
        include __DIR__ . '/../../app/views/admin/add/addCoupon.php';
    }

    public function adminComment()
    {
        include __DIR__ . '/../../app/views/admin/adminComment.php';
    }
}
