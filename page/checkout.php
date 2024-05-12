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
        /* CSS cho phần form nhập thông tin giao hàng */
        .checkout-form {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .checkout-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }
        .checkout-form .form-floating {
            margin-bottom: 20px;
        }
        .checkout-form label {
            font-weight: 500;
        }
        .checkout-form .btn-primary {
            width: 100%;
            padding: 10px;
            font-size: 18px;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .checkout-form .btn-primary:hover {
            background-color: #0056b3;
        }
        /* CSS cho phần hiển thị đơn hàng */
        .order-summary {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .order-summary h2 {
            font-size: 20px;
            margin-bottom: 20px;
            color: #333;
        }
        .order-summary table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .order-summary th, .order-summary td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        .order-summary th {
            background-color: #f2f2f2;
        }
        .order-summary td {
            vertical-align: middle;
        }
        .order-summary .total-price {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../../index.html" class="logo">
                    <img src="../../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../../index.html">Trang chủ</a></li>
                    <li><a href="../../trangsp.html/trangspchinh/trangspchinh.html">Cửa Hàng</a></li>
                    <li><a href="../../Lienhe/Lienhe.html">Liên hệ</a></li>

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

<script src="bootstrap-5.3.2-dist/js/bootstrap.bundle.min.js"></script>

<?php
require '../require/connect.php';


if(isset($_SESSION['dangnhap'])) {
    $username = $_SESSION['dangnhap'];
    $sql = "SELECT * FROM `tbl_users` WHERE `username` = '$username'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $user_id = $row['id']; // Lấy id của người dùng từ session
}

// Khởi tạo biến $total_price
$total_price = 0;

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
    // Tính tổng giá trị đơn hàng
    foreach ($_SESSION['cart'] as $product){
        $total_price += $product['price'] * $product['quantity'];
    }
} else {
    // Nếu giỏ hàng trống, hiển thị thông báo và dừng quá trình thanh toán
    echo "Giỏ hàng trống!";
    exit();
}

if(isset($_POST['thanhtoan'])){
    $hoten = $_POST['hoten'];
    $sodt = $_POST['sodt'];
    $sonha_tenduong = $_POST['sonha_tenduong'];
    $phuong = $_POST['phuong'];
    $quan = $_POST['quan'];
    $thanhpho = $_POST['thanhpho'];
    $phuongthucthanhtoan = $_POST['phuongthucthanhtoan'];

    // Thêm đơn hàng vào bảng orders
    $sql_order = "INSERT INTO `orders` (`id`, `receiver`, `phonenumber`, `street`, `ward`, `district`, `city`, `email`, `method`, `total_products`, `total_price`, `status`, `order_date`) 
            VALUES ('$user_id', '$hoten', '$sodt', '$sonha_tenduong', '$phuong', '$quan', '$thanhpho', '".$row['email']."', '$phuongthucthanhtoan', '', '$total_price', 1, NOW())";

    if ($conn->query($sql_order) === TRUE) {
        $order_id = $conn->insert_id;

        // Thêm chi tiết đơn hàng vào bảng orders_detail
        foreach ($_SESSION['cart'] as $product){
            $product_id = $product['id'];
            $quantity = $product['quantity'];
            $subtotal = $product['price'] * $product['quantity'];
            $sql_detail = "INSERT INTO `orders_detail` (`IDorders`, `pid`, `quantity`, `subtotal`) 
                          VALUES ('$order_id', '$product_id', '$quantity', '$subtotal')";
            $conn->query($sql_detail);
        }
        unset($_SESSION['cart']); // Xóa giỏ hàng sau khi thanh toán
        echo "<script>alert('Đã thanh toán thành công!'); window.location.href = '../index.php';</script>";
        
    } else {
        echo "Lỗi khi thêm đơn hàng: " . $conn->error;
    }
}
?>




   

<!--container-->    
<div class="container">
  <form action="checkout.php" method="POST">
    <div class="d-flex">
    <div style="width: 60%;">
      <div class="main">
        <div class="main-header">

        </div>
        <div class="section-header">
          <h2>Thông tin giao hàng</h2>
        </div>
        <div>
          <!-- Form nhập thông tin giao hàng -->
          <div class="form-floating field">
            <select class="form-select" id="floatingSelect" aria-label="Floating label select example" onchange="selectAddress()">
              <option value="1">Địa chỉ hiện tại</option>
              <option value="2">Nhập địa chỉ mới</option>
            </select>
            <label for="floatingSelect">Chọn địa chỉ</label>
          </div>
          <script>
            function selectAddress() {
              var address = document.getElementById("floatingSelect").value;
              if (address == "2") {
                document.getElementById("new-address").style.display = "block";
              } else {
                document.getElementById("new-address").style.display = "none";
              }
            }
          </script>

          <div id="new-address" style="display: none;">
            <div class="form-floating field">
              <input type="text" class="form-control" id="hoten" name="hoten" required>
              <label for="hoten">Họ và tên</label>
            </div>
            <div class="form-floating field">
              <input type="text" class="form-control" id="sodt" name="sodt" required>
              <label for="sodt">Số điện thoại</label>
            </div>
            <div class="form-floating field">
              <input type="text" class="form-control" id="sonha_tenduong" name="sonha_tenduong" required>
              <label for="sonha_tenduong">Số nhà, tên đường</label>
            </div>
            <div class="form-floating field">
              <input type="text" class="form-control" id="phuong" name="phuong" required>
              <label for="phuong">Phường/Xã</label>
            </div>
            <div class="form-floating field">
              <input type="text" class="form-control" id="quan" name="quan" required>
              <label for="quan">Quận/Huyện</label>
            </div>
            <div class="form-floating field">
              <input type="text" class="form-control" id="thanhpho" name="thanhpho" required>
              <label for="thanhpho">Tỉnh/Thành phố</label>
            </div>
          </div>
        </div>
      </div>
      <div class="section-header">
        <h2>Phương thức thanh toán</h2>
      </div>
      <div>
        <!-- Form chọn phương thức thanh toán -->
        <div class="form-floating field">
          <select class="form-select" id="phuongthucthanhtoan" name="phuongthucthanhtoan" required>
            <option value="1">Thanh toán khi nhận hàng (COD)</option>
            <option value="2">Chuyển khoản ngân hàng</option>
          </select>
          <label for="phuongthucthanhtoan">Chọn phương thức thanh toán</label>
        </div>
      </div>
    </div>
    <div style="width: 40%; padding-left: 20px;">
      <div class="main">
        <div class="main-header">

        </div>
        <div class="section-header">
          <h2>Đơn hàng của bạn</h2>
        </div>
        <div>
          <!-- Hiển thị thông tin đơn hàng -->
          <table class="table">
            <thead>
            <tr>
              <th scope="col">Sản phẩm</th>
              <th scope="col">Số lượng</th>
              <th scope="col">Tổng cộng</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])){
                foreach ($_SESSION['cart'] as $product){
                    echo '<tr>
                            <td>'.$product['name'].'</td>
                            <td>'.$product['quantity'].'</td>
                            <td>'.($product['price'] * $product['quantity']).'</td>
                          </tr>';
                }
            }
            ?>
            <tr>
              <td colspan="2">Tổng giá trị đơn hàng:</td>
              <td><?php echo $total_price; ?></td>
            </tr>
            </tbody>
          </table>
          <button type="submit" class="btn btn-primary" name="thanhtoan">Thanh toán</button>
        </div>
      </div>
    </div>
  </form>
</div>

<!--footer-->
<!--  -->

</html>
