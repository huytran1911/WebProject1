<?php 
    // Bao gồm các tệp cần thiết
    include "../function.php";
    require_once "../../require/connect.php";

    // Kiểm tra xem ID có được đặt và thực hiện xóa
    if(isset($_GET["id"])){
        // Lấy ID từ tham số truyền vào
        $id = $_GET["id"];

        // Xây dựng câu lệnh SQL xóa
        $sql = "DELETE FROM tbl_users WHERE id=?";

        if ($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Gán giá trị cho tham số ID
            $param_id = $id;

            if (mysqli_stmt_execute($stmt)) {
                // Chuyển hướng đến admin-user.php sau khi xóa thành công
                redirect("./admin-user.php");
                exit();
            } else {
                echo "Đã xảy ra lỗi.";
            }
            mysqli_stmt_close($stmt);
        }
    }
?>
