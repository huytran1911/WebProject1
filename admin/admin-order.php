<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Admin-order</title>
    <link rel="stylesheet" href="./admin-css/admin.css">
    <link rel="icon" type="image/png" href="assets/img/LOGO.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        /* CSS for filter form */
        .page-content form {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .page-content form label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .page-content form select,
        .page-content form input[type="text"],
        .page-content form input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .page-content form input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        .page-content form input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Thêm màu sắc cho các tình trạng khác nhau */
        .page-content table td.status-chua-giao {
            color: #ff0000; /* Màu đỏ */
            cursor: pointer; /* Biến con trỏ thành bàn tay khi di chuột qua */
        }

        .page-content table td.status-da-giao {
            color: #008000; /* Màu xanh lá cây */
            cursor: pointer; /* Biến con trỏ thành bàn tay khi di chuột qua */
        }
    </style>
</head>
<body style="background-color: #f3f8ff;">
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
            <!-- Header content -->
        </div>
        
        <div class="side-content" style="background-color: #f3f8ff; border-right: 1px solid #000;">
            <div class="profile">
                <img src="../../images/logo image/Logo image.png" alt="Logo" style="height: auto; width: 100px;">
                <h3 style="color: #74767d; font-weight: bold;">Snake boardgame</h3>
            </div>
            <div class="side-menu">
                <ul>
                    <li style="margin-bottom: 15px;">
                        <a href="./productAdmin/admin-product.php">
                            <span class="las la-user-alt" style="color:#74767d;"></span>
                            <h3 style="color: #74767d; font-weight: bold;">Khách Hàng</h3>
                        </a>
                    </li>
                    <li style="margin-bottom: 15px;">
                        <a href="./productAdmin/Category.php">
                            <span class="las la-address-card" style="color: #74767d;"></span>
                            <h3 style="color: #74767d; font-weight: bold;">Danh Mục</h3>
                        </a>
                    </li>
                    <li style="margin-bottom: 15px;">
                        <a href="./userAdmin/admin-user.php">
                            <span class="las la-clipboard-list" style="color:#74767d;"></span>
                            <h3 style="color: #74767d; font-weight: bold;">Sản Phẩm</h3>
                        </a>
                    </li>
                    <li style="margin-bottom: 15px;">
                        <a href="./admin-order.php">
                            <span class="las la-shopping-cart" style="color:#74767d;"></span>
                            <h3 style="color: #74767d; font-weight: bold;">Đơn Hàng</h3>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="main-content" style="background-color: #f3f8ff;">
        <header>
            <div class="header-content">
                <label for="menu-toggle" id="bar-admin">
                    <span class="las la-bars" style="font-size: 28px; margin-top: 8px;"></span>
                </label>
                
                <div class="header-menu">
                    <div class="user" style="margin-right: 8px; margin-top: -30px;">
                        <div class="bg-img" style="background-image: url()"></div>
                        <span style="font-size: 25px;cursor: pointer;" onclick="window.location.href='admin.html'"></span>
                        <span style="font-size: 20px; cursor: pointer; color:#74767d ; font-weight: 600;" onclick="window.location.href='admin.html'">Trang chủ</span>
                    </div>
                </div>
            </div>
        </header>
        <div class="page-content" style="margin-top: 50px; background-color: #fef5f5;">
            <h1 style="padding: 1.3rem 0rem;color: #74767d;" id="order">Đơn Hàng</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" style="margin-bottom: 20px;">
                <!-- Form content -->
                <label for="status">Trạng thái:</label>
                <select name="status" id="status">
                    <option value="">Tất cả</option>
                    <option value="0">Chưa giao hàng</option>
                    <option value="1">Đã giao hàng thành công</option>
                </select>
                <label for="start_date">Từ ngày:</label>
                <input type="date" id="start_date" name="start_date">
                <label for="end_date">Đến ngày:</label>
                <input type="date" id="end_date" name="end_date">
                <label for="street">Số nhà:</label>
                <input type="text" id="street" name="street" placeholder="Nhập số nhà...">
                <label for="ward">Phường/Xã:</label>
                <input type="text" id="ward" name="ward" placeholder="Nhập phường/xã...">
                <label for="district">Quận/Huyện:</label>
                <input type="text" id="district" name="district" placeholder="Nhập quận/huyện...">
                <label for="city">Tỉnh/Thành phố:</label>
                <input type="text" id="city" name="city" placeholder="Nhập tỉnh/thành phố...">

                <input type="submit" value="Lọc">
            </form>
        </div>
        
        <div class="records table-responsive" >
            <div class="record-header">
                <!-- Record header content -->
            </div>
            <div>
                <table width="100%" id="table-order">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Email</th>
                            <th>Số nhà</th>
                            <th>Phường/Xã</th>
                            <th>Quận/Huyện</th>
                            <th>Tỉnh/Thành phố</th>
                            <th>Phương thức thanh toán</th>
                            <th>Giá trị đơn hàng</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt hàng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                            require_once "../require/connect.php";

                            $status = $start_date = $end_date = $street = $ward = $district = $city = "";

                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $status = $_POST["status"];
                                $start_date = $_POST["start_date"];
                                $end_date = $_POST["end_date"];
                                $street = $_POST["street"];
                                $ward = $_POST["ward"];
                                $district = $_POST["district"];
                                $city = $_POST["city"];

                                $sql = "SELECT * FROM orders WHERE 1=1";

                                if (!empty($status)) {
                                    $sql .= " AND status = '$status'";
                                }
                                if (!empty($start_date) && !empty($end_date)) {
                                    $sql .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
                                }
                                if (!empty($street)) {
                                    $sql = "SELECT * FROM orders WHERE street LIKE '%$street%'";
                                }
                                if (!empty($ward)) {
                                    $sql .= " AND ward LIKE '%$ward%'";
                                }
                                if (!empty($district)) {
                                    $sql .= " AND district LIKE '%$district%'";
                                }
                                if (!empty($city)) {
                                    $sql .= " AND city LIKE '%$city%'";
                                }
                            } else {
                                $sql = "SELECT * FROM orders";
                            }

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    if ($status === "" || $row["status"] == $status) {
                                    echo "<tr>";
                                    echo "<td>" . $row["IDorders"] . "</td>";
                                    echo "<td>" . $row["receiver"] . "</td>";
                                    echo "<td>" . $row["phonenumber"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["street"] . "</td>";
                                    echo "<td>" . $row["ward"] . "</td>";
                                    echo "<td>" . $row["district"] . "</td>";
                                    echo "<td>" . $row["city"] . "</td>";
                                    // Thay đổi phương thức thanh toán từ số sang văn bản
                                    echo "<td>";
                                    if ($row["method"] == 1) {
                                        echo "Thanh toán bằng tiền mặt";
                                    } elseif ($row["method"] == 2) {
                                        echo "Chuyển khoản ngân hàng";
                                    } else {
                                        echo "Không rõ";
                                    }
                                    echo "</td>";
                                    echo "<td>" . $row["total_price"] . "</td>";
                                    // Hiển thị trạng thái đơn hàng dưới dạng văn bản
                                    echo "<td class='" . ($row["status"] == 0 ? "status-chua-giao" : "status-da-giao") . "' data-id='" . $row["IDorders"] . "'>";
                                    echo $row["status"] == 0 ? "Chưa giao hàng" : "Đã giao hàng thành công";
                                    echo "</td>";
                            
                                    echo "<td>" . $row["order_date"] . "</td>";
                                    echo "<td>";
                                    echo "<button onclick='updateOrderStatus(" . $row['IDorders'] . ")'>Cập nhật trạng thái</button>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } 
                        }else {
                                echo "<tr><td colspan='13'>Không tìm thấy kết quả phù hợp.</td></tr>";
                            }                            
                            $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div> 
        <main >
        </main>
    </div>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script>
    function updateOrderStatus(orderId) {
        // Tạo một đối tượng XMLHttpRequest
        var xhttp = new XMLHttpRequest();

        // Thiết lập hàm xử lý sự kiện khi yêu cầu được gửi đi
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // Kiểm tra kết quả trả về từ trang update-order-status.php
                var response = JSON.parse(this.responseText);
                if (response.status === "success") {
                    // Nếu cập nhật thành công, thay đổi trạng thái đơn hàng trên giao diện
                    var cell = document.querySelector("#table-order td.status-chua-giao[data-id='" + orderId + "']");
                    cell.textContent = "đã giao hàng thành công"; // Thay đổi văn bản
                    cell.classList.remove("status-chua-giao"); // Xóa class cũ
                    cell.classList.add("status-da-giao"); // Thêm class mới
                } else {
                    // Nếu có lỗi, hiển thị thông báo lỗi
                    alert(response.message);
                }
            }
        };

        // Gửi yêu cầu POST đến trang update-order-status.php với ID của đơn hàng
        xhttp.open("POST", "update-order-status.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("IDorders=" + orderId);
    }
    </script>
</body>
</html>
