<?php
require_once 'config/config.php';
require_once 'includes/database.php';

require_once 'app/controllers/Controller.php';
require_once 'app/controllers/AdminController.php';
require_once 'app/controllers/ViewController.php';



$request_uri = $_SERVER['REQUEST_URI'];
$base_path = parse_url($request_uri, PHP_URL_PATH);


switch ($base_path) {
    case '/':
        include_once 'app/models/Product.php';
        $controller = new HomeController();
        $viewcontroller = new ViewController();
        $viewcontroller->index();
        break;
        $controller->index();
        break;
    case '/product':
        $controller = new HomeController();
        $viewcontroller = new ViewController();
        $viewcontroller->viewProduct();
        break;
        $controller->product();
        break;
    case '/checkout':
        $controller = new HomeController();
        $get = new AdminController();
        $get->order_detail(isset($_GET['id']) ? $_GET['id'] : null);
        break;
        $controller->checkout();
        break;
    case '/contact':
        $controller = new HomeController();
        $controller->contact();
        break;
    case '/order':
        $controller = new HomeController();
        $controllers = new AdminController();
        $controllers->userBill(isset($_GET['id']) ? $_GET['id'] : null);
        break;
        $controller->order();
        break;
    case '/profile':
        $controller = new HomeController();
        $controllers = new ViewController();
        $controllers->viewUserId($_GET['id']);
        break;
        $controller->profile();
        break;
    case '/cart':
        $controller = new HomeController();
        $controllers = new ViewController();
        $controllers->viewCart();
        break;
        $controller->cart();
        break;
    case '/detail':
        $controller = new HomeController();
        $controllers = new ViewController();
        $controllers->viewProductId($_GET['id']);
        break;
        $controller->detail();
        break;
    case '/about':
        $controller = new HomeController();
        $controller->about();
        break;
    case '/login':
        $controller = new HomeController();
        $controller->login();
        break;
    case '/register':
        $controller = new HomeController();
        $controller->register();
        break;
    case '/logout':
        $controller = new HomeController();
        $controller->logout();
        break;
    case '/update-new-password':
        $admincontroller = new AdminController();
        $admincontroller->update_password();
        break;
    case '/admin':
        include_once 'app/models/Count.php';
        $controller = new HomeController();
        $controller->admin();
        break;
    case '/admin/users/register':
        $controller = new AdminController();
        $controller->register();
        break;
    case '/admin/users/login':
        $controller = new AdminController();
        $controller->login();
        break;
    case '/test':
        $controller = new HomeController();
        $controllers = new AdminController();
        $controllers->getUser();
        break;
        $controller->test();
        break;

        #admin template
    case '/admin/product':
        $controller = new HomeController();
        $controllers = new AdminController();
        $controllers->getProduct();
        break;
        $controller->adminProduct();
        break;
    case '/admin/product/add':
        $controller = new HomeController();
        $controllers = new ViewController();
        $controllers->viewCategory();
        break;
        $controller->addProduct();
        break;
    case '/admin/product/addProduct':
        $controllers = new AdminController();
        $controllers->addProducts();
        break;
    case '/admin/product/update':
        $controllers = new AdminController();
        $controllers->getProductId($_GET['id']);
        break;
    case '/admin/category/update':
        $controllers = new AdminController();
        $controllers->getCategoryId($_GET['id']);
        break;
    case '/admin/category/updateCategory':
        $controllers = new AdminController();
        $controllers->updateCategory($_GET['id'], $_POST);
        break;
    case '/admin/product/updateProduct':
        $controllers = new AdminController();
        $controllers->updateProduct($_GET['id'], $_POST);
        break;
    case '/admin/product/delete':
        $controllers = new AdminController();
        $controllers->deleteProduct($_GET['id']);
        break;
    case '/admin/User':
        $controller = new HomeController();
        $controllers = new AdminController();
        $controllers->getUser();
        break;
        $controller->adminUser();
        break;
    case '/admin/User/add':
        $controller = new HomeController();
        $controller->addUserAdmin();
        break;
    case '/admin/User/addUser':
        $controllers = new AdminController();
        $controllers->addUser();
        break;
    case '/admin/User/updateUser':
        $controllers = new AdminController();
        $controllers->updateUser($_GET['id'], $_POST);
        break;
        // case '/admin/User/update':
        //     $controllers = new AdminController();
        //     $controllers->getUserIdAdmin($_GET['id']);
        //     break;
        // case '/admin/User/updateUser':
        //     $controllers = new AdminController();
        //     $controllers->updateUser($_GET['id'], $_POST);
        //     break;
    case '/admin/User/delete':
        $controllers = new AdminController();
        $controllers->deleteUser($_GET['id']);
        break;
    case '/admin/category':
        $controller = new HomeController();
        $controllers = new AdminController();
        $controllers->getCategory();
        break;
        $controller->adminCategory();
        break;
    case '/admin/category/add':
        $controller = new HomeController();
        $controller->addCategory();
        break;
    case '/admin/category/addCategory':
        $controllers = new AdminController();
        $controllers->addCategory();
        break;
    case '/admin/order':
        $controller = new HomeController();
        $controllers = new AdminController();
        $controllers->getOrder();
        break;
        $controller->adminOrder();
        break;
    case '/admin/order/delete':
        $controllers = new AdminController();
        $controllers->deleteOrder($_GET['id']);
        break;
    case '/admin/bill':
        $controller = new HomeController();
        $controllers = new AdminController();
        $controllers->getBill();
        break;
        $controller->adminBill();
        break;
    case '/admin/coupon':
        $controller = new HomeController();
        $viewController = new ViewController();
        $viewController->viewCoupon();
        break;
        $controller->coupon();
        break;
    case '/admin/coupon/add':
        $controller = new HomeController();
        $controller->addCoupon();
        break;
    case '/admin/coupon/delete':
        $controllers = new AdminController();
        $controllers->deleteCoupon($_GET['id']);
        break;
    case '/active-coupon':
        $admincontroller = new AdminController();
        $admincontroller->getCoupon();
        break;
    case '/admin/coupon/addCoupon':
        $controller = new AdminController();
        var_dump($_POST);
        $controller->addCoupon();
        break;
    case '/admin/comment':
        $controller = new HomeController();
        $adminController = new AdminController();
        $adminController->getComment();
        break;
        $controller->adminComment();
        break;
    case '/admin/comment/delete':
        $adminController = new AdminController();
        $adminController->deleteCm($_GET['id']);
        break;
        #end admin tempalte

    case '/add_to_cart':
        $controller = new AdminController();
        $controller->addCart();
        break;
    case '/delete-cart':
        $controller = new AdminController();
        $controller->deleteCart($_GET['id']);
        break;
    case '/add-order':
        $controller = new AdminController();
        $controller->addOrder();
        break;
    case '/update-profile':
        $controller = new AdminController();
        $controller->updateProfile($_GET['id'], $_POST);
        break;
    case '/payment':
        $controller = new AdminController();
        $controller->payment();
        break;
    case '/vnpay_return':
        $controller = new HomeController();
        $controller->vnpayReturn();
        break;
    case '/add-comment':
        $controller = new AdminController();
        $controller->addComment();
        break;
    case '/delete-comment':
        $controller = new AdminController();
        $controller->deleteComment($_GET['id'], $_GET['product_id']);
        break;
    case '/delete-bill':
        $controller = new AdminController();
        $controller->deleteBill($_GET['id']);
        break;
    case '/delete-category':
        $controller = new AdminController();
        $controller->deleteCategory($_GET['id']);
        break;
    case '/cancel-order':
        $controller = new AdminController();
        $controller->cancelOrder($_GET['id']);
        break;
        // Google OAuth routes
    case '/login/google':
        $controller = new AdminController();
        $controller->googleLogin();
        break;
    case '/login/google/callback':
        $controller = new AdminController();
        $controller->googleCallback();
        break;
    case '/reset-password':
        $controller = new HomeController();
        $controller->resetPassword();
        break;
    case '/send-otp':
        $admincontroller = new AdminController();
        var_dump($_POST);
        $admincontroller->sendOtp($_POST['email']);
        break;
    case '/otp-register':
        $controller = new HomeController();
        $controller->otpRegister();
        break;
    case '/otp-check':
        $controller = new HomeController();
        $controller->otpCheck();
        break;
        // case '/very-otp-regis':
        //     $controller = new AdminController();
        //     var_dump($_POST);
        //     $controller->sendOtpRegis($_POST['email']);
        //     break;
    case '/check-otp-regis':
        $admincontroller = new AdminController();
        $admincontroller->checkOtpRegis($_POST);
        break;
    case '/very-otp':
        $controller = new HomeController();
        $controller->otp();
        break;
    case '/check-otp':
        $admincontroller = new AdminController();
        $admincontroller->checkOtp($_POST);
        break;
    case '/update-password':
        $controller = new HomeController();
        $controller->update_password();
        break;
    case '/update-new-password':
        $admincontroller = new AdminController();
        $admincontroller->updateNewPassword();
        break;
    case '/start-payment':
        $admincontroller = new AdminController();
        $admincontroller->startPayment($_GET['id']);
        break;
    case '/contact-form':
        $adminController = new AdminController();
        $adminController->contactForm();
        break;

    default:
        http_response_code(404);
        include_once '404.html';
        break;
}
