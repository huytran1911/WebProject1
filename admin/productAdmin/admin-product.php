<?php
// Kết nối đến cơ sở dữ liệu
require_once "../../require/connect.php";

// Kiểm tra xem có dữ liệu được gửi từ form không
if(isset($_POST['IDorders'])) {
    // Lấy ID đơn hàng từ form
    $order_id = $_POST['IDorders'];

    // Cập nhật trạng thái của sản phẩm sau khi đặt hàng thành công
    $sql = "UPDATE tbl_products 
            SET status = 1 
            WHERE pid IN (SELECT pid FROM tbl_order_details WHERE IDorders = $order_id)";
    
    $result_update = mysqli_query($conn, $sql);

    // Kiểm tra kết quả của câu truy vấn
    if($result_update) {
        echo "Cập nhật trạng thái sản phẩm thành công!";
    } else {
        echo "Lỗi: " . mysqli_error($conn);
    }
} else {
    echo "Không có dữ liệu được gửi từ form!";
}

// Truy vấn lấy dữ liệu sản phẩm
$sql_products = "SELECT tbl_products.*, tbl_category.*
                FROM tbl_products
                JOIN tbl_category ON tbl_products.cid = tbl_category.cateid
                ORDER BY pid ASC";
$result_products = mysqli_query($conn, $sql_products);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin</title>
    <link rel="stylesheet" href="../admin-css/admin.css">
    <link rel="icon" type="image/png" href="assets/img/LOGO.webp">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <style>
        .product-image {
            max-width: 200px;
            max-height: 200px;
            width: auto;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body style="background-color: #f3f8ff;">

<input type="checkbox" id="menu-toggle">
<div class="sidebar">
    <div class="side-header"></div>
    <div class="side-content" style="background-color: #f3f8ff; border-right: 1px solid #000;">
        <div class="profile">
            <img src="/asset/images/1.png" alt="Logo" height: auto;">
            <h3 style="color: #74767d; font-weight: bold;">PET FOOD</h3>
        </div>
        <div class="side-menu">
            <ul>
                <li style="margin-bottom: 15px;">
                    <a href="../userAdmin/admin-user.php">
                        <span class="las la-user-alt" style="color:#74767d;"></span>
                        <h3 style="color: #74767d; font-weight: bold;">Khách Hàng</h3>
                    </a>
                </li>
                <li style="margin-bottom: 15px;">
                    <a href="./Category.php">
                        <span class="las la-address-card" style="color: #74767d;"></span>
                        <h3 style="color: #74767d; font-weight: bold;">Danh Mục</h3>
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
    <main>
        <div class="page-content">
            <h1 style="padding: 1.3rem 0rem;color: #74767d; margin-left: 55px;" id="product">Sản Phẩm </h1>
            <div class="user-tab" style="margin-left: 55px;">
                <div class="user-input"></div>
                <div class="user-input" style="display: none;"></div>
                <div class="user-input"></div>
                <div class="user-input"></div>
                <div class="user-input"></div>
                <div>
                    <a href="./addProduct.php"><button onclick="addHtmlTableRow1();">Thêm +</button></a>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <div class=".record-header"></div>
            <div>
                <table  id="table-product">
                    <thead>
                    <tr>
                        <th style="text-align: center; width: 10%;">Mã Sản Phẩm</th>
                        <th style="text-align: center; width: 10%;">Hình Ảnh Sản Phẩm</th>
                        <th style="text-align: center; width: 20%;">Tên Sản Phẩm</th>
                        <th style="text-align: center; width: 10%;">Giá</th>
                        <th style="text-align: center; width: 10%;">Danh Mục</th>
                        <th style="text-align: center; width: 20%;">Mô tả</th>
                        <th style="text-align: center; width: 5%;">Số lượng</th>
                        <th style="text-align: center; width: 8%;">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(mysqli_num_rows($result_products) > 0) {
                        while($row = mysqli_fetch_array($result_products)) {
                            // Code hiển thị dữ liệu
                            echo "<tr>";
                            echo "<td style='text-align: center'>" . $row['pid'] . "</td>";
                            echo "<td style='text-align: center'><img class='product-image' src='../productAdmin/uploads/" . $row['img'] . "' alt='Hình ảnh sản phẩm'></td>";
                            echo "<td style='text-align: center'>" . $row['productName'] . "</td>";
                            echo "<td style='text-align: center'>" . number_format($row['price'], 0, ',', '.') . "đ</td>";
                            echo "<td style='text-align: center'>" . $row['categoryName'] . "</td>";
                            echo "<td style='text-align: center'>" . $row['detail'] . "</td>";
                            echo "<td style='text-align: center'>" . $row['quantity'] . "</td>";
                            echo '<td style="text-align: center;">
                                    <a href="./updateProduct.php?pid=' . $row['pid'] . '"><button class="btn btn-primary">Sửa</button></a>
                                    <a onclick="return confirmDeleteProduct(' . $row['pid'] . ')" href="./deleteProduct.php?pid=' . $row['pid'] . '">
                                        <button class="btn btn-danger">Xoá</button>
                                    </a>
                                </td>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Không có dữ liệu</td></tr>";
                    }
                    ?>
                    
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- Hiển thị liên kết phân trang -->
    <div class="pagination" style="margin-top: 20px; text-align: center;">
        <?php
        if ($page > 1) {
            echo "<a href='admin-product.php?page=" . ($page - 1) . "'>&laquo;</a>";
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            if ($i == $page) {
                echo "<span class='current' style='display: inline-block; padding: 5px 10px; margin: 0 2px; border: 1px solid #007bff; border-radius: 3px; color: #007bff; text-decoration: none; background-color: #007bff; color: white;'>$i</span>";
            } else {
                echo "<a href='admin-product.php?page=$i' style='display: inline-block; padding: 5px 10px; margin: 0 2px; border: 1px solid #007bff; border-radius: 3px; color: #007bff; text-decoration: none;'>$i</a>";
            }
        }
        if ($page < $total_pages) {
            echo "<a href='admin-product.php?page=" . ($page + 1) . "'>&raquo;</a>";
        }
        ?>
    </div>
</div>
</body>
</html>
<script>
    function confirmDeleteProduct(productId) {
        // Kiểm tra trạng thái của sản phẩm
        var result = confirm("Bạn có chắc chắn muốn xoá sản phẩm này?");
        if (result) {
            // Nếu người dùng đồng ý xoá, tiến hành xoá sản phẩm
            return true;
        } else {
            // Người dùng không đồng ý, ngăn không cho xoá sản phẩm
            return false;
        }
    }
</script>
