<?php
// Bắt đầu phiên session nếu chưa được bắt đầu
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem biến $_SESSION['taikhoan'] có tồn tại hay không
if (isset($_SESSION['dangnhap'])) {
    // echo $_SESSION['dangnhap'];
} else {
    // Xử lý trường hợp nếu $_SESSION['taikhoan'] không tồn tại
    // echo "Không có tài khoản được đăng nhập";
}
?>

<?php 
    require '../../require/connect.php';

    $isLogined = false;
    if (isset($_SESSION['dangnhap'])) {
        require_once 'header-in.php';
        $isLogined = true;
    } else {
        require_once 'header-out.php';
    }
?>

<?php
    // Step 1: Fetch products from the database
    require_once "../../require/connect.php";

    // Số sản phẩm trên mỗi trang
    $records_per_page = 8;

    // Xác định trang hiện tại
    if (isset($_GET['page']) && is_numeric($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }

    // Tính offset cho truy vấn
    $offset = ($page - 1) * $records_per_page;

    // Truy vấn để lấy tổng số bản ghi
    $sql_count = "SELECT COUNT(*) AS total FROM tbl_products";
    $result_count = mysqli_query($conn, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_records = $row_count['total'];

    // Tính tổng số trang
    $total_pages = ceil($total_records / $records_per_page);

    // Truy vấn lấy dữ liệu với phân trang
    $sql = "SELECT p.pid, p.img, p.productName, p.price, p.quantity, p.detail, c.categoryName
            FROM tbl_products AS p
            INNER JOIN tbl_category AS c ON p.cid = c.cateid
            LIMIT $offset, $records_per_page;";
    $result = mysqli_query($conn, $sql);

    // Step 2: Check if there are any products
    if(mysqli_num_rows($result) > 0) {
        // Step 3: Store fetched products in a variable
        $products = [];
        while($row = mysqli_fetch_array($result)) {
            $products[] = $row;
        }
    } else {
        echo "<p>Không có dữ liệu</p>";
    }
?>

<?php
    include_once "./search.php";
?>
    
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="../Chitietsp/chitietspcss/product.css">
    <link rel="stylesheet" href="../../assets/css/trangspchinh.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="../../images/logo image/Logo image.png">
    <title>SnakeBoardgame</title>
    <style>
        .pagination {
            margin-top: 20px;
            text-align: center;
            justify-content: center;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            margin-right: 5px;
        }

        .pagination a.current, .pagination span.current {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination a:disabled {
            color: #ccc;
            pointer-events: none;
        }

        /* Thêm CSS cho hiển thị/ẩn menu */
        .none {
            display: none;
        }

        /* CSS cho hiệu ứng hiển thị danh sách */
        .show {
            display: block;
        }
    </style>
</head>

<body>

<div class="menu-list">
    <div class="menu-container">
        <div class="cover">
            <ul class="menu-link none" id="menu-list">
                <?php
                // Truy vấn để lấy danh sách danh mục từ cơ sở dữ liệu
                $sql_categories = "SELECT * FROM tbl_category";
                $result_categories = mysqli_query($conn, $sql_categories);

                // Kiểm tra xem có danh mục nào hay không
                if (mysqli_num_rows($result_categories) > 0) {
                    // Hiển thị danh sách các danh mục
                    while ($row_category = mysqli_fetch_assoc($result_categories)) {
                        echo "<li><a href='./loaisp.php?cateid=" . $row_category['cateid'] . "'>" . $row_category['categoryName'] . "</a></li>";

                    }
                } else {
                    echo "<li><a href='#'>Không có danh mục</a></li>";
                }
                ?>
            </ul>
        </div>
    </div>
</div>
   
<section class="search-form">
    <form method="post" action="">
        <input type="text" name="search_box" placeholder="Tìm kiếm sản phẩm..." class="box">
        <input type="text" name="min_price" placeholder="Giá thấp nhất" min="0" class="box">
        <input type="text" name="max_price" placeholder="Giá cao nhất" max="0" class="box">
        <select name="category" class="box">
            <option value="">Tất cả danh mục</option>
            <?php
            $select_categories = $conn->query("SELECT * FROM `tbl_category`");
            while ($fetch_categories = $select_categories->fetch_assoc()) {
                echo '<option value="' . $fetch_categories['cateid'] . '">' . $fetch_categories['categoryName'] . '</option>';
            }
            ?>
        </select>
        <button type="submit" name="search_btn" class="fas fa-search"></button>
    </form>
</section>

<div class="product-container">
    <div class="row">
        <?php
        // Xử lý tìm kiếm nâng cao
        if (isset($_POST['search_btn'])) {
            $search_box = $_POST['search_box'];
            $min_price = isset($_POST['min_price']) && is_numeric($_POST['min_price']) ? $_POST['min_price'] : 0;
            $max_price = isset($_POST['max_price']) && is_numeric($_POST['max_price']) ? $_POST['max_price'] : PHP_INT_MAX;
            $category = $_POST['category'];

            $where = "WHERE productName LIKE '%$search_box%'";

            if ($min_price >= 0 && $max_price > $min_price) {
                $where .= " AND price BETWEEN $min_price AND $max_price";
            }

            if (!empty($category)) {
                $where .= " AND cid = '$category'";
            }

            $select_products = $conn->query("SELECT * FROM `tbl_products` $where");
            if ($select_products->num_rows > 0) {
                while ($fetch_products = $select_products->fetch_assoc()) {
                    ?>
                    <div class="col-md-3 col-sm-6">
                        <li class="item-a">
                            <form action="" method="post">
                                <div class="product-box">
                                    <input type="hidden" name="pid" value="<?= $fetch_products['pid']; ?>">
                                    <img src="../../admin/productAdmin/uploads/<?= $fetch_products['img']; ?>" alt="<?= $fetch_products['productName']; ?>">

                                    <div class="product-info">
                                        <div class="product-name">
                                            <a href="./chitietsp.php?category=<?= $fetch_products['cid']; ?>" class="category"><?= $fetch_products['productName']; ?></a>
                                            <div class="name"></div>
                                        </div>
                                        <div class="de-font">
                                            Bấm vào hình ảnh để xem thông tin chi tiết.
                                        </div>
                                        <form method="post" action="../../page/cart.php">
                                            <div class="price">
                                                <?= number_format($fetch_products['price'], 0, ',', '.') ?>đ

                                                <div class="detail-action">
                                                    <input type="hidden" name="id" value="<?= $fetch_products['pid'] ?>">
                                                    <input type="hidden" name="image" value="<?=$fetch_products['img']?>">
                                                    <input type="hidden" name="name" value="<?=$fetch_products['productName']?>">
                                                    <input type="hidden" name="price" value="<?=$fetch_products['price']?>">
                                                    <button class="d-flex btn btn-outline-danger add-cart-btn fw-bold" type="submit" name="addtocart">
                                                        <i class="fas fa-cart-shopping fs-1 me-0"></i>
                                                        THÊM VÀO GIỎ
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </form>
                        </li>
                    </div>
                    <?php
                }
            }
        }
        ?>
    </div>
</div>


<!-- Phân trang -->
<div class="pagination">
    <?php
    if ($page > 1) {
        echo "<a href='./search.php?page=" . ($page - 1) . "'>&laquo; Trang trước</a>";
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo "<span class='current'>$i</span>";
        } else {
            echo "<a href='./search.php?page=$i'>$i</a>";
        }
    }
    if ($page < $total_pages) {
        echo "<a href='./search.php?page=" . ($page + 1) . "'>Trang tiếp &raquo;</a>";
    }
    ?>
</div>

<footer>
    <div class="footer-container ">
        <div class="row ">
            <div class="col-lg-3 col-sm-6 ">
                <div class="single-box ">
                    <h2>CHĂM SÓC KHÁCH HÀNG</h2>
                    <ul>
                        <li><span>19001082</span></li>
                        <li><a href="# ">Từ thứ Hai đến thứ Bảy (08:00 - 17:00)</a></li>
                        <li><a href="# ">Chủ nhật (08:00 - 12:00)</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6 ">
                <div class="single-box ">
                    <h2>ĐIỀU KHOẢN & CHÍNH SÁCH</h2>
                    <ul>
                        <li><a href="# ">- Chính sách giao hàng </a></li>
                        <li><a href="# ">- Chính sách tích lũy điểm</a></li>
                        <li><a href="# ">- Điều khoản điều kiện</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 ">
                <div class="single-box ">
                    <h2>HỖ TRỢ KHÁCH HÀNG</h2>
                    <ul>
                        <li><a href="# ">- Chính sách bảo mật </a></li>
                        <li><a href="# ">- Chính sách bảo hành đổi trả hàng hóa</a></li>
                        <li><a href="# ">- Chính sách thanh toán</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6 ">
                <div class="single-box ">
                    <h2>Snake Boardgame</h2>
                </div>
                <img class="footer-img " src="../../images/logo image/SnakeBoardgame.png " alt=" ">
            </div>
        </div>
    </div>
</footer>

<!-- Đoạn JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var menuToggle = document.getElementById('menu-toggle'); // Lấy nút menu
        var menuList = document.getElementById('menu-list'); // Lấy danh sách danh mục
        var menuLinks = document.querySelectorAll('.menu-link a'); // Lấy tất cả các liên kết trong menu

        // Thêm sự kiện click cho nút menu
        menuToggle.addEventListener('click', function(e) {
            e.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
            menuList.classList.toggle('show'); // Thêm hoặc loại bỏ lớp 'show' để ẩn hoặc hiển thị danh sách
        });
    });
</script>


</body>

</html>
