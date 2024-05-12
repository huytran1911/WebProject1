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

        <body>
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

// Kiểm tra xem ID đơn hàng được truyền từ URL có tồn tại và không rỗng
if (isset($_POST['order_id']) && !empty($_POST['order_id'])) {
    // Lấy ID đơn hàng từ URL
    $order_id = $_POST['order_id'];

    // Kiểm tra xem ID có phải là một số nguyên dương hay không
    if (filter_var($order_id, FILTER_VALIDATE_INT) && $order_id > 0) {
        // Truy vấn dữ liệu chi tiết đơn hàng từ bảng orders_detail và tbl_products dựa trên ID đơn hàng
        $sql = "SELECT od.*, p.productName, p.price, u.street, u.district, u.ward, u.city, o.order_date
        FROM orders_detail od
        INNER JOIN tbl_products p ON od.pid = p.pid
        INNER JOIN orders o ON od.IDorders = o.IDorders
        INNER JOIN tbl_users u ON o.id = u.id
        WHERE od.IDorders = $order_id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
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
            echo '<h1>Chi Tiết Đơn Hàng</h1>';
            foreach ($orderDetails as $order) {
                echo '<div class="order-info">';
                echo '<p><strong>Mã Đơn Hàng:</strong> ' . $order["IDorders"] . '</p>';
                echo '<p><strong>Người Nhận:</strong> ' . $order["receiver"] . '</p>';
                echo '<p><strong>Địa chỉ:</strong> ' . $order["street"] . ', ' . $order["ward"] . ', ' . $order["district"] . ', ' . $order["city"] . '</p>';
                echo '<p><strong>Ngày đặt hàng:</strong> ' . $order["order_date"] . '</p>';
                echo '<p><strong>Sản Phẩm:</strong></p>';
                // Hiển thị thông tin sản phẩm
                foreach ($order["products"] as $product) {
                    echo '<p>- ' . $product["productName"] . ': ' . $product["price"] . '</p>';
                }
                echo '<p><strong>Tổng Giá Trị:</strong> ' . $order["total_price"] . '</p>';
                echo '</div>';
            }
        } else {
            echo "Không có thông tin đơn hàng nào được tìm thấy.";
        }
    } else {
        echo "ID đơn hàng không hợp lệ.";
    }
} else {
    echo "ID đơn hàng không được cung cấp.";
}

// Đóng kết nối
$conn->close();
?>










        </body>