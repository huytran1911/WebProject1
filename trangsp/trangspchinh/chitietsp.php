<?php
// Kết nối đến cơ sở dữ liệu và thực hiện truy vấn
include_once '../../require/connect.php';

// Kiểm tra xem đã có ID sản phẩm được chọn chưa
if (isset($_GET['pid'])) {
    $pid = $_GET['pid'];
    
    // Truy vấn để lấy thông tin chi tiết sản phẩm từ cơ sở dữ liệu
    $sql_product = "SELECT p.pid, p.img, p.productName, p.price, p.quantity, p.detail, c.categoryName
                    FROM tbl_products AS p
                    INNER JOIN tbl_category AS c ON p.cid = c.cateid
                    WHERE p.pid = $pid";
    $result_product = mysqli_query($conn, $sql_product);

    // Kiểm tra xem sản phẩm có tồn tại không
    if (mysqli_num_rows($result_product) > 0) {
        // Lấy thông tin chi tiết của sản phẩm
        $product = mysqli_fetch_assoc($result_product);
    }
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
    <link rel="icon" type="image/x-png" href="../../../images/logo image/Logo image.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="../Chitietsp/chitietspcss/product.css">
    <link rel="stylesheet" href="../../assets/css/trangspchinh.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer"
    />
    <link rel="icon" type="image/x-png" href="../../../images/logo image/Logo image.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
</head>

<body>
    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../../index.php" class="logo">
                    <img src="../../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../../index.php">Trang chủ</a></li>
                    <li><a href="./trangspchinh.php">Cửa Hàng</a></li>
                    <li><a href="../../../Lienhe/Lienhe.html">Liên hệ</a></li>
                </ul>
                <div class="nav-icon">
                    <a href="../../../login/html/dangnhap.html"><i class='bx bx-cart' ></i></a>
                    <a href="../../../login/html/dangnhap.html"><i class='bx bx-user'></i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="border-top">
        <div class="border-container">
            <div class="box-menu">
                <div class="main-text">
                    Danh mục sản phẩm
                    <!-- Thêm ID cho nút menu -->
                    <a href="#" id="menu-toggle" class="trigger mobile-hide">
                        <i class='bx bx-menu'></i>
                    </a>
                </div>
            </div>
            <div class="wrapper">
            <div class="search-input">
                <form action="" method="GET"> <!-- Thay đổi action và method -->
                    <input type="text" name="keyword" placeholder="Tìm kiếm"> <!-- Thêm thuộc tính name để lấy giá trị của ô input -->
                    <button type="submit" class="icon"><i class="fas fa-search"></i></button> <!-- Thay đổi thành nút submit -->
                </form>
            </div>

            </div>
        </div>
    </div>

    <!-- Thêm lớp CSS cho danh sách danh mục -->
    

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

    <section class="py-5">
        <div class="detail-container">
            <div class="row gx-5">
                <aside class="col-lg-6">
                    <!-- Hiển thị hình ảnh sản phẩm -->
                    <div class="border d-flex justify-content-center">
                        <img style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="../../admin/productAdmin/uploads/<?php echo $product['img']; ?>" />
                    </div>
                </aside>

                <main class="col-lg-6">
                    <div class="ps-lg-3">
                        <!-- Hiển thị thông tin chi tiết sản phẩm -->
                        <h4 class="title text-dark"><?php echo $product['productName']; ?></h4> 
                        <div class="d-flex flex-row my-3">
                            <!-- Đánh giá sao -->
                            <!-- Hiển thị giá -->
                        </div>
                        <div class="mb-3">
                            <span class="h5"><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                        </div>
                        <p><?php echo $product['detail']; ?></p>
                        <div class="row">
                            <dt class="col-3">Thể loại:</dt>
                            <dd class="col-9"><?php echo $product['categoryName']; ?></dd>

                            <!-- Thêm các thông tin khác của sản phẩm -->
                        </div>
                        <hr />
                        <div class="row mb-4">
                            <!-- Số lượng sản phẩm -->
                            <!-- Nút thêm vào giỏ hàng -->
                        </div>
                        <a href="../../../login/html/dangnhap.html" class="btn btn-primary shadow-0"> <i class="me-1 fa fa-shopping-basket"></i> Thêm vào giỏ hàng</a>
                    </div>
                </main>
                <div class="detail">
                    <!-- Mô tả chi tiết sản phẩm -->
                    <h1> Mô tả sản phẩm </h1>
                    <p><?php echo $product['detail']; ?></p>
                </div>
            </div>

            <div class="product-cover">
    <div class="products-slider-wrapper">
        <div class="similar-products-label">Có thể bạn sẽ thích</div>
        <div class="products-slider owl-carousel owl-theme">
            <?php
            // Truy vấn để lấy các sản phẩm tương tự
            $sql_similar_products = "SELECT * FROM tbl_products WHERE pid != $pid ORDER BY RAND() LIMIT 10";
            $result_similar_products = mysqli_query($conn, $sql_similar_products);

            // Kiểm tra xem có sản phẩm tương tự nào không
            if (mysqli_num_rows($result_similar_products) > 0) {
                // Hiển thị các sản phẩm tương tự
                while ($similar_product = mysqli_fetch_assoc($result_similar_products)) {
            ?>
                    <div class="item">
                        <div class="product-box">
                            <a href="./chitietsp.php?pid=<?php echo $similar_product['pid']; ?>">
                                <img alt="" src="../../admin/productAdmin/uploads/<?php echo $similar_product['img']; ?>">
                            </a>
                            <div class="product-info">
                                <div class="product-name">
                                    <a href="./chitietsp.php?pid=<?php echo $similar_product['pid']; ?>"><?php echo $similar_product['productName']; ?></a>
                                </div>
                                <div class="de-font">
                                    <?php echo substr($similar_product['detail'], 0, 100); ?>...
                                </div>
                                <div class="price">
                                    <span><?php echo number_format($similar_product['price'], 0, ',', '.'); ?>đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='item'><p>Không có sản phẩm tương tự.</p></div>";
            }
            ?>
        </div>
    </div>
</div>




<footer>
        <div class="footer-container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h2>CHĂM SÓC KHÁCH HÀNG</h2>
                        <ul>
                            <li><span>19001082</span></li>
                            <li><a href="#">Từ thứ Hai đến thứ Bảy (08:00 - 17:00)</a></li>
                            <li><a href="#">Chủ nhật (08:00 - 12:00)</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h2>ĐIỀU KHOẢN & CHÍNH SÁCH</h2>
                        <ul>
                            <li><a href="#">- Chính sách giao hàng </a></li>
                            <li><a href="#">- Chính sách tích lũy điểm</a></li>
                            <li><a href="#">- Điều khoản điều kiện</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h2>HỖ TRỢ KHÁCH HÀNG</h2>
                        <ul>
                            <li><a href="#">- Chính sách bảo mật </a></li>
                            <li><a href="#">- Chính sách bảo hành đổi trả hàng hóa</a></li>
                            <li><a href="#">- Chính sách thanh toán</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-box">
                        <h2>Snake Boardgame</h2>
                    </div>
                    <img class="footer-img" src="../../images/logo image/SnakeBoardgame.png" alt="">
                </div>
            </div>
        </div>
    </footer>
        </div>
    </section>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var menuList = document.getElementById('menu-list');

    // Thêm sự kiện click cho nút menu
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault(); 
        menuList.classList.toggle('show'); 
    });
});


        $('.products-slider').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:true,
                    loop:false
                }
            }
        });
    </script>

</body>

</html>
