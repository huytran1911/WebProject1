<?php 
    // Bao gồm các tệp cần thiết
    include "../function.php";
    require_once "../../require/connect.php";

    // Kiểm tra xem ID có được đặt và thực hiện xóa
    if(isset($_GET["cid"])){
        // Lấy ID từ tham số truyền vào
        $id = $_GET["cid"];

        // Xây dựng câu lệnh SQL xóa
        $sql = "DELETE FROM tbl_category WHERE cid=?";

        if ($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_cid);

            // Gán giá trị cho tham số ID
            $param_cid = $id; // Corrected variable name

            if (mysqli_stmt_execute($stmt)) {

                redirect("./Category.php");
                exit();
            } else {
                echo "Đã xảy ra lỗi.";
            }
            mysqli_stmt_close($stmt);
        }
    }
?>
