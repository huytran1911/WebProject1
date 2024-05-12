<?php
// Kết nối đến cơ sở dữ liệu
require '../require/connect.php';

// Bắt đầu phiên session nếu chưa được bắt đầu
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem biến $_SESSION['dangnhap'] có tồn tại hay không
if (isset($_SESSION['dangnhap'])) {
    // echo $_SESSION['dangnhap'];
} else {
    // Xử lý trường hợp nếu $_SESSION['dangnhap'] không tồn tại
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
                $sql_user_info = "SELECT * FROM tbl_users WHERE id = ?";
                $stmt = $conn->prepare($sql_user_info);
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result_user_info = $stmt->get_result();

                if ($result_user_info->num_rows > 0) {
                    // Hiển thị thông tin người dùng
                    $row_user_info = $result_user_info->fetch_assoc();
                    echo '<h1>Thông Tin Người Dùng</h1>';
                    echo '<div class="user-info">';
                    echo '<p><strong>ID:</strong> ' . $row_user_info["id"] . '</p>';
                    echo '<p><strong>Username:</strong> ' . $row_user_info["username"] . '</p>';
                    echo '<p><strong>Email:</strong> ' . $row_user_info["email"] . '</p>';
                    echo '<p><strong>Địa chỉ:</strong> ' . $row_user_info["street"] . ', ' . $row_user_info["ward"] . ', ' . $row_user_info["district"] . ', ' . $row_user_info["city"] . '</p>';
                    echo '<p><strong>Phone:</strong> ' . $row_user_info["phonenumber"] . '</p>';
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
                // Bước 1: Tạo một đơn hàng mới và lấy ID của nó
                $sql_create_order = "INSERT INTO orders (user_id, order_date) VALUES (?, NOW())";
                $stmt = $conn->prepare($sql_create_order);
                $stmt->bind_param("i", $user_id); // Giả sử user_id đã được xác định từ phiên đăng nhập
                $stmt->execute();
                $order_id = $stmt->insert_id; // Lấy ID của đơn hàng mới tạo

                // Bước 2: Lưu thông tin chi tiết sản phẩm trong đơn hàng vào cơ sở dữ liệu
                // Lặp qua mỗi sản phẩm trong giỏ hàng và thêm vào bảng orders_detail
                foreach ($_SESSION['cart'] as $product_id => $quantity) {
                    $sql_add_to_order = "INSERT INTO orders_detail (order_id, product_id, quantity) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql_add_to_order);
                    $stmt->bind_param("iii", $order_id, $product_id, $quantity);
                    $stmt->execute();
                }

                // Bước 3: Tính tổng tiền cho đơn hàng
                $total_price = 0;
                $sql_get_order_total = "SELECT p.price, od.quantity FROM orders_detail od INNER JOIN tbl_products p ON od.product_id = p.pid WHERE od.order_id = ?";
                $stmt = $conn->prepare($sql_get_order_total);
                $stmt->bind_param("i", $order_id);
                $stmt->execute();
                $result = $stmt->get_result();
                while ($row = $result->fetch_assoc()) {
                    $total_price += $row['price'] * $row['quantity'];
                }

                // Hiển thị thông tin đơn hàng và tổng tiền
                echo '<h1>Thông Tin Đơn Hàng</h1>';
                echo '<div class="order-info">';
                echo '<p><strong>ID Đơn Hàng:</strong> ' . $order_id . '</p>';
                echo '<p><strong>Tổng Tiền:</strong> ' . $total_price . '</p>';
                echo '</div>';
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
