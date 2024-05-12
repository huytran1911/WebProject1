<?php
// Kết nối đến cơ sở dữ liệu
include_once '../../require/connect.php';
include_once '../function.php';

// Khởi tạo các biến
$p_name = $price = $description = $quantity = $category = $image = "";

// Lấy danh sách các danh mục từ cơ sở dữ liệu
$sql_categories = "SELECT * FROM tbl_category";
$result_categories = mysqli_query($conn, $sql_categories);
$categories = mysqli_fetch_all($result_categories, MYSQLI_ASSOC);

// Kiểm tra xem có ID sản phẩm được gửi từ trình duyệt hay không
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['pid']) && !empty(trim($_GET['pid']))) {
    // Lấy ID sản phẩm từ URL
    $pid = trim($_GET['pid']);

    // Chuẩn bị câu lệnh SELECT
    $sql = "SELECT * FROM tbl_products WHERE pid = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Liên kết các biến với câu lệnh đã chuẩn bị như là tham số
        mysqli_stmt_bind_param($stmt, "i", $param_pid);

        // Thiết lập giá trị của tham số
        $param_pid = $pid;

        // Thực thi câu lệnh đã chuẩn bị
        if (mysqli_stmt_execute($stmt)) {
            // Lấy kết quả
            $result = mysqli_stmt_get_result($stmt);

            // Kiểm tra xem có bản ghi nào được trả về không
            if (mysqli_num_rows($result) == 1) {
                // Lấy dữ liệu từ kết quả
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Trích xuất các giá trị vào biến
                $p_name = $row['productName'];
                $price = $row['price'];
                $description = $row['detail'];
                $quantity = $row['quantity'];
                $category = $row['cid'];
                $image = $row['img'];
            } else {
                // URL không chứa ID sản phẩm hợp lệ. Redirect về trang lỗi
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Đã có lỗi xảy ra. Vui lòng thử lại sau.";
        }
    }

    // Đóng câu lệnh
    mysqli_stmt_close($stmt);
}

// Kiểm tra nếu form được gửi đi bằng phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy giá trị từ form
    $pid = $_POST['pid'];
    $p_name = $_POST['p_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];

    // Xử lý hình ảnh mới nếu được tải lên
    $new_image = $_FILES['new_image']['name'];
    $target_directory = "../../admin/productAdmin/uploads/";
    $target_file = $target_directory . basename($new_image);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Kiểm tra xem hình ảnh mới có được tải lên không
    if (!empty($new_image)) {
        // Xóa hình ảnh cũ
        unlink($target_directory . $_POST['old_image']);

        // Di chuyển và lưu hình ảnh mới vào thư mục uploads
        move_uploaded_file($_FILES['new_image']['tmp_name'], $target_file);
    } else {
        // Nếu không có hình ảnh mới được tải lên, sử dụng hình ảnh cũ
        $new_image = $_POST['old_image'];
    }

    // Kiểm tra xem giá trị category được chọn có tồn tại trong bảng tbl_category không
    $valid_category = false;
    foreach ($categories as $cat) {
        if ($cat['cateid'] == $category) {
            $valid_category = true;
            break;
        }
    }

    if (!$valid_category) {
        echo "ERROR: Danh mục không hợp lệ.";
        exit();
    }

    // Cập nhật thông tin sản phẩm trong cơ sở dữ liệu
    $sql = "UPDATE tbl_products SET productName = ?, price = ?, detail = ?, quantity = ?, cid = ?, img = ? WHERE pid = ?";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Liên kết các biến với câu lệnh đã chuẩn bị như là tham số
        mysqli_stmt_bind_param($stmt, "sisissi", $p_name, $price, $description, $quantity, $category, $new_image, $pid);

        // Thực thi câu lệnh đã chuẩn bị
        if (mysqli_stmt_execute($stmt)) {

            echo "Sản phẩm đã được cập nhật thành công.";
            redirect("./admin-product.php");
        } else {
            echo "ERROR: Không thể thực thi câu lệnh $sql. " . mysqli_error($conn);
        }
    }

    // Đóng kết nối
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Sửa sản phẩm</title>
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
                        <h2> Sửa sản phẩm </h2>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                            <input type="hidden" name="old_image" value="<?php echo $image; ?>">

                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="p_name" id="p_name" class="form-control" value="<?php echo htmlspecialchars($p_name); ?>">
                            </div>

                            <div class="form-group">
                                <label>Giá</label>
                                <input type="text" name="price" id="price" class="form-control" value="<?php echo htmlspecialchars($price); ?>">
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <input type="text" name="description" id="description" class="form-control" value="<?php echo htmlspecialchars($description); ?>">
                            </div>

                            <div class="form-group">
                                <label>Số lượng</label>
                                <input type="text" name="quantity" id="quantity" class="form-control" value="<?php echo htmlspecialchars($quantity); ?>">
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <!-- Hiển thị hình ảnh từ cơ sở dữ liệu -->
                                <img id="preview" src="../../admin/productAdmin/uploads/<?php echo $image; ?>" alt="Hình ảnh sản phẩm" style="max-width: 100%; height: auto;">
                            </div>

                            <div class="form-group">
                                <label>Chọn hình ảnh mới</label>
                                <input type="file" name="new_image" id="new_image" class="form-control-file" accept="image/*">
                            </div>

                            <div class="form-group">
                                <label for="category">Danh mục</label>
                                <select class="form-control" name="category" id="category">
                                    <?php foreach ($categories as $cat): ?>
                                        <?php $selected = ($cat['cateid'] == $category) ? 'selected' : ''; ?>
                                        <option value="<?php echo $cat['cateid']; ?>" <?php echo $selected; ?>>
                                            <?php echo htmlspecialchars($cat['categoryName']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <input type="submit" name="btn_sbm" class="btn btn-primary" value="Cập nhật">
                            <a href="admin-product.php" class="btn btn-default">Huỷ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hiển thị hình ảnh trước khi upload
        document.getElementById("new_image").addEventListener("change", function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("preview").src = e.target.result;
                document.getElementById("preview").style.display = "block";
            };
            reader.readAsDataURL(this.files[0]);
        });
    </script>
</body>

</html>
