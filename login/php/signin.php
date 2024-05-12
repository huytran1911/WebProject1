<?php
session_start();
include "../../require/connect.php";

$errors = []; // Khởi tạo mảng lưu trữ các thông báo lỗi

if (isset($_POST['dangnhap'])) {
    $taikhoan = $_POST['username'];
    $matkhau = $_POST['password'];

    $sql = "SELECT * FROM tbl_users WHERE username='$taikhoan'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            if ($row['action'] == 1) {
                $errors['login'] = 'Tài khoản của bạn đã bị khoá và không thể đăng nhập vào trang web.';
            } else {
                if (password_verify($matkhau, $row['password'])) {
                    $_SESSION['dangnhap'] = $taikhoan;
                    header("Location:../../index.php");
                    exit(); // Thêm lệnh exit() sau khi chuyển hướng
                } else {
                    $errors['login'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
                }
            }
        } else {
            $errors['login'] = 'Tên đăng nhập hoặc mật khẩu không chính xác';
        }
    } else {
        echo "Lỗi truy vấn: " . mysqli_error($conn);
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
    <link rel="stylesheet" href="../../login/css/styledn.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,300,0,0" />
</head>

<body>
    <div class="login-card-container" id="account">

        <div class="form-container">

            <div class="login-card-header">
                <h1> Vui lòng đăng nhập </h1>

            </div>
            <form id="login" action="signin.php" method="post">
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">person</span>
                    <input type="text" placeholder="Tên đăng nhập" id="username" name="username"> <!--Thêm thuộc tính name-->
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">lock</span>
                    <input type="password" placeholder="Mật khẩu" id="password" name="password"> <!--Thêm thuộc tính name-->
                </div>
                <div class="form-item-other">
                  
                </div>
                <button name="dangnhap" value="Đăng nhập" class="btn" type="submit" > Đăng Nhập</button>
                <div  class="error-message" style="color: red;">
    <?php if(isset($errors['login'])) { echo $errors['login']; } ?>
</div>

            </form>
        </div>
        <div class="login-card-footer">
            Bạn chưa có tài khoản ?<a href="../php/register.php">Đăng ký</a>
        </div>
    </div>
</body>

</html>
