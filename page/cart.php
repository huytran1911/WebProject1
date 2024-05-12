

<?php
require '../require/connect.php';
// Bắt đầu phiên session nếu chưa được bắt đầu
if (!isset($_SESSION)) {
    session_start();
}

// Kiểm tra xem biến $_SESSION['taikhoan'] có tồn tại hay không
if (isset($_SESSION['dangnhap'])) {
    // echo $_SESSION['dangnhap'];
} else {
    // Xử lý trường hợp nếu $_SESSION['taikhoan'] không tồn tại
    // echo "Không có tài khoản được đăng nhập";
}
?>


<?php
// Kiểm tra trạng thái của session trước khi bắt đầu một session mới
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra khi người dùng nhấn nút "Thêm vào giỏ"
if (isset($_POST['addtocart'])) {
    // Lấy thông tin sản phẩm từ form
    $product_id = $_POST['id'];
    $product_image = $_POST['image'];
    $product_name = $_POST['name'];
    $product_price = $_POST['price'];

    // Kiểm tra xem session giỏ hàng đã được khởi tạo chưa, nếu chưa thì tạo mới
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng chưa
    $product_index = -1;  
    foreach ($_SESSION['cart'] as $index => $product) {
        if ($product['id'] == $product_id) {
            $product_index = $index;
            break;
        }
    }

    if ($product_index >= 0) {
        // Nếu sản phẩm đã tồn tại, tăng số lượng của nó
        $_SESSION['cart'][$product_index]['quantity'] += 1;
    } else {
        // Nếu sản phẩm chưa tồn tại, thêm sản phẩm vào giỏ hàng
        $product = array(
            'id' => $product_id,
            'image' => $product_image,
            'name' => $product_name,
            'price' => $product_price,
            'quantity' => 1 // Số lượng ban đầu là 1
        );
        array_push($_SESSION['cart'], $product);
    }

    // // Chuyển hướng người dùng đến trang giỏ hàng
    // header('Location: ../../assets/cart/cart.php');
    // exit();
}

// Kiểm tra khi người dùng nhấn nút "Xóa sản phẩm khỏi giỏ hàng"
if (isset($_GET['remove'])) {
    $product_id = $_GET['remove'];
    // Tìm vị trí của sản phẩm trong giỏ hàng và xóa nó
    foreach ($_SESSION['cart'] as $index => $product) {
        if ($product['id'] == $product_id) {
            unset($_SESSION['cart'][$index]);
            break;
        }
    }
    // Chuyển hướng người dùng đến trang giỏ hàng
    header('Location: cart.php');
    exit();
}
// Kiểm tra khi người dùng cập nhật số lượng sản phẩm
if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];
    // Tìm vị trí của sản phẩm trong giỏ hàng và cập nhật số lượng mới
    foreach ($_SESSION['cart'] as $index => $product) {
        if ($product['id'] == $product_id) {
            $_SESSION['cart'][$index]['quantity'] = $new_quantity;
            // Tính toán giá tiền mới
            $_SESSION['cart'][$index]['total_price'] = calculateNewPrice($product['price'], $new_quantity);
            break;
        }
    }
    // Chuyển hướng người dùng đến trang giỏ hàng
    header('Location: cart.php');
    exit();
}

function calculateNewPrice($old_price, $new_quantity) {
    $new_price = $old_price * $new_quantity;
    $formatted_price = number_format($new_price); // Tách giá trị bằng dấu chấm
    return $formatted_price;
} 
function calculateTotalPrice($cart) {
    $total_price = 0;
    foreach ($cart as $product) {
        $total_price += $product['price'] * $product['quantity'];
    }
    return $total_price;
}
?>



<style>
        /* Thiết lập CSS cho giao diện */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .remove-btn {
            background-color: #ff6347;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .update-btn {
            background-color: #ff6347;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 3px;
            cursor: pointer;
        }
        .small-image {
    width: 100px; /* Kích thước chiều rộng mới */
    height: auto; /* Chiều cao tự động tính toán tương ứng */
}
.checkout-btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }
    </style>

<style>
        .pagination {
            margin-top: 20px;
            text-align: center;
            justify-content: center;
        }

        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 16px;
            text-decoration: none;
            color: #007bff;
            border: 1px solid #007bff;
            border-radius: 5px;
            margin-right: 5px;
        }

        .pagination a.current, .pagination span.current {
            background-color: #007bff;
            color: white;
            border: 1px solid #007bff;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: white;
        }

        .pagination a:disabled {
            color: #ccc;
            pointer-events: none;
        }

        /* Thêm CSS cho hiển thị/ẩn menu */
        .none {
            display: none;
        }

        /* CSS cho hiệu ứng hiển thị danh sách */
        .show {
            display: block;
        }
    </style>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/cart/cart.css">  
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="../images/logo image/Logo image.png">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <title>SnakeBoardgame</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>


<body>
    <div class="header">
        <div class="head-container">
            <div class="top-bar">
                <a href="../../index.html" class="logo">
                    <img src="../../images/logo image/Logo image.png" alt="boardgame logo">
                </a>
                <ul class="nav-bar">
                    <li><a href="../../index.html">Trang chủ</a></li>
                    <li><a href="../../trangsp.html/trangspchinh/trangspchinh.html">Cửa Hàng</a></li>
                    <li><a href="../../Lienhe/Lienhe.html">Liên hệ</a></li>

                </ul>
                <div class="nav-icon">
                    <a href="../../assets/cart/cart.php"><i class='bx bx-cart'> </i></a>
                    <a href="../../assets/users/users.php"><i class='bx bx-user'> <?php echo $_SESSION['dangnhap'];?> </i></a>
                </div>
            </div>
        </div>
    </div>

    <div class="border-top">
        <div class="border-container">
            <div class="box-menu">
                <div class="main-text">
                    Danh mục sản phẩm
                    <!-- Thêm ID cho nút menu -->
                    <a href="#" id="menu-toggle" class="trigger mobile-hide">
                        <i class='bx bx-menu'></i>
                    </a>
                </div>
            </div>
            <div class="wrapper">
            <div class="search-input">
                <form action="" method="GET"> <!-- Thay đổi action và method -->
                    <input type="text" name="keyword" placeholder="Tìm kiếm"> <!-- Thêm thuộc tính name để lấy giá trị của ô input -->
                    <button type="submit" class="icon"><i class="fas fa-search"></i></button> <!-- Thay đổi thành nút submit -->
                </form>
            </div>

            </div>
        </div>
    </div>

    <!-- Thêm lớp CSS cho danh sách danh mục -->
    

    <div class="menu-list">
        <div class="menu-container">
            <div class="cover">
            <ul class="menu-link none" id="menu-list">
        <?php
        // Truy vấn để lấy danh sách danh mục từ cơ sở dữ liệu
        $sql_categories = "SELECT * FROM tbl_category";
        $result_categories = mysqli_query($conn, $sql_categories);

        // Kiểm tra xem có danh mục nào hay không
        if (mysqli_num_rows($result_categories) > 0) {
            // Hiển thị danh sách các danh mục
            while ($row_category = mysqli_fetch_assoc($result_categories)) {
                echo "<li><a href='./loaisp.php?cateid=" . $row_category['cateid'] . "'>" . $row_category['categoryName'] . "</a></li>";

            }
        } else {
            echo "<li><a href='#'>Không có danh mục</a></li>";
        }
        ?>
    </ul>
            </div>
        </div>
    </div>
 
    <div class="container">
        <h2>Giỏ hàng của bạn</h2>
        <?php if (!empty($_SESSION['cart'])): ?>
        <table>
            <thead>
                <tr>
                    <th>ID Sản phẩm</th>
                    <th>Hình ảnh</th>
                    <th>Tên sản phẩm</th>
                    <th>Giá</th>
                    <th>Hành động</th>
                    <th>Số lượng</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_SESSION['cart'] as $product): ?>
                <tr>
                <td><?php echo $product['id']; ?></td>
                <td><img src="../admin/productAdmin/uploads/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="small-image"></td>
                <td><?php echo $product['name']; ?></td>
                    <td>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <!-- Hiển thị giá tiền mới -->
                            <?php echo calculateNewPrice($product['price'], $product['quantity']); ?>
                        </form>
                    </td>
                    <td>
                        <form method="GET">
                            <input type="hidden" name="remove" value="<?php echo $product['id']; ?>">
                            <button type="submit" class="remove-btn">Xóa</button>
                        </form>
                    </td>
                    
                    <td>
                        <form method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $product['quantity']; ?>" min="1" max="100">
                            <button type="submit" class="update-btn">Cập nhật</button>
                        </form>
                    </td>
                </tr>
                
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>Giỏ hàng của bạn trống.</p>
        <?php endif; ?>
        <a href="../trangsp/trangspchinh/trangspchinh.php">Tiếp tục mua sắm</a>
        
        
    </div>
    <div class="card shadow-2-strong mb-5 mb-lg-0" style="border-radius: 16px;">
                <div class="card-body p-4">

                    <div class="row">

                        <div class="col-lg-5 col-xl-5">

                        </div>
                        <div class="col-lg-8 col-xl-3">
                            <!-- <div class="d-flex justify-content-between" style="font-weight: 500;">
                                <p class="mb-2">Tổng phụ</p>
                                <p class="mb-2">2.453.000đ</p>
                            </div> -->


                            <hr class="my-4">

                            
                        
                            
                            <div class="d-flex justify-content-between mb-4" style="font-weight: 500;">
                                <p class="mb-2">Tạm tính: </p> 
                                <p class="mb-2"></pclass><span><?php echo calculateTotalPrice($_SESSION['cart']); ?></span></p>
                                
                            </div>
                            <div>
                            <?php if (calculateTotalPrice($_SESSION['cart']) > 0): ?>
                                    <a href="checkout.php" class="btn btn-primary btn-danger text-white fw-bold w-100">Thanh toán</a>
                                <?php else: ?>
                                    <button class="btn btn-primary btn-danger text-white fw-bold w-100" disabled>Thanh toán</button>
                                <?php endif; ?>
                            </div>
                              

                        </div>
                    </div>
                </div>
            </div>
            
</body>
                        
</html>
