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
    // echo "Không có tài khoản được đăng nhập";
}
?>



    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../index.php" class="logo">
                    <img src="../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../index.php">Trang chủ</a></li>
                    <li><a href="../trangsp/trangspchinh/trangspchinh.php">Cửa Hàng</a></li>
                    <li><a href="../Lienhe/Lienhe.php">Liên hệ</a></li>

                </ul>
                <div class="nav-icon">
                    <a href="../login/php/signin.php"><i class='bx bx-cart'></i></a>
                    <a href="../login/php/signin.php"><i class='bx bx-user'></i> </a>
                    

                </div>
            </div>
        </div>
    </div>

    

    

    