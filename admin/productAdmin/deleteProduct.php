<?php
    // Bao gồm các tệp cần thiết
    include "../function.php";
    require_once "../../require/connect.php";

    // Kiểm tra xem ID có được đặt và thực hiện xóa
    if(isset($_GET["pid"])){
        // Lấy ID từ tham số truyền vào
        $id = $_GET["pid"];

        // Xây dựng câu lệnh SQL xóa
        $sql = "DELETE FROM tbl_products WHERE pid=?";

        if ($stmt = mysqli_prepare($conn, $sql)){
            mysqli_stmt_bind_param($stmt, "i", $param_cid);

            // Gán giá trị cho tham số ID
            $param_cid = $id; // Corrected variable name

            if (mysqli_stmt_execute($stmt)) {

                redirect("./admin-product.php");
                exit();
            } else {
                echo "Đã xảy ra lỗi.";
            }
            mysqli_stmt_close($stmt);
        }
    }


require_once "../../require/connect.php";

// Lấy thông tin về sản phẩm
$productId = $_GET['pid'];
$sql_product_info = "SELECT * FROM tbl_products WHERE pid = $productId";
$result_product_info = mysqli_query($conn, $sql_product_info);
$product_info = mysqli_fetch_assoc($result_product_info);

// Kiểm tra trạng thái của sản phẩm
if ($product_info['status'] == 0) {
    // Nếu sản phẩm đã bán ra, ẩn sản phẩm trên trang chính mà không xoá hoàn toàn thông tin của nó trong cơ sở dữ liệu
    $status = 1; // Trạng thái 2 để ẩn sản phẩm
    $sql_update_status = "UPDATE tbl_products SET status = $status WHERE pid = $productId";
    mysqli_query($conn, $sql_update_status);
} else {
    // Nếu sản phẩm chưa bán ra, tiến hành xoá hoàn toàn sản phẩm và thông tin liên quan
    $sql_delete_product = "DELETE FROM tbl_products WHERE pid = $productId";
    mysqli_query($conn, $sql_delete_product);
}

// Sau khi thực hiện hành động cần thiết, chuyển hướng về trang admin-product.php
header("Location: admin-product.php");
exit;
?>

