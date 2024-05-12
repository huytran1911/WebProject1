
<?php
require '../require/connect.php';
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














    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/cart/cart.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="../images/logo image/Logo image.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>SnakeBoardgame</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
        }
        .user-info {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .user-info p {
            margin: 5px 0;
        }
    </style>
    </head>
    <body>
    <body>
    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../index.php" class="logo">
                    <img src="../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../index.php">Trang chủ</a></li>
                    <li><a href="../trangsp/trangspchinh/trangspchinh.php">Cửa Hàng</a></li>
                    <li><a href="../Lienhe/Lienhe.php">Liên hệ</a></li>

                </ul>
                <div class="nav-icon">
                    <a href="cart.php"><i class='bx bx-cart'> </i></a>
                    <a href="user.php"><i class='bx bx-user'> <?php echo $_SESSION['dangnhap'];?> </i></a>
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
    
    <div class="container">
        
    </div>
    </body>
    </html>
<?php
  
    // Kết nối đến cơ sở dữ liệu
    require('../require/connect.php');

    // Kiểm tra xem ID được truyền từ URL có tồn tại và không rỗng
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        // Lấy ID người dùng từ URL
        $user_id = $_GET['id'];

        // Kiểm tra xem ID có phải là một số nguyên dương hay không
        if (filter_var($user_id, FILTER_VALIDATE_INT) && $user_id > 0) {
            // Truy vấn dữ liệu người dùng từ bảng tbl_users dựa trên ID
            $sql = "SELECT * FROM tbl_users WHERE id = $user_id";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Hiển thị thông tin người dùng
                $row = $result->fetch_assoc();
                echo '<div class="container">'; 
                echo '<h1>Thông Tin Người Dùng</h1>';
                echo '<div class="user-info">';
                echo '<p><strong>ID:</strong> ' . $row["id"] . '</p>';
                echo '<p><strong>Username:</strong> ' . $row["username"] . '</p>';
                echo '<p><strong>Email:</strong> ' . $row["email"] . '</p>';
                echo '<p><strong>Địa chỉ:</strong> ' . $row["street"] . ', ' . $row["ward"] . ', ' . $row["district"] . ', ' . $row["city"] . '</p>';
                echo '<p><strong>Phone:</strong> ' . $row["phonenumber"] . '</p>';
                echo '</div>';
                echo '</div>';
            } else {
                echo "Không có thông tin người dùng nào được tìm thấy.";
            }
        } else {
            echo "ID người dùng không hợp lệ.";
        }
    } else {
        echo "ID người dùng không được cung cấp.";
    }

    if (isset($_GET['id']) && !empty($_GET['id'])) {
        // Lấy ID người dùng từ URL
        $user_id = $_GET['id'];
    
        // Kiểm tra xem ID có phải là một số nguyên dương hay không
        if (filter_var($user_id, FILTER_VALIDATE_INT) && $user_id > 0) {
            // Truy vấn dữ liệu chi tiết đơn hàng từ bảng orders_detail và tbl_products dựa trên ID người dùng
            $sql = "SELECT od.*, p.productName, p.price
                    FROM orders_detail od
                    INNER JOIN tbl_products p ON od.pid = p.pid
                    INNER JOIN orders o ON od.IDorders = o.IDorders
                    WHERE o.id = $user_id";
            $result = $conn->query($sql);
    
            if ($result->num_rows > 0) {
                echo '<div class="container">';
                echo '<h1>Lịch sử đơn hàng</h1>';
    
                // Hiển thị thông tin chi tiết đơn hàng
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="order-info">';
                    echo '<p><strong>ID Detail:</strong> ' . $row["idDetail"] . '</p>';
                    echo '<p><strong>Sản Phẩm:</strong> ' . $row["productName"] . '</p>';
                    echo '<p><strong>Số Lượng:</strong> ' . $row["quantity"] . '</p>';
                    echo '<p><strong>Giá:</strong> ' . $row["price"] . '</p>';
                    echo '</div>';
                }
    
                echo '</div>';
            } else {
                echo "Không có thông tin đơn hàng nào được tìm thấy.";
            }
        } else {
            echo "ID người dùng không hợp lệ.";
        }
    } else {
        echo "ID người dùng không được cung cấp.";
    }

    // Đóng kết nối
    $conn->close();
    ?>