<?php
// Include the connection file
require_once "../require/connect.php";

// Kiểm tra xem có dữ liệu POST được gửi từ trang web không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy ID của đơn hàng từ dữ liệu POST
    $orderId = $_POST["IDorders"];

    // Cập nhật trạng thái của đơn hàng có orderId là $orderId thành "đã giao hàng thành công"
    $updateQuery = "UPDATE orders SET status = '1' WHERE IDorders = $orderId";

    // Thực thi truy vấn
    if ($conn->query($updateQuery) === TRUE) {
        // Trả về kết quả cho trang web
        echo json_encode(array("status" => "success", "message" => "Đã cập nhật trạng thái đơn hàng thành công."));
    } else {
        // Trả về kết quả cho trang web
        echo json_encode(array("status" => "error", "message" => "Lỗi khi cập nhật trạng thái đơn hàng: " . $conn->error));
    }
} else {
    // Trả về kết quả cho trang web nếu không có dữ liệu POST được gửi
    echo json_encode(array("status" => "error", "message" => "Không có dữ liệu được gửi từ trang web."));
}

// Đóng kết nối
$conn->close();
?>

