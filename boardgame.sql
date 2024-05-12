-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 12, 2024 lúc 08:45 PM
-- Phiên bản máy phục vụ: 10.4.28-MariaDB
-- Phiên bản PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `boardgame`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `IDorders` int(100) NOT NULL,
  `id` int(100) NOT NULL,
  `receiver` varchar(100) NOT NULL,
  `phonenumber` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `ward` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `method` varchar(50) NOT NULL,
  `total_products` varchar(100) NOT NULL,
  `total_price` int(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `order_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`IDorders`, `id`, `receiver`, `phonenumber`, `street`, `ward`, `district`, `city`, `email`, `method`, `total_products`, `total_price`, `status`, `order_date`) VALUES
(1, 20, 'dff', 'dfsf', 'sdfsd', 'sdf', 'sdfsd', 'dsfsdf', 'haha123@gmail.com', '1', '', 3000000, 1, '2024-05-12'),
(2, 20, 'dff', 'dfsf', 'sdfsd', 'sdf', 'sdfsd', 'dsfsdf', 'haha123@gmail.com', '1', '', 0, 1, '2024-05-12'),
(3, 20, 'fdsfsdf', 'sdfsdf', 'sdfsd', 'sdfsdf', 'sdffsf', 'sdfsdf', 'haha123@gmail.com', '1', '', 1850000, 1, '2024-05-12'),
(4, 20, 'fd', 'dsfsdf', 'sdfsdf', 'dsdfsdfs', 'sdfs', 'dfsdf', 'haha123@gmail.com', '2', '', 1600000, 0, '2024-05-12'),
(5, 20, 'fwrf', 'ưèwẻ', 'ưẻwr', 'ưẻwẻ', 'ưẻw', 'ưẻwẻ', 'haha123@gmail.com', '1', '', 75000, 0, '2024-05-12'),
(6, 20, 'dfdf', 'dfewf', 'èwẻ', 'ewrưẻ', 'ưẻwe', 'ưẻwẻ', 'haha123@gmail.com', '1', '', 75000, 0, '2024-05-12'),
(7, 20, 'jkọkljklmkl', 'klkl;kl;k;', 'kilpklpklp', 'lklpk', 'kjkọkọ', 'huihuihui', 'haha123@gmail.com', '1', '', 1500000, 0, '2024-05-12'),
(8, 20, 'qưe', '123', '123', '123', '123', '123', 'haha123@gmail.com', '1', '', 1500000, 0, '2024-05-12'),
(9, 20, '123', '123', '123', '123', '123', '123', 'haha123@gmail.com', '1', '', 1750000, 0, '2024-05-12'),
(17, 20, '123', '123', '123', '123', '123', '123', 'haha123@gmail.com', '1', '', 1750000, 0, '2024-05-12'),
(18, 21, 'baohuy', '0905046373', '9 dường 75', 'tân quy', 'quận 7', 'Hồ chí minh', 'haha123@gmail.com', '1', '', 1500000, 0, '2024-05-13'),
(19, 21, 'anh triết', '0923857463', '9 dường 75', 'tân quy', 'quận 7', 'Hồ chí minh', 'haha123@gmail.com', '2', '', 1200000, 0, '2024-05-13');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders_detail`
--

CREATE TABLE `orders_detail` (
  `idDetail` int(100) NOT NULL,
  `IDorders` int(100) NOT NULL,
  `pid` int(100) NOT NULL,
  `quantity` int(100) NOT NULL,
  `subtotal` int(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders_detail`
--

INSERT INTO `orders_detail` (`idDetail`, `IDorders`, `pid`, `quantity`, `subtotal`) VALUES
(1, 3, 10, 1, 1500000),
(2, 3, 13, 1, 350000),
(3, 4, 10, 1, 1500000),
(4, 4, 16, 1, 100000),
(5, 5, 31, 1, 75000),
(6, 6, 31, 1, 75000),
(7, 7, 10, 1, 1500000),
(8, 0, 10, 1, 1500000),
(9, 0, 9, 1, 1750000),
(10, 17, 9, 1, 1750000),
(11, 18, 10, 1, 1500000),
(12, 19, 11, 1, 1200000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_category`
--

CREATE TABLE `tbl_category` (
  `cateid` int(10) NOT NULL,
  `categoryName` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_category`
--

INSERT INTO `tbl_category` (`cateid`, `categoryName`) VALUES
(15, 'Chiến lược'),
(20, 'cờ'),
(21, 'Nhập vai'),
(22, 'Nhóm bạn'),
(23, 'Gia đình'),
(24, 'May mắn');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_products`
--

CREATE TABLE `tbl_products` (
  `pid` int(10) NOT NULL,
  `img` varchar(50) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `price` varchar(20) NOT NULL,
  `detail` varchar(500) NOT NULL,
  `quantity` int(10) NOT NULL,
  `cid` int(10) NOT NULL,
  `oid` int(10) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_products`
--

INSERT INTO `tbl_products` (`pid`, `img`, `productName`, `price`, `detail`, `quantity`, `cid`, `oid`, `status`) VALUES
(9, 'alma mater 1tr750.webp', 'Alma Mater', '1750000', 'asd', 12, 15, 0, 0),
(10, 'doomtown 1tr500.webp', 'Doom Town', '1500000', 'ád', 14, 15, 0, 0),
(11, 'fertility 1tr200.jpg', 'Fertility', '1200000', 'ád', 17, 15, 0, 0),
(12, 'marrakech 450k.webp', 'Marrakech', '450000', 'ád', 19, 15, 0, 0),
(13, 'ModernArt 350k.jpg', 'Modern Art', '350000', 'ád', 14, 15, 0, 0),
(14, 'chess 100k.jpg', 'Cờ vua', '100000', 'ád', 12, 20, 0, 0),
(16, 'co tuong 50k.jpg', 'Cờ tướng', '100000', 'ád', 15, 20, 0, 0),
(17, 'co ty phu 350k.webp', 'Cờ tỷ phú', '3500000', 'ád', 13, 20, 0, 0),
(18, 'co vay-caro 190k.webp', 'Cờ vây', '190000', 'ád', 20, 20, 0, 0),
(22, 'bai con thỏ 175k.png', 'Bài con thỏ', '175000', 'ádasd', 21, 23, 0, 0),
(23, 'boardgame Xếp Toán - Cộng Trừ 150k.jpg', 'Xếp toán', '150000', 'ád', 24, 23, 0, 0),
(24, 'co co tich 350k.webp', 'Cờ cổ tích', '350000', 'qá', 24, 23, 0, 0),
(25, 'hội phố 230k.jpg', 'Hội phố', '230000', 'ád', 24, 23, 0, 0),
(28, 'cuoc chien hoa qua 135k.jpg', 'Cuộc chiến hoa quả', '135000', 'ád', 13, 15, 0, 0),
(29, 'cuoc chien hoa qua 135k.jpg', 'Cuộc chiến hoa quả', '135000', 'ád', 13, 24, 0, 0),
(30, 'kham rang ca sau 65k.jpg', 'Khám răng cá sấu', '65000', 'ád', 26, 24, 0, 0),
(31, 'pha bang chim canh cut 75k.jpg', 'Phá băng chim cánh cụt', '75000', 'ád', 27, 24, 0, 0),
(32, 'rùa pacman 70k.jpg', 'Rùa pacman', '70000', 'ád', 21, 24, 0, 0),
(33, 'thung hai tac 65k.jpg', 'Thùng hải tặc', '60000', 'ád', 19, 24, 0, 0),
(34, 'avalon 160k.jpg', 'Avalon', '200000', 'ád', 19, 21, 0, 0),
(35, 'cluedo 350k.jpg', 'Cluedo', '350000', 'ád', 21, 21, 0, 0),
(36, 'coup 120k.jpg', 'Coup', '120000', 'ád', 23, 21, 0, 0),
(37, 'the resistance 150k.jpg', 'The resistance', '240000', 'ád', 25, 21, 0, 0),
(38, 'rick and morty 120k.jpg', 'rick and morty', '120000', 'ád', 29, 21, 0, 0),
(39, 'joking hazard 200k.jpg', 'Joking hazard', '200000', 'ád', 24, 22, 0, 0),
(40, 'lầy 90k.webp', 'Lầy', '90000', 'ád', 16, 22, 0, 0),
(41, 'lên 90k.webp', 'Lên', '90000', 'ád', 12, 22, 0, 0),
(42, 'mõm 89k.jpg', 'Mõm ', '80000', 'ád', 12, 22, 0, 0),
(43, 'jamaica 420k.webp', 'Jamaica', '420000', 'ádasd', 19, 15, 0, 0),
(44, 'small world 550k.webp', 'Small world', '550000', 'ád', 29, 15, 0, 0),
(45, 'wingspan 700k.png', 'Wingspan', '750000', 'aqsd', 21, 15, 0, 0),
(46, 'co tam quoc 500k.jpeg', 'Cờ tam quốc', '500000', 'ád', 25, 20, 0, 0),
(47, 'co dan gian 75k.jpg', 'Cờ dân gian', '90000', 'ád', 18, 20, 0, 0),
(48, 'co ca ngua 50k.webp', 'Cờ cá ngựa', '80000', 'ád', 19, 20, 0, 0),
(49, 'coup reformation 99k.jpg', 'Coup reformation', '120000', 'ád', 21, 21, 0, 0),
(50, 'quest 190k.jpg', 'Quest', '175000', 'ád', 21, 21, 0, 0),
(51, 'khurungkimcuong.jpg', 'Khu rừng kim cương', '285000', 'ád', 15, 21, 0, 0),
(52, 'Starwar.png', 'Star war', '550000', 'ád', 10, 21, 0, 0),
(53, 'bomlac.png', 'Bom lắc', '125000', 'ád', 12, 22, 0, 0),
(54, 'MooncakeMaster.png', 'Mooncake master', '260000', 'ád', 11, 22, 0, 0),
(55, 'vuahaitac.png', 'Vua hải tặc', '340000', 'ád', 11, 22, 0, 0),
(56, 'doraemon.png', 'Doraemon', '540000', 'ád', 20, 22, 0, 0),
(57, 'wolfoo.png', 'Worfoo', '650000', 'ád', 21, 22, 0, 0),
(58, 'living forest 365k.jpg', 'Living forest', '950000', 'ád', 19, 23, 0, 0),
(59, 'codaquy.png', 'Cờ đá quý', '850000', 'ádasd', 28, 23, 0, 0),
(60, 'meow.png', 'Meow', '440000', 'ádasd', 27, 23, 0, 0),
(61, 'red7.png', 'Red7', '450000', 'ádasd', 22, 23, 0, 0),
(62, 'touchit.png', 'Touch it', '455000', 'dads', 21, 23, 0, 0),
(63, 'cho giu xuong 150k.jpg', 'Chó giữ xương', '120000', 'ád', 24, 24, 0, 0),
(64, 'pop up 90k.jpg', 'Pop up', '250000', 'ád', 24, 24, 0, 0),
(65, 'uno.png', 'Uno', '250000', 'ád', 24, 24, 0, 0),
(66, 'Bomlac2.png', 'Bom lắc 2', '230000', 'ád', 17, 24, 0, 0),
(69, 'domino 75k.jpg', 'Domino', '240000', 'ád', 21, 20, 0, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` int(10) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(60) NOT NULL,
  `street` varchar(100) NOT NULL,
  `ward` varchar(100) NOT NULL,
  `district` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phonenumber` int(20) NOT NULL,
  `role` int(10) NOT NULL DEFAULT 0,
  `action` int(10) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `username`, `password`, `email`, `street`, `ward`, `district`, `city`, `phonenumber`, `role`, `action`) VALUES
(20, 'anhtriet', '$2y$10$3Yl45G.oRqo.RiF1bU3dWu7UIP2ras.x3eM40Wy2xtu9UeOlACSuy', 'haha123@gmail.com', '', '', '', '', 899517129, 0, 1),
(21, 'anhtriet123', '$2y$10$tDpLPrsc4uuWdkC29KYiQuyvFmETYt5pOKzcSgJkM3pgvP/X9C89u', 'haha123@gmail.com', '273 an dương vương', '5', '5', 'TP Hồ Chí Minh', 899517129, 0, 0),
(22, 'admin', 'huytran123', 'tranhuy@gmail.com', '9 đường 75', 'Tân Phong', 'Quận 7', 'Hồ Chí Minh', 95046373, 1, 0);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`IDorders`),
  ADD KEY `fk_oders_users` (`id`);

--
-- Chỉ mục cho bảng `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD PRIMARY KEY (`idDetail`),
  ADD KEY `fk_products_details` (`pid`);

--
-- Chỉ mục cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  ADD PRIMARY KEY (`cateid`);

--
-- Chỉ mục cho bảng `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `fk_products_category` (`cid`);

--
-- Chỉ mục cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `IDorders` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT cho bảng `orders_detail`
--
ALTER TABLE `orders_detail`
  MODIFY `idDetail` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `tbl_category`
--
ALTER TABLE `tbl_category`
  MODIFY `cateid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `tbl_products`
--
ALTER TABLE `tbl_products`
  MODIFY `pid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT cho bảng `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_oders_users` FOREIGN KEY (`id`) REFERENCES `tbl_users` (`id`);

--
-- Các ràng buộc cho bảng `orders_detail`
--
ALTER TABLE `orders_detail`
  ADD CONSTRAINT `fk_products_details` FOREIGN KEY (`pid`) REFERENCES `tbl_products` (`pid`);

--
-- Các ràng buộc cho bảng `tbl_products`
--
ALTER TABLE `tbl_products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`cid`) REFERENCES `tbl_category` (`cateid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
