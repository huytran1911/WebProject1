<?php
include_once "../../require/connect.php";
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    // Lấy từ khóa tìm kiếm từ URL
    $keyword = $_GET['keyword'];

    // Chuyển hướng người dùng đến trang kết quả tìm kiếm với từ khóa đã nhập
    header("Location:./resultSearch.php?keyword=$keyword");
    exit(); // Đảm bảo không có mã HTML hoặc mã PHP nào được thực thi sau header
}

// Xử lý tìm kiếm sản phẩm
if(isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    // Sử dụng phép toán LIKE để thực hiện tìm kiếm tương đối
    $search_keyword = '%' . $keyword . '%';

    // Truy vấn để lọc sản phẩm theo từ khóa tìm kiếm
    $sql_search = "SELECT * FROM tbl_products WHERE productName LIKE ?";
    // Sử dụng prepared statement để tránh lỗ hổng SQL injection
    $stmt = mysqli_prepare($conn, $sql_search);
    mysqli_stmt_bind_param($stmt, "s", $search_keyword);
    mysqli_stmt_execute($stmt);
    $result_search = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result_search) > 0) {
        // Hiển thị các sản phẩm tìm thấy
        while($row = mysqli_fetch_array($result_search)) {
            // Hiển thị thông tin sản phẩm
        }
    } else {
        echo "<p>Không tìm thấy sản phẩm nào.</p>";
    }
}
?>
