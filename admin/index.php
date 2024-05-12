<?php
session_start();
require '../require/connect.php';

$error_message = "";

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); // Xóa thông báo lỗi sau khi hiển thị
    echo "<script>alert('{$error_message}');</script>";
} else {
    $error_message = "";
}

if (isset($_POST['dangnhap'])) {
    $taikhoan = $_POST['username'];
    $matkhau = $_POST['password'];

    // Sử dụng prepared statement để tránh SQL injection
    $sql = "SELECT * FROM `tbl_users` WHERE `username` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $taikhoan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['action'] == 0) {
            $_SESSION['error_message'] = "Tài khoản của bạn đã bị khóa và không thể đăng nhập vào trang web.";
            header("Location:userAdmin/admin-user.php");
            exit();
        } else {
            // Kiểm tra mật khẩu sử dụng password_verify
            if (password_verify($matkhau, $row['password'])) {
                if ($row['role'] == 1) {
                    $_SESSION['dangnhap'] = $taikhoan;
                    header("Location: userAdmin/admin-user.php");
                    exit();
                } else {
                    $_SESSION['error_message'] = "Bạn không có quyền truy cập vào trang quản trị.";
                    header("Location: index.php");
                    exit();
                }
            } else {
                $_SESSION['error_message'] = "Tên đăng nhập hoặc mật khẩu không chính xác";
                header("Location: index.php");
                exit();
            }
        }
    } else {
        $_SESSION['error_message'] = "Tên đăng nhập hoặc mật khẩu không chính xác";
        header("Location: index.php");
        exit();
    }
}

$conn->close();
?>






<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang đăng nhập</title>
    <link rel="stylesheet" href="../login/css/styledn.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,300,0,0" />
</head>

<body>
    <div class="login-card-container" id="account">

        <div class="form-container">

            <div class="login-card-header">
                <h1> Vui lòng đăng nhập </h1>
            </div>

            <form id="login" action="index.php" method="post">
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">person</span>
                    <input type="text" placeholder="Tên đăng nhập" id="username" name="username">
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">lock</span>
                    <input type="password" placeholder="Mật khẩu" id="password" name="password">
                </div>
                <button name="dangnhap" value="Đăng nhập" class="btn" type="submit"> Đăng Nhập</button>
                <div class="error-message" style="color: red;">
                    <?php if(isset($errors['login'])) { echo $errors['login']; } ?>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
