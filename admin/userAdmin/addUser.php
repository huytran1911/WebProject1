<?php
require "../../require/connect.php";
require "../function.php";

$id = $name = $email = $phonenumber = $password = $street = $ward = $district = $city = "";
$name_err = $email_err = $phone_err = $password_err = $street_err = $ward_err = $district_err = $city_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if(isset($_POST["name"])) {
        $input_name = trim($_POST["name"]);
        
        if (empty($input_name)) {
            $name_err = "Hãy nhập tên.";
        } else if (!preg_match("/^[a-zA-Z'-.\s+]+$/", $input_name)) {
            $name_err = "Tên không hợp lệ";
        } else {
            $name = $input_name;
        }
    }

    if(isset($_POST['password'])){
        $input_password = trim($_POST["password"]);

        if(empty($input_password)){
            $password_err = "Hãy nhập mật khẩu";
        } else {
            $password = $input_password;
        }
    }
    
    if(isset($_POST["email"])) {
        $input_email = trim($_POST["email"]);
        
        if (empty($input_email)) {
            $email_err = "Hãy nhập email";
        } else if (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Email không hợp lệ";
        } else {
            $email = $input_email;
        }
    }
    
    if(isset($_POST["phonenumber"])) {
        $input_phonenumber = trim($_POST["phonenumber"]);
        
        if (empty($input_phonenumber)) {
            $phone_err = "Hãy nhập số điện thoại";
        } else if (!preg_match('/(((\+|)84)|0)(3|5|7|8|9)+([0-9]{8})\b/', $input_phonenumber)) {
            $phone_err = "Số điện thoại không hợp lệ";
        } else {
            $phonenumber = $input_phonenumber;
        }
    }

    if(isset($_POST['password'])){
        $input_password = trim($_POST["password"]);

        if(empty($input_password)){
            $password_err = "Hãy nhập mật khẩu";
        } else {
            $password = password_hash($input_password, PASSWORD_DEFAULT);
        }
    }

    if(isset($_POST['street'])){
        $input_street = trim($_POST["street"]);

        if(empty($input_street)){
            $street_err = "Hãy nhập số nhà";
        } else {
            $street = $input_street;
        }
    }

    if(isset($_POST['ward'])){
        $input_ward = trim($_POST["ward"]);

        if(empty($input_ward)){
            $ward_err = "Hãy nhập phường";
        } else {
            $ward = $input_ward;
        }
    }

    if(isset($_POST['district'])){
        $input_district = trim($_POST["district"]);

        if(empty($input_district)){
            $district_err = "Hãy nhập quận/huyện";
        } else {
            $district = $input_district;
        }
    }

    if(isset($_POST['city'])){
        $input_city = trim($_POST["city"]);

        if(empty($input_city)){
            $city_err = "Hãy nhập thành phố";
        } else {
            $city = $input_city;
        }
    }

    // check lỗi input trước khi insert vào database
    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($street_err) && empty($password_err) && empty($ward_err) && empty($district_err)&& empty($city_err)) {
        // insert vào database
        $sql = "INSERT INTO tbl_users (id, username, password, email, phonenumber, street, ward, disctrict, city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            mysqli_stmt_bind_param($stmt, "isssss", $param_id, $param_name, $param_password, $param_email, $param_phonenumber, $param_street, $param_ward, $param_district, $param_city);

            $param_uid = $id;
            $param_name = $name;
            $param_password = $password;
            $param_email = $email;
            $param_phonenumber = $phonenumber;
            $param_street = $street;
            $param_ward = $ward;
            $param_district = $district;
            $param_city = $city;

            // Tiến hành thực thi
            if (mysqli_stmt_execute($stmt)) {
                // Khi thực thi thành công thì sẽ quay về trang admin-user.php
                redirect("./admin-user.php");
                exit();
            } else {
                echo "Đã xảy ra lỗi.";
            }
        }
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Thêm người dùng mới</title>
    <style>
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2> Thêm người dùng mới </h2>
                        <form method="post">
                            <div class="form-group">
                                <label>Tên</label>
                                <input type="text" name="name" id="name" class="form-control">
                                <?php if(!empty($name_err)){
                                    echo '<span class="text-danger">'.$name_err.'</span>';
                                } ?>
                            </div>

                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" name="password" id="password" class="form-control">
                                <span class="text-danger"><?php echo $password_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control">
                                <span class="text-danger"><?php echo $email_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="tel" name="phonenumber" id="phonenumber" class="form-control">
                                <span class="text-danger"><?php echo $phone_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Số nhà</label>
                                <input type="text" name="street" id="street" class="form-control">
                                <span class="text-danger"><?php echo $street_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Phường</label>
                                <input type="text" name="ward" id="ward" class="form-control">
                                <span class="text-danger"><?php echo $ward_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Quận/huyện</label>
                                <input type="text" name="district" id="district" class="form-control">
                                <span class="text-danger"><?php echo $district_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Thành phố</label>
                                <input type="text" name="city" id="city" class="form-control">
                                <span class="text-danger"><?php echo $city_err; ?></span>
                            </div>



                            <input type="submit" class="btn btn-primary" value="Thêm">
                            <a href="admin-user.php" class="btn btn-default">Huỷ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>