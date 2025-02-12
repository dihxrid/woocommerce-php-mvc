<?php
include_once "includes/header.php";
// Lấy danh mục hiện tại từ URL
$currentCategoryId = isset($_GET['id']) ? $_GET['id'] : null;

// Lọc sản phẩm theo danh mục
if ($currentCategoryId) {
    $sanpham = array_filter($sanpham, function ($product) use ($currentCategoryId) {
        return $product['category_id'] == $currentCategoryId;
    });
}
// var_dump($sanpham);
?>
<style>
    .product-card1 {
        overflow: hidden;
        position: relative;
    }

    .product-card1 img {
        transition: transform 0.3s ease;
    }

    .product-card1:hover img {
        transform: scale(1.1);
    }

    .sidebar {
        border-right: 1px solid #ddd;
        padding-right: 15px;
    }

    .sidebar h5 {
        margin-top: 20px;
    }

    .sidebar a {
        text-decoration: none;
        color: #000;
        display: block;
        margin-bottom: 10px;
    }

    .sidebar a:hover {
        color: #007bff;
    }

    .card-img-wrapper {
        overflow: hidden;
        height: 200px;
    }

    .card {
        height: 300px;
    }
</style>

<section class="shop1 text-center">
    <h1 class="text-center mt-5">Sản phẩm</h1>
    <p class="text-center">
        Các sản phẩm có tại website của chúng tôi.
    </p>
</section>
<!-- Mobile -->
<section class="shop2 text-left">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="/" class="text-decoration-none" style="color: #dc3545;">
                            <span>Trang Chủ</span>
                        </a>
                        <span class="icon-arrow-right"> -> </span>
                    </li>
                    <li>
                        <strong>
                            <span> Sản phẩm </span>
                        </strong>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>



<button id="toggleSidebarBtn" class="btn-filter-sidebar"><i class="fa-solid fa-sliders"></i></button>

<div class="filter-mobile-sidebar">
    <button class="btn-close-sidebar-mb">&times;</button>
    <h5>Danh Mục</h5>
    <?php $danhmuc = $danhmuc;
    foreach ($danhmuc as $category) { ?>
        <a href="/product?id=<?php echo $category['id']; ?>" class="text-decoration-none text-black text-muted"><?php echo $category['name']; ?></a>
    <?php } ?>
</div>
<!-- end mobile -->
<div class="container">
    <div class="row">
        <div class="col-md-3 sidebar">
            <h5>Danh Mục</h5>
            <?php foreach ($danhmuc as $category) { ?>
                <a href="/product?id=<?php echo $category['id']; ?>" class="text-decoration-none text-black text-muted"><?php echo $category['name']; ?></a>
            <?php } ?>
        </div>
        <div class="col-md-9 main-product">
            <div class="d-flex justify-content-between mb-3">
                <div class="input-group" style="width: 60%;">
                    <span class="input-group-text bg-danger text-white border-danger" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm sản phẩm">
                </div>
                <select id="sortSelect" class="form-select" style="width: 20%;">
                    <option value="">Sắp xếp</option>
                    <option value="min">Giá thấp đến cao</option>
                    <option value="max">Giá cao đến thấp</option>
                    <option value="az">A-Z</option>
                    <option value="za">Z-A</option>
                </select>
            </div>
            <div id="productContainer" class="row">
                <?php
                function formatVND($number)
                {
                    return number_format($number, 0, '', '.') . 'đ';
                }
                foreach ($sanpham as $product) {
                    $images = explode(',', $product['image']);
                    $firstImage = $images[0]; // Bức ảnh đầu tiên
                ?>
                    <div class="col-md-3 col-sm-6 mb-4 product-item" data-name="<?php echo $product['product_name']; ?>" data-price="<?php echo $product['price']; ?>">
                        <a href="/detail?id=<?php echo $product['id']; ?>" class="text-decoration-none text-black">
                            <div class="card product-card1">
                                <div class="card-img-wrapper">
                                    <img src="/uploads/<?php echo $firstImage; ?>" class="card-img-top" alt="Product 1" width="100%">
                                </div>
                                <div class="card-body">
                                    <div class="d-flex justify-content-left small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <h5 class="card-title"><?php echo $product['product_name']; ?></h5>
                                    <p class="card-text"><?php echo formatVND($product['price']); ?> <del class="text-decoration-line-through text-danger">385.000đ</del></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>

            <!-- Hiển thị các nút phân trang -->
            <ul class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                    <li class="page-item <?php echo ($i == $currentPage) ? 'active' : ''; ?>">
                        <a class="page-link bg-danger border-danger text-white" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("searchInput");
        const sortSelect = document.getElementById("sortSelect");
        const productContainer = document.getElementById("productContainer");
        const products = Array.from(document.getElementsByClassName("product-item"));

        function filterAndSortProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const sortValue = sortSelect.value;

            let filteredProducts = products.filter(product => {
                const productName = product.getAttribute("data-name").toLowerCase();
                return productName.includes(searchTerm);
            });

            if (sortValue === "az") {
                filteredProducts.sort((a, b) => a.getAttribute("data-name").localeCompare(b.getAttribute("data-name")));
            } else if (sortValue === "za") {
                filteredProducts.sort((a, b) => b.getAttribute("data-name").localeCompare(a.getAttribute("data-name")));
            } else if (sortValue === "min") {
                filteredProducts.sort((a, b) => {
                    const priceA = parseFloat(a.getAttribute("data-price"));
                    const priceB = parseFloat(b.getAttribute("data-price"));
                    return priceA - priceB;
                });
            } else if (sortValue === "max") {
                filteredProducts.sort((a, b) => {
                    const priceA = parseFloat(a.getAttribute("data-price"));
                    const priceB = parseFloat(b.getAttribute("data-price"));
                    return priceB - priceA;
                });
            }

            productContainer.innerHTML = "";
            filteredProducts.forEach(product => productContainer.appendChild(product));
        }

        searchInput.addEventListener("input", filterAndSortProducts);
        sortSelect.addEventListener("change", filterAndSortProducts);
    });
</script>
<script>
    document.getElementById('toggleSidebarBtn').addEventListener('click', function() {
        document.querySelector('.filter-mobile-sidebar').classList.toggle('open');
    });

    document.querySelector('.btn-close-sidebar-mb').addEventListener('click', function() {
        document.querySelector('.filter-mobile-sidebar').classList.remove('open');
    });
</script>
<?php
include_once "includes/footer.php";
?>