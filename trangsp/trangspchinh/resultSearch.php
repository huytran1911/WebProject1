<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Tìm kiếm sản phẩm</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">
   <style>
      body {
         font-family: Arial, sans-serif;
         margin: 0;
         padding: 0;
      }

      .container {
         max-width: 800px;
         margin: 0 auto;
         padding: 20px;
      }

      h1 {
         text-align: center;
         margin-bottom: 20px;
      }

      .search-form {
         text-align: center;
         margin-bottom: 20px;
      }

      .search-form input,
      .search-form select {
         margin-right: 10px;
         margin-bottom: 10px;
         padding: 10px;
         width: 200px;
         border: 1px solid #ccc;
         border-radius: 5px;
         font-size: 16px;
      }

      .search-form button {
         padding: 10px 20px;
         background-color: #007bff;
         color: #fff;
         border: none;
         border-radius: 5px;
         font-size: 16px;
         cursor: pointer;
      }

      .products {
         display: flex;
         flex-wrap: wrap;
         justify-content: center;
      }

      .product {
         margin: 10px;
         padding: 20px;
         border: 1px solid #ccc;
         border-radius: 5px;
         text-align: center;
      }

      .product img {
         max-width: 100%;
         height: auto;
         margin-bottom: 10px;
      }

      .product .name {
         font-weight: bold;
         margin-bottom: 10px;
      }

      .product .price {
         font-size: 18px;
         color: #007bff;
         margin-bottom: 10px;
      }

      .product .add-to-cart {
         background-color: #007bff;
         color: #fff;
         border: none;
         padding: 10px 20px;
         border-radius: 5px;
         cursor: pointer;
      }

      .empty {
         text-align: center;
         font-style: italic;
      }
   </style>
</head>
<body>
   
<div class="container">
   <h1>Tìm kiếm sản phẩm</h1>

   <!-- Search Form -->
   <form class="search-form" method="post" action="">
      <input type="text" name="search_box" placeholder="Tìm kiếm sản phẩm...">
      <input type="number" name="min_price" placeholder="Giá thấp nhất" min="0">
      <input type="number" name="max_price" placeholder="Giá cao nhất" min="0">
      <select name="category">
         <option value="">Tất cả danh mục</option>
         <?php
            // Lặp qua danh sách danh mục và tạo các tùy chọn
            $select_categories = $conn->query("SELECT * FROM `tbl_category`");
            while ($fetch_categories = $select_categories->fetch_assoc()) {
               echo '<option value="' . $fetch_categories['cateid'] . '">' . $fetch_categories['categoryName'] . '</option>';
            }
         ?>
      </select>
      <button type="submit" name="search_btn">Tìm kiếm</button>
   </form>

   <!-- Products -->
   <div class="products">
      <?php
      // Kiểm tra nếu có kết quả tìm kiếm
      if (isset($_POST['search_btn'])) {
         // Code xử lý tìm kiếm ở đây
         // ...
      } else {
         // Hiển thị thông báo nếu không có kết quả
         echo '<p class="empty">Không có sản phẩm phù hợp.</p>';
      }
      ?>
   </div>
</div>

<!-- custom js file link  -->
<script src="js/script.js"></script>

</body>
</html>
