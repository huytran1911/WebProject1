<?php
// Bắt đầu phiên session nếu chưa được bắt đầu
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem biến $_SESSION['dangnhap'] có tồn tại hay không
if (isset($_SESSION['dangnhap'])) {
    // Lấy thông tin người dùng từ session
    $username = $_SESSION['dangnhap'];

    // Truy vấn để lấy thông tin người dùng từ cơ sở dữ liệu
    $sql_user = "SELECT * FROM tbl_users WHERE username = '$username'";
    $result_user = mysqli_query($conn, $sql_user);

    // Kiểm tra kết quả truy vấn
    if ($result_user) {
        // Kiểm tra xem có dòng nào được trả về hay không
        if (mysqli_num_rows($result_user) > 0) {
            // Gán giá trị cho biến $row từ kết quả truy vấn
            $row = mysqli_fetch_assoc($result_user);
        } else {
            // Xử lý trường hợp không có dòng nào được trả về từ truy vấn
            echo "Không có thông tin người dùng được tìm thấy.";
        }
    } else {
        // Xử lý trường hợp truy vấn không thành công
        echo "Lỗi truy vấn cơ sở dữ liệu";
    }
} else {
    // Xử lý trường hợp nếu $_SESSION['dangnhap'] không tồn tại
    echo "Không có tài khoản được đăng nhập";
}
?>



    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="index.php" class="logo">
                    <img src="images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="trangsp/trangspchinh/trangspchinh.php">Cửa Hàng</a></li>
                    <li><a href="Lienhe/Lienhe.html">Liên hệ</a></li>

                </ul>
                <div class="nav-icon">
                    <a href="login/html/dangnhap.html"><i class='bx bx-cart'></i></a>
                    <a href="page/user.php?id=<?php echo $row["id"]; ?>"><i class='bx bx-user'></i> <?php echo $_SESSION['dangnhap']; ?></a>
                    <a href="page/logout.php">dangxuat</a>

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
                echo "<li><a href='./trangsp/trangspchinh/loaisp.php?cateid=" . $row_category['cateid'] . "'>" . $row_category['categoryName'] . "</a></li>";

            }
        } else {
            echo "<li><a href='#'>Không có danh mục</a></li>";
        }
        ?>
    </ul>
        <img class="images" src="./images/logo image/SnakeBoardgame.png" alt="">

        
            </div>
        </div>
    </div>

    

    <div class="feature">
        <div class="ft-cover">
            <div class="ft-box">
                <a><img class="feature-img" src="images/feature images/f1.png" alt=""></a>
                <h5>Miễn phí giao hàng</h5>
            </div>
            <div class="ft-box">
                <a><img class="feature-img" src="images/feature images/f2.png" alt=""></a>
                <h5>Đặt hàng online</h5>
            </div>
            <div class="ft-box">
                <a><img class="feature-img" src="images/feature images/f3.png" alt=""></a>
                <h5>Tiết kiệm chi phí</h5>
            </div>
            <div class="ft-box">
                <a><img class="feature-img" src="images/feature images/f4.png" alt=""></a>
                <h5>Khuyến mãi</h5>
            </div>
            <div class="ft-box">
                <a><img class="feature-img" src="images/feature images/f5.png" alt=""></a>
                <h5>Hỗ trợ 24/7</h5>
            </div>
        </div>
    </div>