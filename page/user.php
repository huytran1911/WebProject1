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
    <!-- Phần head của HTML -->
</head>
<body>
    <!-- Phần body của HTML -->

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

                // Khởi động mảng để lưu trữ thông tin đơn hàng
                $orderDetails = array();

                // Lặp qua kết quả truy vấn
                while ($row = $result->fetch_assoc()) {
                    // Kiểm tra xem IDorders đã được thêm vào mảng chưa
                    if (!isset($orderDetails[$row["IDorders"]])) {
                        // Nếu chưa, thêm IDorders vào mảng với thông tin đơn hàng
                        $orderDetails[$row["IDorders"]] = array(
                            "IDorders" => $row["IDorders"],
                            "street" => $row["street"],
                            "ward" => $row["ward"],
                            "district" => $row["district"],
                            "city" => $row["city"],
                            "order_date" => $row["order_date"],
                            "total_price" => 0, // Khởi tạo tổng giá trị của đơn hàng
                            "products" => array() // Mảng để lưu trữ thông tin sản phẩm
                        );
                    }

                    // Thêm thông tin sản phẩm vào mảng sản phẩm của đơn hàng
                    $orderDetails[$row["IDorders"]]["products"][] = array(
                        "productName" => $row["productName"],
                        "price" => $row["price"]
                    );

                    // Tính tổng giá trị của đơn hàng
                    $orderDetails[$row["IDorders"]]["total_price"] += $row["price"];
                }

                // Hiển thị thông tin đơn hàng
                echo '<h1>Lịch Sử Đơn Hàng</h1>';
                foreach ($orderDetails as $order) {
                    echo '<div class="order-info">';
                    echo '<p><strong>ID Detail:</strong> ' . $order["IDorders"] . '</p>';
                    // Hiển thị thông tin sản phẩm
                    foreach ($order["products"] as $product) {
                        // echo '<p><strong>Sản Phẩm:</strong> ' . $product["productName"] . '</p>';
                        // echo '<p><strong>Giá:</strong> ' . $product["price"] . '</p>';
                    }
                    echo '<p><strong>Tổng Giá Trị:</strong> ' . $order["total_price"] . '</p>';
                    echo '<p><strong>Địa chỉ:</strong> ' . $order["street"] . ', ' . $order["ward"] . ', ' . $order["district"] . ', ' . $order["city"] . '</p>';
                    echo '<p><strong>Ngày đặt hàng:</strong> ' . $order["order_date"] . '</p>';
                    // Tạo nút xem chi tiết đơn hàng
        echo '<form action="chitiethd.php" method="post">';
        echo '<input type="hidden" name="order_id" value="' . $order["IDorders"] . '">';
        echo '<input type="submit" value="Xem Chi Tiết">';
        echo '</form>';
        echo '</div>';
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

</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
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