<?php
require "../../require/connect.php";
require "../function.php";

$id = $name = $email = $phonenumber = $password = $address = "";
$name_err = $email_err = $phone_err = $password_err = $address_err ="";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị id từ form
    if(isset($_POST["id"])) {
        $id = $_POST["id"];
    } else {
        // Nếu 'id' không tồn tại trong yêu cầu POST, bạn có thể xử lý hoặc báo lỗi tùy vào logic ứng dụng của bạn.
        // Ví dụ:
        echo "Không tìm thấy id trong yêu cầu POST.";
        exit(); // Dừng việc thực thi tiếp tục
    }

    // Xử lý tên người dùng
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

    // Xử lý mật khẩu
    if(isset($_POST['password'])){
        $input_password = trim($_POST["password"]);

        if(empty($input_password)){
            $password_err = "Hãy nhập mật khẩu";
        } else {
            $password = $input_password;
        }
    }
    
    // Xử lý email
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
    
    // Xử lý số điện thoại
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

    // Xử lý địa chỉ
    if(isset($_POST['address'])){
        $input_address = trim($_POST["address"]);

        if(empty($input_address)){
            $address_err = "Hãy nhập địa chỉ";
        } else {
            $address = $input_address;
        }
    }

    // Kiểm tra và cập nhật dữ liệu nếu không có lỗi
    if (empty($name_err) && empty($email_err) && empty($phone_err) && empty($address_err) && empty($password_err)) {
        // Truy vấn cập nhật dữ liệu
        $sql = "UPDATE tbl_users SET username=?, password=?, email=?, phonenumber=?, address=? WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $sql)) {
            // Gán các tham số và thực thi truy vấn
            mysqli_stmt_bind_param($stmt, "sssssi", $param_name, $param_password, $param_email, $param_phonenumber, $param_address, $param_id);

            $param_name = $name;
            $param_password = $password;
            $param_email = $email;
            $param_phonenumber = $phonenumber;
            $param_address = $address;
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                // Nếu cập nhật thành công, chuyển hướng về trang admin-user.php
                redirect("./admin-user.php");
                exit();
            } else {
                // Nếu có lỗi, hiển thị thông báo lỗi
                echo "Đã xảy ra lỗi.";
            }
        }
        // Đóng câu lệnh và kết nối
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
} else {
    // Nếu không phải là phương thức POST, kiểm tra xem có tham số id trong URL không
    if(isset($_GET["id"])){
        $id = trim($_GET["id"]);

        // Truy vấn để lấy thông tin người dùng theo id
        $sql = "SELECT * FROM tbl_users WHERE id=?";
        if($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            $param_id = $id;

            if(mysqli_stmt_execute($stmt)){
                // Nếu truy vấn thành công, lấy kết quả và gán cho các biến
                $result = mysqli_stmt_get_result($stmt);

                if(mysqli_num_rows($result) == 1){
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $name = $row["username"];
                    $password= $row["password"];
                    $email = $row["email"];
                    $phonenumber = $row["phonenumber"];
                    $address = $row["address"];

                } else {
                    // Nếu không tìm thấy thông tin người dùng, chuyển hướng về trang admin-user.php
                    redirect("./admin-user.php");
                    exit();
                }
            }
        }
        // Đóng câu lệnh và kết nối
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sửa người dùng</title>
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
                        <h2> Sửa người dùng </h2>
                        <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post" >
                        <input type="hidden" name="id" value="<?php echo $id; ?>">

                            <div class="form-group">
                                
                                <label>Tên</label>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo $name; ?>">
                                <?php if(!empty($name_err)){
                                    echo '<span class="text-danger">'.$name_err.'</span>';
                                } ?>
                            </div>

                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="text" name="password" id="password" class="form-control" value="<?php echo $password; ?>">
                                <span class="text-danger"><?php echo $password_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input type="text" name="email" id="email" class="form-control" value="<?php echo $email; ?>">
                                <span class="text-danger"><?php echo $email_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" name="phonenumber" id="phonenumber" class="form-control" value="<?php echo $phonenumber; ?>">
                                <span class="text-danger"><?php echo $phone_err; ?></span>
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" id="address" class="form-control" value="<?php echo $address; ?>">
                                <span class="text-danger"><?php echo $address_err; ?></span>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Cập nhật">
                            <a href="admin-user.php" class="btn btn-default">Huỷ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>