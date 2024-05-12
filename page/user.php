<?php
    session_start();
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










    <!DOCTYPE html>
    <html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông Tin Người Dùng</title>
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
    <div class="container">
        
    </div>
    </body>
    </html>
