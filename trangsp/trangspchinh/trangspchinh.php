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
// ?>

     <?php
//     // Kiểm tra trạng thái của session trước khi bắt đầu một session mới
//     if (session_status() === PHP_SESSION_NONE) {
//         session_start();
//     }

//     // Kiểm tra khi người dùng nhấn nút "Thêm vào giỏ"
//     if (isset($_POST['addtocart'])) {
//         // Lấy thông tin sản phẩm từ form
//         $product_id = $_POST['id'];
//         $product_image = $_POST['image'];
//         $product_name = $_POST['name'];
//         $product_price = $_POST['price'];

//         // Kiểm tra xem session giỏ hàng đã được khởi tạo chưa, nếu chưa thì tạo mới
//         if (!isset($_SESSION['cart'])) {
//             $_SESSION['cart'] = array();
//         }

//         // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
//         $product_index = -1;  
//         foreach ($_SESSION['cart'] as $index => $product) {
//             if ($product['id'] == $product_id) {
//                 $product_index = $index;
//                 break;
//             }
//         }

//         if ($product_index >= 0) {
//             // Nếu sản phẩm đã tồn tại, tăng số lượng của nó
//             $_SESSION['cart'][$product_index]['quantity'] += 1;
//         } else {
//             // Nếu sản phẩm chưa tồn tại, thêm sản phẩm vào giỏ hàng
//             $product = array(
//                 'id' => $product_id,
//                 'image' => $product_image,
//                 'name' => $product_name,
//                 'price' => $product_price,
//                 'quantity' => 1 // Số lượng ban đầu là 1
//             );
//             array_push($_SESSION['cart'], $product);
//         }

//         // Chuyển hướng người dùng đến trang giỏ hàng
//         header('Location: ../../assets/cart/cart.php');
//         exit();
//     }

//     

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

    
// Kiểm tra khi người dùng nhấn nút tìm kiếm

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
    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../../index.php" class="logo">
                    <img src="../../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../../index.php">Trang chủ</a></li>
                    <li><a href="./trangspchinh.php">Cửa Hàng</a></li>
                    <li><a href="../../Lienhe/Lienhe.php">Liên hệ</a></li>

                </ul>
                <div class="nav-icon">
                    <a href="../../assets/cart/cart.php"><i class='bx bx-cart'> </i></a>
                    <a href="../../assets/users/users.php"><i class='bx bx-user'> <?php echo $_SESSION['dangnhap'];?> </i></a>
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
   
    <div class="product-container">
        <div class="row">
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
                            <form method="post" action="../../page/cart.php">
                            <div class="price">
                                <span><?php echo number_format($product['price'], 0, ',', '.'); ?>đ</span>
                                <div class="detail-action">
                                    <input type="hidden" name="id" value="<?=$product['pid']?>">
                                    <input type="hidden" name="image" value="<?=$product['img']?>">
                                    <input type="hidden" name="name" value="<?=$product['productName']?>">
                                    <input type="hidden" name="price" value="<?=$product['price']?>">
                                    <button class="d-flex btn btn-outline-danger add-cart-btn fw-bold" type="submit" name="addtocart">
                                        <i class="fas fa-cart-shopping fs-1 me-0"></i>
                                        THÊM VÀO GIỎ
                                    </button>
                                </div>
                            </div>
                            
                        </form>
                        </div>
                    </div>
                </li>
            </div>
            <?php endforeach; ?>
        </div>
    </div>


    <!-- Phân trang -->
    <div class="pagination">
        <?php
        if ($page > 1) {
            echo "<a href='./trangspchinh.php?page=" . ($page - 1) . "'>&laquo; Trang trước</a>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<span class='current'>$i</span>";
            } else {
                echo "<a href='./trangspchinh.php?page=$i'>$i</a>";
            }
        }
        if ($page < $total_pages) {
            echo "<a href='./trangspchinh.php?page=" . ($page + 1) . "'>Trang tiếp &raquo;</a>";
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
