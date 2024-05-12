<?php
require "../../require/connect.php"; // Kết nối đến cơ sở dữ liệu
require "../function.php"; // Import các hàm cần thiết

$quantity = $cid = $p_name = $price = $description = $image = ""; // Khởi tạo các biến
function formatPrice($price) {
    return number_format($price, 0, ',', '.') . "đ";
}


// Kiểm tra xem biểu mẫu đã được gửi đi chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["p_name"]) || empty($_POST["price"]) || empty($_POST["description"]) || empty($_POST["quantity"]) || empty($_POST["category"]) || empty($_FILES["image"]["name"])) {
        echo "<p style='color: red;'>Vui lòng điền đầy đủ thông tin cho tất cả các trường.</p>";
    } else {
    $p_name = $_POST["p_name"];
    $price = $_POST["price"];
    $description = $_POST["description"];
    $image = $_FILES["image"]["name"];
    $cid = $_POST["category"];
    $quantity = $_POST["quantity"];
    
    // Đường dẫn lưu trữ ảnh
    $target_dir = $_SERVER['DOCUMENT_ROOT'] . "../productAdmin/uploads/";

// Create the uploads directory if it doesn't exist
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

    

    $target_file = $target_dir . basename($_FILES["image"]["name"]);

    // Kiểm tra và lưu ảnh vào thư mục uploads
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        echo "File ảnh đã được tải lên thành công.";
    } else {
        echo "Có lỗi xảy ra khi tải lên ảnh.";
    }


    // Insert dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO tbl_products (cid, img, productName, price, detail, quantity) VALUES (?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "issssi", $param_cid, $param_image, $param_p_name, $param_price, $param_description, $param_quantity);

        // Thiết lập các tham số và thực thi câu lệnh
        $param_quantity = $quantity;
        $param_p_name = $p_name;
        $param_price = $price;
        $param_cid = $cid;
        $param_description = $description;
        $param_image = $image;

        if (mysqli_stmt_execute($stmt)) {
            echo "Sản phẩm đã được thêm vào cơ sở dữ liệu thành công.";
            redirect("./admin-product.php"); // Chuyển hướng đến trang quản lý sản phẩm sau khi thêm thành công
            exit();
        } else {
            echo "Đã xảy ra lỗi khi thêm sản phẩm.";
        }
    } else {
        echo "Đã xảy ra lỗi khi chuẩn bị câu lệnh SQL.";
    }

// Đóng câu lệnh và kết nối
mysqli_stmt_close($stmt);
mysqli_close($conn);

}
}    
?>






<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Thêm sản phẩm mới</title>
    <style>
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
        #preview-container {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            margin-top: 20px;
            overflow: hidden; /* Giới hạn hình ảnh trong khuôn */
        }
        #preview {
            width: 100%; /* Kích thước tối đa cho hình ảnh */
            height: auto; /* Chiều cao tự động tính toán để giữ tỷ lệ khung hình */
        }
        .form-group {
            margin-bottom: 20px; /* Add margin to separate form fields */
        }
        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown.show .dropdown-menu {
            display: block;
        }
        .dropdown-menu li {
            padding: 8px 12px;
        }
        .dropdown-menu li:hover {
            background-color: #ddd;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2> Thêm sản phẩm mới </h2>
                        <form method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Tên sản phẩm</label>
                                <input type="text" name="p_name" id="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Giá</label>
                                <input type="text" name="price" id="price" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Mô tả</label>
                                <input type="text" name="description" id="description" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Số lượng</label>
                                <input type="text" name="quantity" id="quantity" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <div id="preview-container">
                                    <img id="preview" src="#" alt="Hình ảnh" style="display: none;">
                                </div>
                                <input type="file" id="image" class="form-control" name="image">
                            </div>

                            <div class="form-group">
                                <label for="category">Danh mục</label>
                                <select class="form-select" id="category" name="category">
                                    <option value="">Chọn danh mục</option>
                                    <ul id="categoryList" class="dropdown-menu" aria-labelledby="categoryDropdown">
                                    <?php
                                        require_once "../../require/connect.php";
                                        $sql = "SELECT * FROM tbl_category";
                                        $result = mysqli_query($conn, $sql);
                                        // Kiểm tra và hiển thị danh mục trong dropdown menu
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '<option value="' . $row["cateid"] . '">' . $row["categoryName"] . '</option>';
                                            }
                                        } else {
                                            echo '<option value="">Không có danh mục nào</option>';
                                        }
                                        // Đóng kết nối
                                        mysqli_close($conn);
                                    ?>
                                    </ul>
                                </div>
                            </div>

                            
                            
                            <input type="submit" name="btn_sbm" class="btn btn-primary" value="Thêm">
                            <a href="admin-user.php" class="btn btn-default">Huỷ</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Hiển thị hình ảnh trước khi upload
        document.getElementById("image").addEventListener("change", function() {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("preview").src = e.target.result;
                document.getElementById("preview").style.display = "block";
            };
            reader.readAsDataURL(this.files[0]);
        });
        
        // Toggle dropdown menu on button click
        document.getElementById("categoryDropdown").addEventListener("click", function() {
            document.querySelector(".dropdown-menu").classList.toggle("show");
        });

        // Close dropdown menu when clicking outside
        window.addEventListener("click", function(event) {
            if (!event.target.matches(".btn-secondary")) {
                var dropdowns = document.querySelectorAll(".dropdown-menu");
                dropdowns.forEach(function(dropdown) {
                    if (dropdown.classList.contains("show")) {
                        dropdown.classList.remove("show");
                    }
                });
            }
        });

        document.getElementById("categoryDropdown").addEventListener("click", function() {
            fetchCategories();
        });

        function selectCategory(categoryId, categoryName) {
            // Thay thế nội dung của nút chọn danh mục bằng chiến lược đã chọn
            document.getElementById("categoryDropdown").textContent = categoryName;
            // Có thể thêm các hành động khác ở đây nếu cần
        }

        function fetchCategories() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById("categoryList").innerHTML = xhr.responseText;
                }
            };
            xhr.open("GET", "get_categories.php", true);
            xhr.send();
        }

    </script>
</body>
</html>

