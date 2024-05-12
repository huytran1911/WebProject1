<?php
include "../../require/connect.php";

function validateData($username, $password, $email, $phoneNumber,$street,$ward,$district, $city) {
    $errors = array();

    $usernameValue = trim($username);
    $passwordValue = trim($password);
    $emailValue = trim($email);
    $phoneNumberValue = trim($phoneNumber);
    $streetValue = trim($street);
    $wardValue = trim($ward);
    $districtValue = trim($district);
    $cityValue = trim($city);

    $usernamePattern = '/^(?=.*[a-zA-Z])[a-zA-Z0-9]+$/';
    $emailPattern = '/^([a-zA-Z0-9_.-])+@(([a-zA-Z0-9-])+.)+([a-zA-Z0-9]{2,4})+$/';
    $phoneNumberPattern = '/^(0[1-9])+([0-9]{8,9})\b/';

    if (empty($usernameValue)) {
        $errors['username'] = 'Không được bỏ trống tên đăng ký';
    } elseif (!preg_match($usernamePattern, $usernameValue)) {
        $errors['username'] = 'Tên đăng ký không hợp lệ';
    }

    if (empty($emailValue)) {
        $errors['email'] = 'Không được bỏ trống email';
    } elseif (!preg_match($emailPattern, $emailValue)) {
        $errors['email'] = 'Email không hợp lệ';
    }

    if (empty($passwordValue)) {
        $errors['password'] = 'Không được bỏ trống mật khẩu';
    } elseif (strlen($passwordValue) < 6) {
        $errors['password'] = 'Mật khẩu phải lớn hơn 6 ký tự';
    }

    if ($passwordValue !== $_POST['password2']) {
        $errors['password2'] = 'Xác nhận mật khẩu không khớp';
    }

    if (empty($phoneNumberValue)) {
        $errors['phoneNumber'] = 'Không được bỏ trống số điện thoại';
    } elseif (!preg_match($phoneNumberPattern, $phoneNumberValue)) {
        $errors['phoneNumber'] = 'Số điện thoại không hợp lệ';
    }

    if (empty($streetValue)) {
        $errors['street'] = 'Không được bỏ trống địa chỉ';
    }

    if (empty($wardValue)) {
        $errors['ward'] = 'Không được bỏ trống phường/xã';
    }

    if (empty($districtValue)) {
        $errors['district'] = 'Không được bỏ trống quận/huyện';
    }

    if (empty($cityValue)) {
        $errors['city'] = 'Không được bỏ trống thành phố/tỉnh';
    }

    return $errors;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password1'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['phoneNumber'];
    $street = $_POST ['street'];
    $ward = $_POST ['ward'];
    $district = $_POST ['district'];
    $city = $_POST ['city'];
    // Kiểm tra dữ liệu
    $errors = validateData($username, $password, $email, $phoneNumber,$street,$ward,$district,$city );

    // Biến để kiểm tra xem đã hiển thị thông báo lỗi chưa
 

    // Nếu không có lỗi, thêm vào cơ sở dữ liệu
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash mật khẩu trước khi lưu vào cơ sở dữ liệu

        $sql = "INSERT INTO `tbl_users` (`username`, `password`, `email`, `phoneNumber`, `street`,`ward`,`district`,`city` ) VALUES ('$username', '$hashedPassword', '$email', '$phoneNumber', '$street','$ward','$district','$city') ";

        if (mysqli_query($conn, $sql)) {
            echo "Lưu dữ liệu thành công";
            header('Location:./signin.php');
        } else {
            echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Trang đăng ký</title>
    <link rel="stylesheet" href="../../login/css/styledk.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,300,0,0" />
</head>

<body>
    <div class="register-card-container" id="account">
        <div class="form-container">
            <div class="register-card-header">
                <h1>ĐĂNG KÝ</h1>
            </div>
            <form id="register" action="" method="post">
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">person</span>
                    <input type="text" placeholder="Tên đăng ký" id="username" name="username">
                    <span class="text-danger"><?php if(isset($errors['username'])) echo $errors['username']; ?></span>
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">lock</span>
                    <input type="password" placeholder="Nhập mật khẩu" id="password1" name="password1">
                    <span class="text-danger"><?php if(isset($errors['password'])) echo $errors['password']; ?></span>
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">lock</span>
                    <input type="password" placeholder="Xác nhận lại mật khẩu" id="password2" name="password2">
                    <span class="text-danger"><?php if(isset($errors['password2'])) echo $errors['password2']; ?></span>
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">email</span>
                    <input type="text" placeholder="Điền địa chỉ Email" id="email" name="email">
                    <span class="text-danger"><?php if(isset($errors['email'])) echo $errors['email']; ?></span>
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">smartphone</span>
                    <input type="text" placeholder="Số điện thoại" id="phoneNumber" name="phoneNumber">
                    <span class="text-danger"><?php if(isset($errors['phoneNumber'])) echo $errors['phoneNumber']; ?></span>
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">location_on</span>
                    <input type="text" placeholder="Địa chỉ" id="street" name="street">
                    <span class="text-danger"><?php if(isset($errors['street'])) echo $errors['street']; ?></span>
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">location_on</span>
                    <input type="text" placeholder="Phường/Xã" id="ward" name="ward">
                    <span class="text-danger"><?php if(isset($errors['ward'])) echo $errors['ward']; ?></span>
                </div>
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">location_on</span>
                    <input type="text" placeholder="Quận/Huyện" id="district" name="district">
                    <span class="text-danger"><?php if(isset($errors['district'])) echo $errors['district']; ?></span>
                </div>
                
                <div class="form-item">
                    <span class="form-item-icon material-symbols-rounded">location_on</span>
                    <input type="text" placeholder="Thành phố/Tỉnh" id="city" name="city">
                    <span class="text-danger"><?php if(isset($errors['city'])) echo $errors['city']; ?></span>
                </div>

                <button class="btn" type="submit" id="myButton"> Đăng ký </button>
            </form>
        </div>
        <div class="login-card-footer">
            Bạn đã có tài khoản ?<a href="../php/signin.php">Đăng nhập</a>  
        </div>
    </div>
</body>

</html>

