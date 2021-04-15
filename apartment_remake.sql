-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 15, 2021 lúc 12:28 PM
-- Phiên bản máy phục vụ: 10.4.13-MariaDB
-- Phiên bản PHP: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `apartment_remake`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `idSql` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  `Username` varchar(30) NOT NULL,
  `Sex` tinyint(1) NOT NULL,
  `Birthday` date NOT NULL,
  `IDCard` varchar(12) NOT NULL,
  `idPosition` int(5) NOT NULL,
  `regDate` datetime NOT NULL,
  `pathAvatar` varchar(150) NOT NULL,
  `path_IDCard1` varchar(150) DEFAULT NULL,
  `path_IDCard2` varchar(150) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`idSql`, `idUser`, `Username`, `Sex`, `Birthday`, `IDCard`, `idPosition`, `regDate`, `pathAvatar`, `path_IDCard1`, `path_IDCard2`) VALUES
(24, 10000027, 'Ngọc Sỹ', 1, '1999-05-05', '079099006587', 4, '2021-01-21 23:31:53', '1123093586-1611512090.jpg', NULL, NULL),
(25, 10000028, 'Le Minh Nghi', 1, '1996-01-21', '098900665879', 2, '2021-01-22 01:00:20', '1536093302-1611252020.jpg', NULL, NULL),
(26, 10000029, 'Ha Cao Ne', 0, '2000-01-04', '098099004535', 3, '2021-01-22 01:01:43', '1535001836-1611252103.jpg', NULL, NULL),
(27, 10000030, 'Nguyen Dinh', 1, '1989-10-06', '097088660568', 1, '2021-01-22 01:11:21', '1019541441-1611252681.jpg', NULL, NULL),
(28, 10000031, 'Me Meee', 1, '1985-01-05', '056800887987', 1, '2021-01-25 00:19:32', '1711578359-1611508772.jpg', NULL, NULL),
(29, 10000032, 'Hu huu', 1, '1996-01-25', '135364757', 1, '2021-01-25 00:30:08', '143611318-1611509408.jpg', NULL, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `apartment`
--

CREATE TABLE `apartment` (
  `idMain` int(11) NOT NULL,
  `idSub` int(11) NOT NULL,
  `name_apartment` varchar(30) NOT NULL,
  `type_apartment` int(5) NOT NULL,
  `idStatus` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `apartment`
--

INSERT INTO `apartment` (`idMain`, `idSub`, `name_apartment`, `type_apartment`, `idStatus`) VALUES
(1037, 0, 'Apartment 1', 1, 3),
(1038, 0, 'Apartment 2', 1, 3),
(1039, 1037, 'Block 1A', 2, 3),
(1040, 1039, '1A.Tầng 1', 3, 3),
(1041, 1039, '1A.Tầng 2', 3, 3),
(1042, 1040, '1A.01-01', 4, 1),
(1043, 1040, 'A1.01-02', 4, 1),
(1044, 1040, 'A1.01-03', 4, 3),
(1045, 1041, '1A.02-01', 4, 3),
(1051, 1038, 'Block 2A', 2, 3),
(1052, 1037, 'Block 1B', 2, 3),
(1053, 1052, '1B. Tầng 1', 3, 3),
(1054, 0, 'Aparment 3', 1, 2),
(1055, 1040, '1A.01-04', 4, 4),
(1056, 1041, '1A.02-02', 4, 4),
(1057, 1041, '1A.02-03', 4, 4),
(1058, 1039, '1A.Tầng 3', 3, 3),
(1059, 1058, '1A.03-01', 4, 4),
(1060, 1052, '1B.Tầng 2 ', 3, 3),
(1061, 1053, '1B.01-01', 4, 4),
(1062, 1053, '1B.01-02', 4, 4),
(1063, 1038, 'Block 2B', 2, 3),
(1064, 1051, '2A. Tầng 1', 3, 3),
(1065, 1051, '2A. Tầng 2', 3, 3),
(1066, 1064, '2A.01-01', 4, 4),
(1067, 1064, '2A.01-02', 4, 4),
(1068, 1064, '2A.01-03', 4, 4),
(1069, 1065, '2A.02-01', 4, 4),
(1070, 1065, '2A.02-03', 4, 4);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `history_service_home`
--

CREATE TABLE `history_service_home` (
  `idHistory` int(11) NOT NULL,
  `regDate` datetime NOT NULL,
  `expDate` datetime NOT NULL,
  `type_service` int(11) NOT NULL,
  `idHome` int(11) NOT NULL,
  `value` int(11) NOT NULL,
  `name_service` varchar(50) NOT NULL,
  `total_payment` decimal(10,0) NOT NULL,
  `confirm` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `history_service_home`
--

INSERT INTO `history_service_home` (`idHistory`, `regDate`, `expDate`, `type_service`, `idHome`, `value`, `name_service`, `total_payment`, `confirm`) VALUES
(10, '2020-11-22 01:21:56', '2020-12-21 01:21:56', 10040, 1045, 200, 'Dịch vụ Điện', '600000', b'1'),
(11, '2020-11-22 01:21:54', '2020-12-21 01:21:54', 10041, 1045, 60, 'Dịch vụ Nước', '0', b'0'),
(12, '2021-01-25 00:59:11', '2021-02-24 00:59:11', 10040, 1042, 500, 'Dịch vụ Điện', '1500000', b'1'),
(13, '2021-01-25 00:59:09', '2021-02-24 00:59:09', 10041, 1042, 300, 'Dịch vụ Nước', '0', b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `information_bank`
--

CREATE TABLE `information_bank` (
  `idSql` int(11) NOT NULL,
  `NameBank` varchar(60) NOT NULL,
  `NameAccount` varchar(60) NOT NULL,
  `BrandBank` varchar(100) NOT NULL,
  `NumberAccount` varchar(20) NOT NULL,
  `FullNameBank` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `information_bank`
--

INSERT INTO `information_bank` (`idSql`, `NameBank`, `NameAccount`, `BrandBank`, `NumberAccount`, `FullNameBank`) VALUES
(1, 'Techcombank', 'LÀNG TRẺ EM SOS VIỆT NAM', 'Hà Nội', '191 345 522 840 19', 'Ngân hàng TMCP Kỹ thương Việt Nam'),
(2, 'Agribank', 'TRƯỜNG ĐẠI HỌC CÔNG NGHỆ TP HCM', 'Sài Gòn', '1600 201 058 790', 'Ngân hàng Nông nghiệp và Phát triển Nông thôn Việt Nam');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `information_contact`
--

CREATE TABLE `information_contact` (
  `idSql` int(11) NOT NULL,
  `NameContact` varchar(60) NOT NULL,
  `AddressContact` varchar(255) NOT NULL,
  `TelContact` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `information_contact`
--

INSERT INTO `information_contact` (`idSql`, `NameContact`, `AddressContact`, `TelContact`) VALUES
(3, 'Tòa nhà A', '32 Đường A, Quận Bình Thạnh, TP HCM', '0586252912');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login`
--

CREATE TABLE `login` (
  `idUser` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `PhoneNumber` varchar(16) NOT NULL,
  `Password` varchar(32) NOT NULL,
  `Disable` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `login`
--

INSERT INTO `login` (`idUser`, `Email`, `PhoneNumber`, `Password`, `Disable`) VALUES
(10000027, 'bearof1999@gmail.com', '0586209147', '4297f44b13955235245b2497399d7a93', b'0'),
(10000028, 'kinhdoanh@gmail.com', '0584789868', '4297f44b13955235245b2497399d7a93', b'0'),
(10000029, 'quanly@gmail.com', '0345568987', '4297f44b13955235245b2497399d7a93', b'0'),
(10000030, 'khachhang1@gmail.com', '0356689754', '4297f44b13955235245b2497399d7a93', b'0'),
(10000031, 'khachhang2@gmail.com', '0548798978', '4297f44b13955235245b2497399d7a93', b'0'),
(10000032, 'khachhang3@gmail.com', '0458898788', '4297f44b13955235245b2497399d7a93', b'0');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `notification`
--

CREATE TABLE `notification` (
  `idNotify` int(11) NOT NULL,
  `notify_title` varchar(50) NOT NULL,
  `notify_text` text NOT NULL,
  `notify_datePost` datetime NOT NULL,
  `notify_idUserPost` int(11) NOT NULL,
  `notify_typeUser` int(1) NOT NULL,
  `pathImage` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `notification`
--

INSERT INTO `notification` (`idNotify`, `notify_title`, `notify_text`, `notify_datePost`, `notify_idUserPost`, `notify_typeUser`, `pathImage`) VALUES
(26, 'TĂNG CƯỜNG CÔNG TÁC ĐỀ CAO CẢNH GIÁC', '- Thông báo về việc tăng cường công tác đề cao cảnh giác phòng chống tội phạm Hiện nay đang là thời điểm diễn ra giải bóng đá thế giới World Cup nên tình hình tội phạm có chiều hướng gia tăng. \r\n- Để hạn chế các tác động xấu từ bên ngoài đến con người và tài sản của Cư dân', '2021-01-25 00:49:30', 10000029, 1, '206199464-1611510203.jpg'),
(27, 'THÔNG BÁO NGHỈ TẾT', '- Tết Dương lịch 2021 đã đến rất gần rồi, các công ty cần phải lên kế hoạch sớm cho lịch nghỉ lễ của nhân viên cũng như các chế độ phúc lợi của nhân viên vào dịp lễ này.\r\n- Hiện nay cùng phát triển với thời đại công nghệ 4.0 nên hầu hết các công ty, doanh nghiệp đều có các trang web riêng hay các trang fanpage của công ty.\r\n- Vì vậy ngoài việc ra thônag báo lịch nghỉ tết bằng văn bản thì các công ty thường đăng tải các banner thông báo lịch nghỉ tết hay các ảnh đăng tin lịch nghỉ tết của công ty để các nhân viên cũng như người tiêu dùng và đối tác nắm được. Dưới đây là mẫu banner thông báo lịch nghỉ Tết, Hoatieu.vn đã để sẵn file tải ở dạng PSD, các bạn chỉ cần sử dụng file tải và vào công cụ Text của photoshop để chỉnh sửa nội dung theo ý của mình. Hoặc các bạn có thể sử dụng luôn nội dung trên ảnh thông báo lịch nghỉ tết cũng rất phù hợp với lịch nghỉ Tết năm 2021.', '2021-01-25 00:32:25', 10000027, 2, '882580618-1611509547.jpg'),
(28, 'Nộp các khoản phí sử dụng dịch vụ', '- Để tạo điều kiện thuận lợi cho Quý Cư dân trong việc nộp các khoản phí sử dụng dịch vụ (trông giữ xe, tiền sử dụng nước, phí dịch vụ quản lý, tiền đặt cọc sửa chữa…) tại chung cư NSY Apartment.\r\n- Công ty CP ADU Thương mại và Dịch vụ – Đơn vị quản lý dịch vụ Khu nhà ở Chung cư cao tầng xin thông báo, kể từ nay, Quý cư dân có thể lựa chọn một trong hai hình thức nộp phí cho Đơn vị quản lý dịch vụ, theo chi tiết như sau:\r\n1. Tiền mặt\r\n2. Chuyển khoản ngân hàng', '2021-01-25 00:35:20', 10000027, 1, '1975441233-1611509720.jpg'),
(29, 'Tiêu chuẩn phòng cháy chữa cháy', '- Đối với những tòa nhà cao tầng, hệ thống phòng cháy chữa cháy là một yếu tố an toàn không thể thiếu. Đặc biệt, đối với các tòa nhà văn phòng cần đạt tiêu chuẩn phòng cháy chữa cháy nhà cao tầng, các doanh nghiệp, công ty thuê văn phòng mới tại những tòa nhà này mới đủ điều kiện xin giấy phép đăng ký kinh doanh.\r\n- Những quy định đó bao gồm:\r\n1. Trang bị hệ thống báo cháy tự động\r\n2. Trang bị bình chữa cháy đầy đủ\r\n3. Lối thoát hiểm được trang bị hệ thống cửa chắc chắn\r\n4. Thiết kế 1 – 2 họng nước tại các điểm trong tòa nhà\r\n5. Được thiết kế tối thiểu 2 lối thoát hiểm', '2021-01-25 02:59:24', 10000027, 1, '1049823424-1611518365.jpg'),
(30, 'sadas', 'asdasd', '2021-01-25 10:56:40', 10000027, 1, '496737798-1611547000.jpg');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `owner_home`
--

CREATE TABLE `owner_home` (
  `idUser` int(11) NOT NULL,
  `idHome` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `owner_home`
--

INSERT INTO `owner_home` (`idUser`, `idHome`) VALUES
(10000030, 1042),
(10000030, 1045),
(10000031, 1043),
(10000032, 1042),
(10000032, 1044);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `position`
--

CREATE TABLE `position` (
  `idPosition` int(5) NOT NULL,
  `namePosition` varchar(30) NOT NULL,
  `groupPosition` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `position`
--

INSERT INTO `position` (`idPosition`, `namePosition`, `groupPosition`) VALUES
(1, 'Khách hàng', 1),
(2, 'Kinh doanh', 2),
(3, 'Quản lý', 2),
(4, 'Admin', 3);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rent_house`
--

CREATE TABLE `rent_house` (
  `idRent` int(11) NOT NULL,
  `idMain` int(11) NOT NULL,
  `priceRent` decimal(11,0) NOT NULL,
  `dateRent` datetime NOT NULL,
  `dateExp` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `rent_house`
--

INSERT INTO `rent_house` (`idRent`, `idMain`, `priceRent`, `dateRent`, `dateExp`) VALUES
(8, 1042, '5000000', '2021-01-21 23:41:37', '2021-02-20 23:41:37'),
(9, 1043, '4000000', '2021-02-24 00:28:10', '2021-03-26 00:28:10');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `service`
--

CREATE TABLE `service` (
  `idService` int(11) NOT NULL,
  `regDate` datetime NOT NULL,
  `expDate` datetime NOT NULL,
  `type_service` int(11) NOT NULL,
  `idHome` int(11) NOT NULL,
  `value` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `service`
--

INSERT INTO `service` (`idService`, `regDate`, `expDate`, `type_service`, `idHome`, `value`) VALUES
(1035, '2021-12-21 01:21:54', '2021-01-21 01:21:54', 10041, 1045, NULL),
(1036, '2021-12-21 01:21:56', '2021-01-21 01:21:56', 10040, 1045, NULL),
(1038, '2020-12-28 00:19:51', '2021-01-28 00:19:51', 10041, 1043, NULL),
(1039, '2020-12-28 00:19:53', '2021-01-28 00:19:53', 10040, 1043, NULL),
(1041, '2021-01-25 00:30:56', '2021-02-24 00:30:56', 10041, 1044, NULL),
(1042, '2021-01-25 00:30:58', '2021-02-24 00:30:58', 10040, 1044, NULL),
(1043, '2021-02-24 00:59:09', '2021-03-25 00:59:09', 10041, 1042, NULL),
(1044, '2021-02-24 00:59:11', '2021-03-25 00:59:11', 10040, 1042, NULL),
(1046, '2021-01-25 10:53:17', '2021-02-24 10:53:17', 10042, 1042, NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `status_general`
--

CREATE TABLE `status_general` (
  `idStatus` int(5) NOT NULL,
  `name_status` varchar(50) NOT NULL,
  `groupStatus` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `status_general`
--

INSERT INTO `status_general` (`idStatus`, `name_status`, `groupStatus`) VALUES
(1, 'Đang cho thuê', 1),
(2, 'Không hoạt động', 1),
(3, 'Hoạt động', 1),
(4, 'Còn trống', 1),
(5, 'Đã trả lời', 2),
(6, 'Đang xử lý', 2),
(7, 'Hoàn thành', 2),
(8, 'Mới', 2);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket`
--

CREATE TABLE `ticket` (
  `idTicket` int(11) NOT NULL,
  `ticket_idPosition` int(5) NOT NULL,
  `ticket_idStatus` int(5) NOT NULL,
  `dateCreate` datetime NOT NULL,
  `tittle_ticket` varchar(70) NOT NULL,
  `closed` tinyint(1) NOT NULL,
  `idUser_create` int(11) NOT NULL,
  `idUser_lastpost` int(11) NOT NULL,
  `idHome` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `ticket`
--

INSERT INTO `ticket` (`idTicket`, `ticket_idPosition`, `ticket_idStatus`, `dateCreate`, `tittle_ticket`, `closed`, `idUser_create`, `idUser_lastpost`, `idHome`) VALUES
(1015, 3, 7, '2021-01-22 01:50:24', 'Vòi nước nhà mình bị hư', 1, 10000030, 10000027, 1045),
(1017, 2, 5, '2021-01-23 23:46:07', 'Help', 0, 10000030, 10000027, 1042),
(1018, 2, 5, '2021-01-25 10:53:50', 'asd', 0, 10000030, 10000027, 1042);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `ticket_text`
--

CREATE TABLE `ticket_text` (
  `idTicket_text` int(11) NOT NULL,
  `idTicket` int(11) NOT NULL,
  `idUser_post` int(11) NOT NULL,
  `dateSend` datetime NOT NULL,
  `ticket_text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `ticket_text`
--

INSERT INTO `ticket_text` (`idTicket_text`, `idTicket`, `idUser_post`, `dateSend`, `ticket_text`) VALUES
(1286, 1015, 10000030, '2021-01-22 01:50:24', 'Vòi nước nhà mình bị hư rồi mình ở phòng 1A.02-01 nha'),
(1287, 1015, 10000027, '2021-01-22 23:16:33', 'Oke'),
(1291, 1017, 10000030, '2021-01-23 23:46:07', 'Help me'),
(1292, 1017, 10000027, '2021-01-23 23:46:34', 'Sao z'),
(1298, 1018, 10000030, '2021-01-25 10:53:50', 'sadsad'),
(1299, 1018, 10000027, '2021-01-25 10:54:00', 'wqdwq');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type_apartment`
--

CREATE TABLE `type_apartment` (
  `idType_apartment` int(5) NOT NULL,
  `name_type_apartment` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `type_apartment`
--

INSERT INTO `type_apartment` (`idType_apartment`, `name_type_apartment`) VALUES
(1, 'Tòa nhà'),
(2, 'Block'),
(3, 'Tầng'),
(4, 'Căn hộ');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `type_service`
--

CREATE TABLE `type_service` (
  `idType_service` int(11) NOT NULL,
  `name_service` varchar(50) NOT NULL,
  `description_service` varchar(150) NOT NULL,
  `price_service` decimal(10,0) NOT NULL,
  `unit` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `imageTypeService` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `type_service`
--

INSERT INTO `type_service` (`idType_service`, `name_service`, `description_service`, `price_service`, `unit`, `type`, `imageTypeService`) VALUES
(10040, 'Dịch vụ Điện', '- Mô tả dịch vụ Điện', '3000', 'kW', 1, '215563142-1611252857.jpg'),
(10041, 'Dịch vụ Nước', '- Mô tả dịch vụ Nước', '5000', 'm3', 1, '453323851-1611252901.jpg'),
(10042, 'Dịch vụ Gửi xe', '- Mô tả dịch vụ Gửi xe', '250000', '', 0, '6460241949-1611512222.jpg');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`idSql`),
  ADD UNIQUE KEY `idUser` (`idUser`),
  ADD UNIQUE KEY `IDCard` (`IDCard`),
  ADD UNIQUE KEY `pathAvatar` (`pathAvatar`),
  ADD UNIQUE KEY `path_IDCard1` (`path_IDCard1`),
  ADD UNIQUE KEY `path_IDCard2` (`path_IDCard2`),
  ADD KEY `ChucVu` (`idPosition`);

--
-- Chỉ mục cho bảng `apartment`
--
ALTER TABLE `apartment`
  ADD PRIMARY KEY (`idMain`),
  ADD KEY `idStatus_general` (`idStatus`),
  ADD KEY `idType_apartment` (`type_apartment`);

--
-- Chỉ mục cho bảng `history_service_home`
--
ALTER TABLE `history_service_home`
  ADD PRIMARY KEY (`idHistory`),
  ADD KEY `idHome` (`idHome`);

--
-- Chỉ mục cho bảng `information_bank`
--
ALTER TABLE `information_bank`
  ADD PRIMARY KEY (`idSql`);

--
-- Chỉ mục cho bảng `information_contact`
--
ALTER TABLE `information_contact`
  ADD PRIMARY KEY (`idSql`);

--
-- Chỉ mục cho bảng `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`idUser`),
  ADD UNIQUE KEY `Email` (`Email`),
  ADD UNIQUE KEY `PhoneNumber` (`PhoneNumber`);

--
-- Chỉ mục cho bảng `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`idNotify`),
  ADD KEY `notify_idPosition` (`notify_typeUser`),
  ADD KEY `notify_idUserPost` (`notify_idUserPost`);

--
-- Chỉ mục cho bảng `owner_home`
--
ALTER TABLE `owner_home`
  ADD PRIMARY KEY (`idUser`,`idHome`),
  ADD UNIQUE KEY `idUser_idHome` (`idUser`,`idHome`) USING BTREE,
  ADD KEY `HomeNe` (`idHome`);

--
-- Chỉ mục cho bảng `position`
--
ALTER TABLE `position`
  ADD PRIMARY KEY (`idPosition`);

--
-- Chỉ mục cho bảng `rent_house`
--
ALTER TABLE `rent_house`
  ADD PRIMARY KEY (`idRent`),
  ADD KEY `rent_house` (`idMain`);

--
-- Chỉ mục cho bảng `service`
--
ALTER TABLE `service`
  ADD PRIMARY KEY (`idService`),
  ADD UNIQUE KEY `type_service` (`type_service`,`idHome`),
  ADD KEY `idHome_service` (`idHome`),
  ADD KEY `idType_service` (`type_service`);

--
-- Chỉ mục cho bảng `status_general`
--
ALTER TABLE `status_general`
  ADD PRIMARY KEY (`idStatus`);

--
-- Chỉ mục cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`idTicket`),
  ADD KEY `ticket_idPosition` (`ticket_idPosition`),
  ADD KEY `ticket_idStatus` (`ticket_idStatus`);

--
-- Chỉ mục cho bảng `ticket_text`
--
ALTER TABLE `ticket_text`
  ADD PRIMARY KEY (`idTicket_text`),
  ADD KEY `idTicket` (`idTicket`);

--
-- Chỉ mục cho bảng `type_apartment`
--
ALTER TABLE `type_apartment`
  ADD PRIMARY KEY (`idType_apartment`);

--
-- Chỉ mục cho bảng `type_service`
--
ALTER TABLE `type_service`
  ADD PRIMARY KEY (`idType_service`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `account`
--
ALTER TABLE `account`
  MODIFY `idSql` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT cho bảng `apartment`
--
ALTER TABLE `apartment`
  MODIFY `idMain` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1071;

--
-- AUTO_INCREMENT cho bảng `history_service_home`
--
ALTER TABLE `history_service_home`
  MODIFY `idHistory` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `information_bank`
--
ALTER TABLE `information_bank`
  MODIFY `idSql` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `information_contact`
--
ALTER TABLE `information_contact`
  MODIFY `idSql` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `login`
--
ALTER TABLE `login`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000033;

--
-- AUTO_INCREMENT cho bảng `notification`
--
ALTER TABLE `notification`
  MODIFY `idNotify` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `rent_house`
--
ALTER TABLE `rent_house`
  MODIFY `idRent` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `service`
--
ALTER TABLE `service`
  MODIFY `idService` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1048;

--
-- AUTO_INCREMENT cho bảng `ticket`
--
ALTER TABLE `ticket`
  MODIFY `idTicket` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1019;

--
-- AUTO_INCREMENT cho bảng `ticket_text`
--
ALTER TABLE `ticket_text`
  MODIFY `idTicket_text` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1300;

--
-- AUTO_INCREMENT cho bảng `type_service`
--
ALTER TABLE `type_service`
  MODIFY `idType_service` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10043;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `account`
--
ALTER TABLE `account`
  ADD CONSTRAINT `ChucVu` FOREIGN KEY (`idPosition`) REFERENCES `position` (`idPosition`),
  ADD CONSTRAINT `idUser` FOREIGN KEY (`idUser`) REFERENCES `login` (`idUser`);

--
-- Các ràng buộc cho bảng `apartment`
--
ALTER TABLE `apartment`
  ADD CONSTRAINT `idStatus_general` FOREIGN KEY (`idStatus`) REFERENCES `status_general` (`idStatus`),
  ADD CONSTRAINT `idType_apartment` FOREIGN KEY (`type_apartment`) REFERENCES `type_apartment` (`idType_apartment`);

--
-- Các ràng buộc cho bảng `history_service_home`
--
ALTER TABLE `history_service_home`
  ADD CONSTRAINT `history_service_home_ibfk_1` FOREIGN KEY (`idHome`) REFERENCES `apartment` (`idMain`);

--
-- Các ràng buộc cho bảng `notification`
--
ALTER TABLE `notification`
  ADD CONSTRAINT `notification_ibfk_1` FOREIGN KEY (`notify_idUserPost`) REFERENCES `login` (`idUser`);

--
-- Các ràng buộc cho bảng `owner_home`
--
ALTER TABLE `owner_home`
  ADD CONSTRAINT `idHome_Owner` FOREIGN KEY (`idHome`) REFERENCES `apartment` (`idMain`),
  ADD CONSTRAINT `idUser_Owner` FOREIGN KEY (`idUser`) REFERENCES `login` (`idUser`);

--
-- Các ràng buộc cho bảng `rent_house`
--
ALTER TABLE `rent_house`
  ADD CONSTRAINT `rent_house` FOREIGN KEY (`idMain`) REFERENCES `apartment` (`idMain`);

--
-- Các ràng buộc cho bảng `service`
--
ALTER TABLE `service`
  ADD CONSTRAINT `idHome_service` FOREIGN KEY (`idHome`) REFERENCES `apartment` (`idMain`),
  ADD CONSTRAINT `idType_service` FOREIGN KEY (`type_service`) REFERENCES `type_service` (`idType_service`);

--
-- Các ràng buộc cho bảng `ticket`
--
ALTER TABLE `ticket`
  ADD CONSTRAINT `ticket_idPosition` FOREIGN KEY (`ticket_idPosition`) REFERENCES `position` (`idPosition`),
  ADD CONSTRAINT `ticket_idStatus` FOREIGN KEY (`ticket_idStatus`) REFERENCES `status_general` (`idStatus`);

--
-- Các ràng buộc cho bảng `ticket_text`
--
ALTER TABLE `ticket_text`
  ADD CONSTRAINT `ticket_text_ibfk_1` FOREIGN KEY (`idTicket`) REFERENCES `ticket` (`idTicket`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
