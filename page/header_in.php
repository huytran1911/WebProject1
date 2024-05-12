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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="./assets/css/main.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="images/logo image/Logo image.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <title>SnakeBoardgame</title>

</head>

    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../index.php" class="logo">
                    <img src="../images/logo image/Logo image.png" alt="">
                </a>
                <ul class="nav-bar">
                    <li><a href="../index.php">Trang chủ</a></li>
                    <li><a href="../trangsp/trangspchinh/trangspchinh.php">Cửa Hàng</a></li>
                    <li><a href="../Lienhe/Lienhe.php">Liên hệ</a></li>

                </ul>
                <div class="nav-icon">
                    <a href="cart.php"><i class='bx bx-cart'></i></a>
                    <a href="page/user.php?id=<?php echo $row["id"]; ?>"><i class='bx bx-user'></i> <?php echo $_SESSION['dangnhap']; ?></a>
                    <a href="page/logout.php">dangxuat</a>

                </div>
            </div>
        </div>
    </div>

    