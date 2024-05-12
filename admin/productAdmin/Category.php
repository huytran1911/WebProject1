<?php
require "../function.php";
require "../../require/connect.php";

// Kiểm tra nếu dữ liệu từ form đã được gửi đi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem key "category_name" có tồn tại trong mảng $_POST hay không
    if (isset($_POST["add"]) && $_POST["add"]) {
        $category_name = $_POST["category_name"];

        
        if (!empty($category_name)) {
           
            $sql = "INSERT INTO tbl_category (cateid, categoryName) VALUES (?, ?)";

            if ($stmt = mysqli_prepare($conn, $sql)) {
                mysqli_stmt_bind_param($stmt, "is",$param_cid, $param_categoryName);

                // Cung cấp giá trị cho $param_categoryName
                $param_categoryName = $category_name;
                $param_cid = $cid;
                // Thực thi câu lệnh SQL và kiểm tra kết quả
                if (mysqli_stmt_execute($stmt)) {
                    // Khi thực thi thành công thì sẽ quay về trang admin-user.php
                    redirect("./Category.php");
                    exit();
                } else {
                    echo "Đã xảy ra lỗi.";
                }
                mysqli_stmt_close($stmt); // Đóng statement
            }
        }
     }
}

?>





<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../admin-css/admin.css">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin</title>
</head>
<body style="background-color: #f3f8ff;">
  <input type="checkbox" id="menu-toggle">
  <div class="sidebar">
   <div class="side-header">
   
   </div>
   
   <div class="side-content" style="background-color: #f3f8ff; border-right: 1px solid #000;">
       <div class="profile">
           <div class="profile">
               <img src="/asset/images/1.png" alt="Logo" style="width: 100%; height: auto;">
               <h3 style="color: #74767d; font-weight: bold;">PET FOOD</h3> 
           </div>
       </div>

       <div class="side-menu">
             <ul>
                 
                 <li style="margin-bottom: 15px;" >
                    <a href="../userAdmin/admin-user.php">
                         <span class="las la-user-alt" style="color:#74767d;"></span>
                         <h3 style="color: #74767d; font-weight: bold;">Khách Hàng</h3>
                     </a>
                 </li>

                 <li style="margin-bottom: 15px;">
                    <a href="./Category.php">
                        <span class="las la-address-card" style="color: #74767d;"></span>
                        <h3 style="color: #74767d; font-weight: bold;">Danh Mục</h3>
                    </a>
                </li>
              
                 <li style="margin-bottom: 15px;">
                    <a href="./admin-product.php">
                         <span class="las la-clipboard-list" style="color:#74767d;"></span>
                         <h3 style="color: #74767d; font-weight: bold;">Sản Phẩm</h3>
                     </a>
                 </li>
                 <li style="margin-bottom: 15px;">
                    <a href="./admin-order.php">
                         <span class="las la-shopping-cart" style="color:#74767d;"></span>
                         <h3 style="color: #74767d; font-weight: bold;">Đơn Hàng</h3>
                     </a>
                 </li>
           
             </ul>
         </div>
   </div>
</div>

   <div class="main-content" style="background-color: #f3f8ff;">
       
       <header>
           <div class="header-content">
               <label for="menu-toggle" id="bar-admin">
                   <span class="las la-bars" style="font-size: 28px; margin-top: 8px;"></span>
               </label>
               
               <div class="header-menu">
                       
                   <div class="user" style="margin-right: 8px; margin-top: -30px;">
                       <div class="bg-img" style="background-image: url()"></div>
                       <span style="font-size: 25px;cursor: pointer;" onclick="window.location.href='admin.html'"></span>
                       <span style="font-size: 20px; cursor: pointer; color:#74767d ; font-weight: 600;" onclick="window.location.href='admin.html'">Trang chủ</span>
                   </div>
               </div>
           </div>
       </header>
        
        <main >
<div class="page-content">
        
    <h1 style="padding: 1.3rem 0rem;color: #74767d; margin-left: 55px;" id="product">Danh Mục Sản Phẩm</h1>
    <div class="user-tab" style="margin-left: 55px;">
       

   

       <div>
        <form method="post">
            <input type="text" name="category_name" placeholder="Nhập tên danh mục" required>
            <input name="add" type="submit" value="Thêm">
        </form>
</div>

    </div>
</div>
          
          <div class="records table-responsive" >

            <div class="record-header">
            
            </div>

            <div>
            <table width="100%" id="table-product">
          
            
            <?php
            // Kết nối CSDL và truy vấn danh sách danh mục sản phẩm
            // Duyệt qua kết quả và hiển thị trong bảng
            $sql_select = "SELECT * FROM tbl_category";
            $result = mysqli_query($conn, $sql_select);
            if(mysqli_num_rows($result) > 0) {
                echo "<table width='100%' id='table-user'>";
                    echo "<thead>";
                        echo "<tr>";
                            echo "<th> Mã Danh Mục</th>";
                            echo "<th> Tên Danh Mục </th>";
                            echo "<th> Hành động </th>";
                        echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    // Lặp qua các hàng dữ liệu
                    while($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                            echo "<td>" . $row['cateid'] . "</td>";
                            echo "<td>" . $row['categoryName'] . "</td>";
                            echo '<td>
                                    <a onclick="return confirm(\'Bạn có chắc chắn muốn xóa ?\')" href="./deleteCategory.php?cateid=' . $row['cateid'] . '">
                                        <button class="btn btn-danger">Xóa</button>
                                    </a>
                                </td>';
                        echo "</tr>";
                }
                    echo "</tbody>";
                    echo "</table>"; 
            } else {
                echo "<p> Không có dữ liệu </p>";
            }
            ?>
 
 
            </table>
            </div>

          </div>
</main>
</body>
</html>
