<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand ml-3" href="/">Admin Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <form class="form-inline my-2 my-lg-0 ml-auto mr-3">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-primary" type="submit">Search</button>
    </form>
</nav>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link active" href="/admin">
                            <i class="bi bi-speedometer"></i> Bảng điều khiển
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/User">
                            <i class="bi bi-people-fill"></i> Quản lý người dùng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/product">
                            <i class="bi bi-table"></i> Quản lý sản phẩm
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/category">
                            <i class="bi bi-tags-fill"></i> Quản lý danh mục
                        </a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="/admin/order">
                        <i class="bi bi-bag-heart-fill"></i> Quản lý đặt hàng
                        </a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/bill">
                        <i class="bi bi-receipt"></i> Quản lý đơn hàng
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/coupon">
                        <i class="bi bi-ticket-detailed-fill"></i> Quản lý mã giảm giá
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/admin/comment">
                        <i class="bi bi-chat-right-dots"></i> Quản lý bình luận
                        </a>
                    </li>
                </ul>
            </div>
        </nav>