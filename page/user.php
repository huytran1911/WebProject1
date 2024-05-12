<?php
// Kết nối đến cơ sở dữ liệu
require '../require/connect.php';

// Bắt đầu phiên session nếu chưa được bắt đầu
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra biến $_SESSION['dangnhap']
if (!isset($_SESSION['dangnhap'])) {
    // Nếu không có tài khoản đăng nhập, chuyển hướng hoặc xử lý theo yêu cầu của bạn
    exit("Không có tài khoản được đăng nhập.");
}

// Kiểm tra xem giỏ hàng có tồn tại không
if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    // Lấy user_id từ session hoặc từ cơ sở dữ liệu tùy vào cách bạn lưu trữ
    $user_id = $_SESSION['user_id'];

    // Tạo đơn hàng mới
    $sql_create_order = "INSERT INTO orders (user_id, order_date) VALUES (?, NOW())";
    $stmt_create_order = $conn->prepare($sql_create_order);
    $stmt_create_order->bind_param("i", $user_id);
    $stmt_create_order->execute();
    $order_id = $stmt_create_order->insert_id;

    // Lặp qua từng sản phẩm trong giỏ hàng để thêm vào đơn hàng mới
    foreach ($_SESSION['cart'] as $product_id => $quantity) {
    // Thêm sản phẩm vào đơn hàng
    $sql_add_to_order = "INSERT INTO orders_detail (order_id, product_id, quantity) VALUES (?, ?, ?)";
    $stmt_add_to_order = $conn->prepare($sql_add_to_order);
    $stmt_add_to_order->bind_param("iii", $order_id, $product_id, $quantity);
    $stmt_add_to_order->execute();
}


    // Xóa giỏ hàng sau khi đã thêm vào đơn hàng
    unset($_SESSION['cart']);

    echo "Đã tạo đơn hàng thành công!";
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
    /* CSS cho phần đăng nhập */
    .user-info-container {
        margin-top: 20px;
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 10px;
        background-color: #f9f9f9;
    }

    .user-info h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .user-info p {
        margin-bottom: 10px;
        font-size: 16px;
    }

    /* CSS cho phần lịch sử đơn hàng */
    .order-info-container {
        margin-top: 20px;
    }

    .order-info {
        border: 1px solid #ccc;
        padding: 20px;
        border-radius: 10px;
        background-color: #f9f9f9;
        margin-bottom: 20px;
    }

    .order-info h1 {
        font-size: 24px;
        color: #333;
        margin-bottom: 20px;
    }

    .order-info p {
        margin-bottom: 10px;
        font-size: 16px;
    }

    /* CSS cho nút "Xem chi tiết" */
    .view-details-btn {
        display: inline-block;
        padding: 8px 16px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .view-details-btn:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="header">
    <!-- Mã HTML cho phần header -->
</div>

<div class="border-top">
    <!-- Mã HTML cho phần border-top -->
</div>

<div class="container">
    <!-- Phần đăng nhập -->
    <div class="user-info-container">
        <?php
        // Hiển thị thông tin đăng nhập
        if (isset($_SESSION['dangnhap'])) {
            echo '<h1>Thông Tin Đăng Nhập</h1>';
            echo '<p><strong>Tên Đăng Nhập:</strong> ' . $_SESSION['dangnhap'] . '</p>';
            // Thêm các thông tin khác của người dùng tại đây nếu cần
        } else {
            echo '<p>Không có tài khoản được đăng nhập.</p>';
        }
        ?>
    </div>

    <!-- Lịch sử đơn hàng -->
    <div class="order-info-container">
        <?php
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
                    echo '<h1>Thông Tin Người Dùng</h1>';
                    echo '<div class="user-info">';
                    echo '<p><strong>ID:</strong> ' . $row["id"] . '</p>';
                    echo '<p><strong>Username:</strong> ' . $row["username"] . '</p>';
                    echo '<p><strong>Email:</strong> ' . $row["email"] . '</p>';
                    echo '<p><strong>Địa chỉ:</strong> ' . $row["street"] . ', ' . $row["ward"] . ', ' . $row["district"] . ', ' . $row["city"] . '</p>';
                    echo '<p><strong>Phone:</strong> ' . $row["phonenumber"] . '</p>';
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
                $sql = "SELECT od.*, p.productName, p.price, u.street, u.district, u.ward, u.city, o.order_date
                FROM orders_detail od
                INNER JOIN tbl_products p ON od.pid = p.pid
                INNER JOIN orders o ON od.IDorders = o.IDorders
                INNER JOIN tbl_users u ON o.id = u.id
                WHERE o.id = $user_id";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    echo '<h1>Lịch Sử Đơn Hàng</h1>';

                    // Hiển thị thông tin chi tiết đơn hàng
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="order-info">';
                        echo '<p><strong>ID Detail:</strong> ' . $row["IDorders"] . '</p>';
                        echo '<p><strong>Sản Phẩm:</strong> ' . $row["productName"] . '</p>';
                        echo '<p><strong>Số Lượng:</strong> ' . $row["quantity"] . '</p>';
                        echo '<p><strong>Giá:</strong> ' . $row["price"] . '</p>';
                        echo '<p><strong>Địa chỉ:</strong> ' . $row["street"] . ', ' . $row["ward"] . ', ' . $row["district"] . ', ' . $row["city"] . '</p>';
                        echo '<p><strong>Ngày đặt hàng:</strong> ' . $row["order_date"] . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "Không có thông tin đơn hàng nào được tìm thấy.";
                }
            } else {
                echo "ID người dùng không hợp lệ.";
            }
        }
        ?>
    </div>
</div>

</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
