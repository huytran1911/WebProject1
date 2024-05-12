<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="images/logo image/Logo image.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <title>SnakeBoardgame</title>

</head>
    

<body>
    <?php 
    require './require/connect.php';
    session_start();
    $isLogined = false;
    if (isset($_SESSION['dangnhap'])) {
        require_once 'page/header-in.php';
        $isLogined = true;
    } else {
        require_once 'page/header-out.php';
    }
    ?>

<?php
include_once "./require/connect.php";
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    // Lấy từ khóa tìm kiếm từ URL
    $keyword = $_GET['keyword'];

    // Chuyển hướng người dùng đến trang kết quả tìm kiếm với từ khóa đã nhập
    header("Location: ?keyword=$keyword");
    exit(); // Đảm bảo không có mã HTML hoặc mã PHP nào được thực thi sau header
}

// Xử lý tìm kiếm sản phẩm
if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // Sử dụng phép toán LIKE để thực hiện tìm kiếm tương đối
    $search_keyword = '%' . $keyword . '%';

    // Truy vấn để lọc sản phẩm theo từ khóa tìm kiếm
    $sql_search = "SELECT * FROM tbl_products WHERE productName LIKE ?";
    // Sử dụng prepared statement để tránh lỗ hổng SQL injection
    $stmt = mysqli_prepare($conn, $sql_search);
    mysqli_stmt_bind_param($stmt, "s", $search_keyword);
    mysqli_stmt_execute($stmt);
    $result_search = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result_search) > 0) {
        // Hiển thị các sản phẩm tìm thấy
        while($row = mysqli_fetch_array($result_search)) {
            // Hiển thị thông tin sản phẩm
        }
    } else {
        echo "<p>Không tìm thấy sản phẩm nào.</p>";
    }
}
?>




    
<div class="menu-container" >
    <div class="product-cover">
        <div class="products-slider-wrapper">
            <div class="similar-products-label">Có thể bạn sẽ thích</div>
            <div class="products-slider owl-carousel owl-theme">
    <?php
    include_once "./require/connect.php"; 

    // Truy vấn để lấy các sản phẩm từ mục chiến lược
    $sql_similar_products = "SELECT * FROM tbl_products WHERE cid = '15' ORDER BY RAND() LIMIT 10";
    $result_similar_products = mysqli_query($conn, $sql_similar_products);

    // Kiểm tra xem có sản phẩm từ mục chiến lược nào không
    if (mysqli_num_rows($result_similar_products) > 0) {
        // Hiển thị các sản phẩm từ mục chiến lược
        while ($similar_product = mysqli_fetch_assoc($result_similar_products)) {
            ?>
            <div class="item">
                <div class="product-box">
                    <a href="./trangsp/trangspchinh/chitietsp.php?pid=<?php echo $similar_product['pid']; ?>">
                        <img alt="" src="./admin/productAdmin/uploads/<?php echo $similar_product['img']; ?>">
                    </a>
                    <div class="product-info">
                        <div class="product-name">
                            <a href="./trangsp/trangspchinh/chitietsp.php?pid=<?php echo $similar_product['pid']; ?>"><?php echo $similar_product['productName']; ?></a>
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
        echo "<div class='item'><p>Không có sản phẩm từ mục chiến lược.</p></div>";
    }
    ?>
</div>
</div>

        </div>
    </div>

    <?php
        include_once "./page/footer.php";
    ?>

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
