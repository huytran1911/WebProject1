<div class="product-cover">
    <div class="products-slider-wrapper">
        <div class="similar-products-label">Có thể bạn sẽ thích</div>
        <div class="products-slider owl-carousel owl-theme">
        <?php
        include_once "../require/connect.php"; // Add a semicolon here

        // Truy vấn để lấy các sản phẩm từ mục chiến lược
        $sql_similar_products = "SELECT * FROM tbl_products WHERE category = 'Chiến lược' ORDER BY RAND() LIMIT 10";
        $result_similar_products = mysqli_query($conn, $sql_similar_products);

        // Kiểm tra xem có sản phẩm từ mục chiến lược nào không
        if (mysqli_num_rows($result_similar_products) > 0) {
            // Hiển thị các sản phẩm từ mục chiến lược
            while ($similar_product = mysqli_fetch_assoc($result_similar_products)) {
        ?>
                <div class="item">
                    <div class="product-box">
                        <a href="./chitietsp.php?pid=<?php echo $similar_product['pid']; ?>">
                            <img alt="" src="../../admin/productAdmin/uploads/<?php echo $similar_product['img']; ?>">
                        </a>
                        <div class="product-info">
                            <div class="product-name">
                                <a href="./chitietsp.php?pid=<?php echo $similar_product['pid']; ?>"><?php echo $similar_product['productName']; ?></a>
                            </div>
                            <div class="de-font">
                                <?php echo substr($similar_product['detail'], 0, 100); ?>...
                            </div>
                            <div class="price">
                                <span><?php echo number_format($similar_product['price'], 0, ',', '.'); ?>đ</span>
                            </div>
                        </div>
                    </div>
                </div>
        <?php
            }
        } else {
            echo "<div class='item'><p>Không có sản phẩm từ mục chiến lược.</p></div>";
        }
        ?>
        </div>
    </div>
</div>


<script type="text/javascript" src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/js/lightslider.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var menuToggle = document.getElementById('menu-toggle');
    var menuList = document.getElementById('menu-list');

    // Thêm sự kiện click cho nút menu
    menuToggle.addEventListener('click', function(e) {
        e.preventDefault(); 
        menuList.classList.toggle('show'); 
    });
});


        $('.products-slider').owlCarousel({
            loop:true,
            margin:10,
            responsiveClass:true,
            responsive:{
                0:{
                    items:1,
                    nav:true
                },
                600:{
                    items:3,
                    nav:false
                },
                1000:{
                    items:5,
                    nav:true,
                    loop:false
                }
            }
        });
    </script>