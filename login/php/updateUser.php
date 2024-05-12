<?php
include "../../require/connect.php";


if (isset($_POST['username'], $_POST['password1'], $_POST['email'], $_POST['phoneNumber'])) {

    $username = $_POST['username'];
    $password = $_POST['password1'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];

    $errors = array();

    $usernameValue = trim($username);
    $passwordValue = trim($password);
    $emailValue = trim($email);
    $phoneNumberValue = trim($phoneNumber);
    $usernamePattern = '/^(?=.*[a-zA-Z])[a-zA-Z0-9]+$/';
    $emailPattern = '/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/';
    $phoneNumberPattern = '/^(0[1-9])+([0-9]{8,9})\b/';

    if (empty($usernameValue)) {
        $errors['username'] = 'Không được bỏ trống tên đăng ký';
    } elseif (!preg_match($usernamePattern, $usernameValue)) {
        $errors['username'] = 'Tên đăng ký không hợp lệ';
    }

        if (!$conn) {
            die("Kết nối không thành công: " . mysqli_connect_error());
        }

    $sql = "INSERT INTO `tbl_users` (`username`, `password`, `email`, `phoneNumber`) VALUES ('$username', '$password', '$email', '$phoneNumber') ";

    if (mysqli_query($conn, $sql)) {
        echo "Lưu dữ liệu thành công";
    } else {
        echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

