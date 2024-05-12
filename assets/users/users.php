





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
require('../../require/connect.php');

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are filled
    if (!empty($_POST['fullname']) && !empty($_POST['email']) && !empty($_POST['phone']) && !empty($_POST['street']) && !empty($_POST['ward']) && !empty($_POST['district']) && !empty($_POST['city']) && !empty($_POST['product']) && !empty($_POST['quantity'])) {

        // Extract form data
        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $street = $_POST['street'];
        $ward = $_POST['ward'];
        $district = $_POST['district'];
        $city = $_POST['city'];
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        $note = !empty($_POST['note']) ? $_POST['note'] : "";

        // Insert order data into tbl_orders
        $sql_insert_order = "INSERT INTO tbl_orders (id, receiver, email, phone, street, ward, district, city, status, order_date) VALUES (DEFAULT, '$fullname', '$email', '$phone', '$street', '$ward', '$district', '$city', 0, NOW())";

        if ($conn->query($sql_insert_order) === TRUE) {
            $order_id = $conn->insert_id;

            // Insert order detail into tbl_orderdetail
            $sql_insert_order_detail = "INSERT INTO tbl_orderdetail (OrderID, pid, price, quantity) SELECT '$order_id', pid, price, '$quantity' FROM tbl_products WHERE productName = '$product'";
            
            if ($conn->query($sql_insert_order_detail) === TRUE) {
                echo "Đặt hàng thành công!";
            } else {
                echo "Lỗi: " . $sql_insert_order_detail . "<br>" . $conn->error;
            }
        } else {
            echo "Lỗi: " . $sql_insert_order . "<br>" . $conn->error;
        }
    } else {
        echo "Vui lòng điền đầy đủ thông tin.";
    }
} else {
    echo "Dữ liệu không được gửi qua phương thức POST.";
}

$conn->close();
?>







<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="../css/trangspchinh.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="../../images/logo image/Logo image.png">
    <title>SnakeBoardgame</title>

</head>

<body>
    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../../logined.html" class="logo">
                    <img src="../../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../../logined.html">Trang chủ</a></li>
                    <li><a href="../../trangsp.html/trangspchinh/usertrangsanphamchinh.html">Cửa Hàng</a></li>
                    <li><a href="../../Lienhe/UserLienhe.html">Liên hệ</a></li>

                </ul>
                <div class="nav-icon">
                    <a href="../cart/cart.html"><i class='bx bx-cart'></i></a>
                    <!-- <span style="padding-top: 10px; padding-right: 5px;"></span> -->
                    <a href="#"><i class='bx bx-user'> <?php echo $_SESSION['dangnhap'];?>   </i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="border-top">
        <div class="border-container">
            <div class="box-menu">
                <div class="main-text">
                    Danh mục sản phẩm
                    <a href="#" class="trigger mobile-hide">
                        <i class='bx bx-menu'></i>
                    </a>
                </div>
            </div>
            <div class="wrapper">
                <div class="search-input">
                    <input type="text" placeholder="Tìm kiếm">
                    <div class="icon"><a href="../search/usersearch.html"><i class="fas fa-search"></i></a></div>
                </div>
            </div>
        </div>
    </div>


    <div class="menu-list">
        <div class="menu-container">
            <div class="cover">
                <ul class="menu-link none">
                    <li>
                        <a href="../../danhmucsanpham/chienluocUser.html">
                        Chiến lược 
                    </a>
                        <a href="../../danhmucsanpham/chienluocUser.html"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Các loại cờ
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                    <li>
                        <a href="../../danhmucsanpham/giadinhUser.html">
                        Gia đình
                    </a>
                        <a href="../../danhmucsanpham/giadinhUser.html"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Vận may
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Nhập vai
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Nhóm bạn
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>


    
   



</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js " integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4 " crossorigin="anonymous "></script>

<!-- <script>
    var myButton1 = document.getElementById("myButton1");


    myButton1.addEventListener("click", function() {
        window.location.href = "../../index.html";
        alert("Bạn đã đăng xuất");


    });
</script> -->