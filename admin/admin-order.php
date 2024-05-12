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
</head>
<body style="background-color: #f3f8ff;">
    <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-header">
        
        </div>
        
        <div class="side-content" style="background-color: #f3f8ff; border-right: 1px solid #000;">
            <div class="profile">
                <div class="profile">
                    <img src="/asset/images/1.png" alt="Logo" style="width: 100%; height: auto;">
                    <h3 style="color: #74767d; font-weight: bold;">PET FOOD</h3> 
                </div>
            </div>

            <div class="side-menu">
                <ul>
                    <li style="margin-bottom: 15px;" >
                        <a href="./admin-user.php">
                            <span class="las la-user-alt" style="color:#74767d;"></span>
                            <h3 style="color: #74767d; font-weight: bold;">Khách Hàng</h3>
                        </a>
                    </li>
                
                    <li style="margin-bottom: 15px;">
                        <a href="./admin-product.php">
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
                <div>
                    <label for="status">Tình trạng đơn hàng:</label>
                    <select name="status" id="status">
                        <option value="">Tất cả</option>
                        <option value="hoạt động">Hoạt động</option>
                        <option value="Không hoạt động">Không hoạt động</option>
                    </select>
                </div>
                <div>
                    <label for="start_date">Từ ngày:</label>
                    <input type="date" id="start_date" name="start_date">
                </div>
                <div>
                    <label for="end_date">Đến ngày:</label>
                    <input type="date" id="end_date" name="end_date">
                </div>
                <div>
                    <label for="location">Địa điểm giao hàng:</label>
                    <input type="text" id="location" name="location">
                </div>
                <div>
                    <input type="submit" value="Lọc">
                </div>
            </form>
        </div>
        
        <div class="records table-responsive" >
        
            <div class="record-header">
                <div class="add">
                    <span>Mục</span>
                    <select name="" id="">
                        <option value="">ID</option>
                    </select>
                    
                </div>
        
                <div class="browse">
                    <input type="search" placeholder="Tìm kiếm" class="record-search">
                
                </div>
            </div>
        
            <div>
                <table width="100%" id="table-order">
                    <thead>
                        <tr>
                            <th>Đơn Hàng</th>                          
                            <th> Tên Khách Hàng</th>
                            <th> Số điện thoại </th>
                            <th>Email</th>
                            <th> Số nhà </th>
                            <th> Phường </th>
                            <th> Quận/huyện </th>
                            <th> Thành phố </th>
                            <th> Phương thức </th>
                            <th> Tổng tiền </th>
                            <th> Trang Thái Hoạt Động</th>
                            <th>Ngày đặt hàng</th>
                            <th> Chi Tiết</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // Include the connection file
                            require_once "../require/connect.php";

                            // Khởi tạo các biến để lưu trữ dữ liệu từ form
                            $status = $start_date = $end_date = $location = "";

                            // Kiểm tra xem form đã được gửi chưa
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                // Xử lý và lấy dữ liệu từ form
                                $status = $_POST["status"];
                                $start_date = $_POST["start_date"];
                                $end_date = $_POST["end_date"];
                                $location = $_POST["location"];

                                // SQL query ban đầu
                                $sql = "SELECT * FROM orders WHERE 1=1";

                                // Thêm điều kiện vào truy vấn nếu các trường được điền trong form
                                if (!empty($status)) {
                                    $sql .= " AND status = '$status'";
                                }
                                if (!empty($start_date) && !empty($end_date)) {
                                    $sql .= " AND order_date BETWEEN '$start_date' AND '$end_date'";
                                }
                                if (!empty($location)) {
                                    $sql .= " AND district = '$location'";
                                }

                                // Thực thi truy vấn
                                $result = $conn->query($sql);

                                // Kiểm tra kết quả của truy vấn
                                if ($result->num_rows > 0) {
                                    // Output data of each row
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $row["IDorders"] . "</td>";
                                        echo "<td>" . $row["receiver"] . "</td>";
                                        echo "<td>" . $row["phonenumber"] . "</td>";
                                        echo "<td>" . $row["email"] . "</td>";
                                        echo "<td>" . $row["street"] . "</td>";
                                        echo "<td>" . $row["ward"] . "</td>";
                                        echo "<td>" . $row["district"] . "</td>";
                                        echo "<td>" . $row["city"] . "</td>";
                                        echo "<td>" . $row["method"] . "</td>";
                                        echo "<td>" . $row["total_price"] . "</td>";
                                        echo "<td>" . $row["status"] . "</td>";
                                        echo "<td>" . $row["order_date"] . "</td>";
                                        echo "<td>";
                                        echo "<a href='order-detail-admin.html'>Thông tin</a>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='13'>Không tìm thấy kết quả phù hợp.</td></tr>";
                                }
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
</body>
</html>
