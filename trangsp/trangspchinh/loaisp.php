<?php
    // Step 1: Lấy sản phẩm từ cơ sở dữ liệu
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

    // Truy vấn để lấy tổng số bản ghi trong danh mục được chọn
    if (isset($_GET['cateid']) && is_numeric($_GET['cateid'])) {
        $cateid = $_GET['cateid'];
        $sql_count = "SELECT COUNT(*) AS total FROM tbl_products WHERE cid = $cateid";
    } else {
        $sql_count = "SELECT COUNT(*) AS total FROM tbl_products";
    }
    $result_count = mysqli_query($conn, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_records = $row_count['total'];

    // Tính tổng số trang dựa trên tổng số sản phẩm trong danh mục
    $total_pages = ceil($total_records / $records_per_page);

    // Truy vấn lấy dữ liệu với phân trang
    if (isset($_GET['cateid']) && is_numeric($_GET['cateid'])) {
        $cateid = $_GET['cateid'];
        $sql = "SELECT p.pid, p.img, p.productName, p.price, p.quantity, p.detail, c.categoryName
                FROM tbl_products AS p
                INNER JOIN tbl_category AS c ON p.cid = c.cateid
                WHERE p.cid = $cateid
                LIMIT $offset, $records_per_page;";
    } else {
        $sql = "SELECT p.pid, p.img, p.productName, p.price, p.quantity, p.detail, c.categoryName
                FROM tbl_products AS p
                INNER JOIN tbl_category AS c ON p.cid = c.cateid
                LIMIT $offset, $records_per_page;";
    }
    $result = mysqli_query($conn, $sql);

    // Step 2: Kiểm tra xem có sản phẩm nào không
    if(mysqli_num_rows($result) > 0) {
        // Step 3: Lưu sản phẩm đã lấy vào một mảng
        $products = [];
        while($row = mysqli_fetch_array($result)) {
            $products[] = $row;
        }
    } else {
        echo "<p>Không có sản phẩm trong danh mục này.</p>";
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
    <link rel="stylesheet" href="../../assets/css/trangspchinh.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="../images/logo image/Logo image.png">
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
    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../index.html" class="logo">
                    <img src="../../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../index.html">Trang chủ</a></li>
                    <li><a href="../trangsp.html/trangspchinh/trangspchinh.html">Cửa Hàng</a></li>
                    <li><a href="../Lienhe/Lienhe.html">Liên hệ</a></li>
                </ul>
                <div class="nav-icon">
                    <a href="../login/html/dangnhap.html"><i class='bx bx-cart'></i></a>
                    <a href="../login/html/dangnhap.html"><i class='bx bx-user'> </i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="border-top">
        <div class="border-container">
            <div class="box-menu">
                <div class="main-text">
                    Danh mục sản phẩm
                    <a href="#" id="menu-toggle" class="trigger mobile-hide">
                        <i class='bx bx-menu'></i>
                    </a>
                </div>
            </div>
            <div class="wrapper">
                <div class="search-input">
                    <input type="text" placeholder="Tìm kiếm">
                    <div class="icon"><a href="../assets/search/search.html"><i class="fas fa-search"></i></a></div>
                </div>
            </div>
        </div>
    </div>

    <div class="menu-list">
        <div class="menu-container">
            <div class="cover">
            <ul class="menu-link none" id="menu-list">
                    <?php
                    require_once "../../require/connect.php";
                    $sql_categories = "SELECT * FROM tbl_category";
                    $result_categories = mysqli_query($conn, $sql_categories);

                    if (mysqli_num_rows($result_categories) > 0) {
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

    <div class="Results">
        <div class="results-container">
            <?php
            // Kiểm tra xem cateid có tồn tại trong URL không
            if (isset($_GET['cateid'])) {
                // Lấy cateid từ URL
                $cateid = $_GET['cateid'];

                // Thực hiện truy vấn để lấy tên danh mục từ cơ sở dữ liệu
                $sql_category_name = "SELECT categoryName FROM tbl_category WHERE cateid = $cateid";
                $result_category_name = mysqli_query($conn, $sql_category_name);

                // Kiểm tra kết quả của truy vấn
                if ($result_category_name) {
                    // Lấy tên danh mục từ kết quả truy vấn
                    $row_category_name = mysqli_fetch_assoc($result_category_name);
                    $categoryName = $row_category_name['categoryName'];

                    // Hiển thị tên danh mục
                    echo "<h3>$categoryName</h3>";
                } else {
                    echo "<h3>Unknown Category</h3>";
                }
            } 
            ?>
        </div>
    </div>

    <div class="product-container">
        <div class="row">
            <?php if (!empty($products)): ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3 col-sm-6">
                        <li class="item-a">
                            <div class="product-box">
                            <a href="./chitietsp.php?pid=<?php echo $product['pid']; ?>">
                                <img alt="" src="../../admin/productAdmin/uploads/<?php echo $product['img']; ?>">
                            </a>
                                <div class="product-info">
                                    <div class="product-name">
                                    <a href="./chitietsp.php?pid=<?php echo $product['pid']; ?>"><?php echo $product['productName']; ?></a>
                                    </div>
                                    <div class="de-font">
                                        Bấm vào hình ảnh để xem thông tin chi tiết.
                                    </div>
                                    <div class="price">
                                        <span><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                                        <div class="detail-action">
                                            <button class="d-flex btn btn-outline-danger add-cart-btn fw-bold " type="submit">
                                                <i class="fas fa-cart-shopping fs-1 me-0"></i>
                                                THÊM VÀO GIỎ
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Không có sản phẩm trong danh mục này.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Phân trang -->
    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href='./loaisp.php?cateid=<?php echo $cateid; ?>&page=<?php echo ($page - 1); ?>'>&laquo; Trang trước</a>
        <?php endif; ?>
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <?php if ($i == $page): ?>
                <span class='current'><?php echo $i; ?></span>
            <?php else: ?>
                <a href='./loaisp.php?cateid=<?php echo $cateid; ?>&page=<?php echo $i; ?>'><?php echo $i; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($page < $total_pages): ?>
            <a href='./loaisp.php?cateid=<?php echo $cateid; ?>&page=<?php echo ($page + 1); ?>'>Trang tiếp &raquo;</a>
        <?php endif; ?>
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
                    <img class="footer-img " src="../images/logo image/SnakeBoardgame.png " alt=" ">
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4 " crossorigin="anonymous "></script>
    <script src="../assets/js/trangspchinh.js "></script>
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
