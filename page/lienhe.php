
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




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/lightslider/1.1.6/css/lightslider.min.css">
    <link rel="stylesheet" href="../assets/css/trangspchinh.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="icon" type="image/x-png" href="../images/logo image/Logo image.png">
    <title>SnakeBoardgame</title>

</head>

<body>
<?php 
    require '../require/connect.php';
  
    $isLogined = false;
    if (isset($_SESSION['dangnhap'])) {
        require_once 'header_in.php';
        $isLogined = true;
    } else {
        require_once 'header_out.php';
    }

    // require('page/feature.php')
    ?>
    

    <div class="border-top">
        <div class="border-container">
            <div class="box-menu">
                <div class="main-text">
                    Danh mục sản phẩm
                    <a href="#" class="trigger mobile-hide">
                        <i class='bx bx-menu'></i>
                    </a>
                </div>
            </div>
            <div class="wrapper">
                <div class="search-input">
                   
                <input type="text"  placeholder="Tìm kiếm"> <!-- Thêm thuộc tính name để lấy giá trị của ô input -->
                    <a href="../trangsp/trangspchinh/search.php"><button type="submit" class="icon"><i class="fas fa-search"></i></button> <!-- Thay đổi thành nút submit --></a>
                </div>
            </div>
        </div>
    </div>


    <div class="menu-list">
        <div class="menu-container">
            <div class="cover">
                <ul class="menu-link none">
                    <li>
                        <a href="../danhmucsanpham/chienluoc.html">
                        Chiến lược 
                    </a>
                        <a href="../danhmucsanpham/chienluoc.html"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Các loại cờ
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                    <li>
                        <a href="../danhmucsanpham/giadinh.html">
                        Gia đình
                    </a>
                        <a href="../danhmucsanpham/giadinh.html"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Vận may
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Nhập vai
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                    <li>
                        <a href="#">
                        Nhóm bạn
                    </a>
                        <a href="#"><span>></span></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    </div>

    <div class="border-container">
        <div class="body-lienhe">
            <div class="lienhe-header"></div>
            <div class="lienhe-info">
                <div class="info-left">
                    <p>
                        <h2 style="font-weight: bold; "> SnakeBoardgame </h2><br />
                        <b>Địa chỉ:</b> 273 An Dương Vương, phường 3, Quận 5, TPHCM<br /><br />
                        <b>Telephone:</b> 0899517129<br /><br />
                        <b>Hotline:</b> 097777777 - CSKH:19001082<br /><br />
                        <b>E-mail:</b> DoAn@gmail.com<br /><br />
                        <b>Mã số thuế:</b> 01 02 03 04 05<br /><br />
                        <b>Tài khoản ngân hàng :</b><br /><br />
                        <b>Số TK:</b> 060008086888 <br /><br />
                        <b>Tại Ngân hàng:</b> Agribank Chi nhánh Sài Gòn<br /><br /><br /><br />
                        <b>Quý khách có thể gửi liên hệ tới chúng tôi bằng cách hoàn tất biểu mẫu dưới đây. Chúng tôi
                        sẽ trả lời thư của quý khách, xin vui lòng khai báo đầy đủ. Hân hạnh phục vụ và chân thành
                        cảm ơn sự quan tâm, đóng góp ý kiến đến SnakeBoardgame.</b>
                    </p>
                </div>
            </div>
        </div>
    </div>
            <footer>
                <div class="footer-container ">
                    <div class="row ">
                        <div class="col-lg-3 col-sm-6 ">
                            <div class="single-box ">
                                <h2>CHĂM SÓC KHÁCH HÀNG</h2>
                                <ul>
                                    <li><span>19001082</span></li>
                                    <li><a href="# ">Từ thứ Hai đến thứ Bảy (08:00 - 17:00)</a></li>
                                    <li><a href="# ">Chủ nhật (08:00 - 12:00)</a></li>
                                </ul>
                            </div>
                        </div>
        
                        <div class="col-lg-3 col-sm-6 ">
                            <div class="single-box ">
                                <h2>ĐIỀU KHOẢN & CHÍNH SÁCH</h2>
                                <ul>
                                    <li><a href="# ">- Chính sách giao hàng </a></li>
                                    <li><a href="# ">- Chính sách tích lũy điểm</a></li>
                                    <li><a href="# ">- Điều khoản điều kiện</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 ">
                            <div class="single-box ">
                                <h2>HỖ TRỢ KHÁCH HÀNG</h2>
                                <ul>
                                    <li><a href="# ">- Chính sách bảo mật </a></li>
                                    <li><a href="# ">- Chính sách bảo hành đổi trả hàng hóa</a></li>
                                    <li><a href="# ">- Chính sách thanh toán</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 ">
                            <div class="single-box ">
                                <h2>Snake Boardgame</h2>
                            </div>
                            <img class="footer-img " src="../images/logo image/SnakeBoardgame.png" alt=" ">
                        </div>
                    </div>
                </div>
            </footer>
        
</body>

</html>