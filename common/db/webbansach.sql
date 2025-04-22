create database webbookstore;
-- drop database webbookstore;
use webbookstore;

create table `NCC` (
	`MaNCC` int primary key not null auto_increment,
    `TenNCC` varchar(255) not null,
    `DcNCC` varchar(255),
    `EmailNCC` varchar(255)
);

create table `NXB` (
	`MaNXB` int primary key not null auto_increment,
    `TenNXB` varchar(255) not null,
    `DcNXB` varchar(255),
    `EmailNXB` varchar(255)
);

create table `TacGia` (
	`MaTG` int primary key not null auto_increment,
	`TenTG` varchar(255) not null,
	`NgSinhTG` date,
	`GioiTinhTG` int	
);

create table `DauSach` (
	`MaSach` int primary key not null auto_increment,
	`TenSach` varchar(255) not null,
	`NamXB`int,
	`SoTrang` int,
	`MoTaChiTiet` longtext,
	`GiaBan` long,
	`SoLgTon` long,
    `SoLgDaBan` long default 0,
	`TinhTrang` int default 1,	-- 0: chưa mở bán, 1: đang bán
	`KichThuoc` varchar(50),
    `MaLoai` int not null,
    `MaTG` int not null,
    `MaNXB` int not null,
    `MaNCC` int not null 
);

-- ALTER TABLE `DauSach`
-- MODIFY COLUMN `NamXB` INT;
-- ALTER TABLE `DauSach`
-- MODIFY COLUMN `MoTaChiTiet` LONGTEXT;

create table `TheLoai` (
	`MaLoai` int primary key not null auto_increment,
	`TenLoai` varchar(100) not null
);

create table `NgDung` (
	`MaND` int primary key not null auto_increment,
    `TenND` varchar(255) not null,
    `DcND` varchar(255),
    `EmailND` varchar(255),
    `GioiTinhND` int not null,
    `SDT` varchar(255) not null,
    `NgSinhND` date
);

create table `TaiKhoan` (
	`MaTK` int primary key not null auto_increment,
    `TenTK` varchar(255) not null,
    `LoaiTK` int not null default 0,
    `NgLap` date not null,
    `TinhTrang` int not null default 1,	-- 1: hoạt động, 0: bị khóa
    `MKTK` varchar(255) not null,
    `MaND` int not null,
    `DaXoa` int default 0
);

-- create table `QuanLy`(
-- 	`MaTKQL` int not null,
-- 	`MaTKBQL` int not null
-- );

-- drop table QuanLy;

create table `DanhGia` (
	`MaDG` int primary key not null auto_increment,
	`PhanHoi` varchar(1000),
	`NoiDung` varchar(1000),
	`NgayViet` datetime,
    `MaKH` int not null,
    `MaAdmin` int,
    `MaSach` int not null
);

create table `HoaDon` (
	`MaHD` int primary key not null auto_increment,
    `MaNV` int not null,
    `MaKH` int not null,
    `NgLap` date not null,
	`TrangThaiDH` int default 1,
    `GhiChu` varchar(1000),
	`DiaChiGiaoHang` varchar(255) not null,
    `SDT` varchar(255) not null,
	`PhThucTT` int default 0,
    `PhThucVC` int default 0,
    `TongTien` long
);
-- PhThucTT: 1-COD, 2-QR
-- PhThucVC: 1-gia hàng thông thường, 2-giao hàng hỏa tốc
-- TrangThaiDH: 1-chờ duyệt, 2-đang giao, 3-đã giao, 0-đã hủy

create table `CTHD` (
	`SoLg` int not null,
	-- `GiaBan` long not null,
    `MaHD` int not null,
    `MaSach` int not null
);

create table `PhNhap` (
	`MaPhNhap` int primary key not null auto_increment,
    `MaNCC` int not null,
    `MaTK` int not null,
    `NgNhap` date not null, 
    `TongTien` long,
    `TinhTrang` int default 0
);

create table `CTPN` (
	`SoLgNhap` long not null,
	`GiaNhap` long not null,
    `MaSach` int not null,
    `MaPhNhap` int not null
);

create table `GioHang` (
	`MaGH` int primary key not null auto_increment,
    `MaTK` int not null
);

create table `CTGH` (
	`MaSach` int not null,
	`MaGH` int not null,
	`TinhTrang` int default 0,	-- 0: chưa được chọn, 1: được chọn
	`SoLg` int not null
	-- `GiaBan` long not null
);

create table `HinhAnh` (
	`MaHA` int primary key not null auto_increment,
	`DgDanAnh` LONGTEXT,
    `MaND` int,
    `MaSach` int
);

-- KHOAI CHINH --
alter table `CTPN` add constraint PK_DS_PN PRIMARY KEY(MaSach, MaPhNhap);
alter table `CTHD` add constraint PK_DS_HD PRIMARY KEY (MaSach, MaHD);
alter table `CTGH` add constraint PK_DS_GH PRIMARY KEY (MaSach, MaGH);
-- alter table `QuanLy` add constraint PK_TKQL_TKBQL PRIMARY KEY (MaTKQL, MaTKBQL);

-- KHOAI NGOAI --
alter table `DauSach` add constraint FK_DS_TL foreign key(MaLoai) references TheLoai(MaLoai);
alter table `DauSach` add constraint FK_DS_NXB foreign key(MaNXB) references NXB(MaNXB);
alter table `DauSach` add constraint FK_DS_TG foreign key(MaTG) references TacGia(MaTG);
alter table `DauSach` add constraint FK_DS_NCC foreign key(MaNCC) references NCC(MaNCC);
alter table `TaiKhoan` add constraint FK_TK_ND foreign key(MaND) references NgDung(MaND);
alter table `CTPN` add constraint FK_CTPN_DS FOREIGN KEY (MaSach) REFERENCES DauSach(MaSach);
alter table `CTPN` add constraint FK_CTPN_PN FOREIGN KEY (MaPhNhap) REFERENCES PhNhap(MaPhNhap);
alter table `HinhAnh` add constraint FK_HA_DS FOREIGN KEY (MaSach) REFERENCES DauSach(MaSach);
alter table `HinhAnh` add constraint FK_HA_ND FOREIGN KEY (MaND) REFERENCES NgDung(MaND);
alter table `HoaDon` add constraint FK_HD_TK FOREIGN KEY (MaNV) REFERENCES TaiKhoan(MaTK);
alter table `HoaDon` add constraint FK_HD_TK_2 FOREIGN KEY (MaKH) REFERENCES TaiKhoan(MaTK);
alter table `CTHD` add constraint FK_CTHD_DS FOREIGN KEY (MaSach) REFERENCES DauSach(MaSach);
alter table `CTHD` add constraint FK_CTHD_HD FOREIGN KEY (MaHD) REFERENCES HoaDon(MaHD);
alter table `GioHang` add constraint FK_GH_TK FOREIGN KEY (MaTK) REFERENCES TaiKhoan(MaTK);
alter table `CTGH` add constraint FK_CTGH_DS FOREIGN KEY (MaSach) REFERENCES DauSach(MaSach);
alter table `CTGH` add constraint FK_CTGH_GH FOREIGN KEY (MaGH) REFERENCES GioHang(MaGH);
-- alter table `QuanLy` add constraint FK_QL_TK FOREIGN KEY (MaTKQL) REFERENCES TaiKhoan(MaTK);
-- alter table `QuanLy` add constraint FK_QL_TK_2 FOREIGN KEY (MaTKBQL) REFERENCES TaiKhoan(MaTK);
alter table `PhNhap` add constraint FK_PN_NCC FOREIGN KEY (MaNCC) REFERENCES NCC(MaNCC);
alter table `PhNhap` add constraint FK_PN_TK FOREIGN KEY (MaTK) REFERENCES TaiKhoan(MaTK);
alter table `DanhGia` add constraint FK_DG_TK_1 FOREIGN KEY (MaKH) REFERENCES TaiKhoan(MaTK);
alter table `DanhGia` add constraint FK_DG_TK_2 FOREIGN KEY (MaAdmin) REFERENCES TaiKhoan(MaTK);
alter table `DanhGia` add constraint FK_DG_DS FOREIGN KEY (MaSach) REFERENCES DauSach(MaSach);

-- TRIGGER --
DELIMITER $$

CREATE TRIGGER create_empty_cart_and_set_default_profile
AFTER INSERT ON TaiKhoan
FOR EACH ROW
BEGIN
    IF NOT EXISTS (SELECT 1 FROM HinhAnh WHERE MaND = NEW.MaND) THEN
        INSERT INTO HinhAnh (DgDanAnh, MaND)
        VALUES ('/project-Web2/common/images/defaultuser.png', NEW.MaND);
    END IF;
    INSERT INTO GioHang (MaTK)
    VALUES (NEW.MaTK);
END $$

DELIMITER ;

-- INSERT --
insert into NCC (TenNCC, DcNCC, EmailNCC)
values ('Nhã Nam', '59 Đỗ Quang, Cầu Giấy, Hà Nội', 'bookstore@nhanam.vn'),
	   ('Phanbook', 'A1-06.04, Tầng 6 Khu Thương Mại Dịch Vụ, Tòa nhà Gold View, 346 Bến Vân Đồn, Phường 1, Quận 4, TP.HCM', 'info@phanbook.vn'),
       ('Nhà Xuất Bản Kim Đồng', 'Số 55 Quang Trung, Nguyễn Du, Hai Bà Trưng, Hà Nội', 'cskh_online@nxbkimdong.com.vn'),
       ('IPM', 'Số 110 Nguyễn Ngọc Nại, Khương Mai, Thanh Xuân, Hà Nội', 'online.ipmvn@gmail.com'),
       ('1980 Books', 'Nhà 20H2, Ngõ 6, Trần Kim Xuyến, Phường Yên Hòa, Quận Cầu Giấy, Hà Nội', 'info.1980books@gmail.com'),
       ('AZ Việt Nam', 'Số 50 đường 5, TTF361 An Dương, P. Yên Phụ, Q. Tây Hồ, Tp. Hà Nội', 'bophanbanle@azbooks.vn'),
       ('NXB Trẻ', '161B Lý Chính Thắng, Phường Võ Thị Sáu, Quận 3 , TP. Hồ Chí Minh', 'hopthubandoc@nxbtre.com.vn'),
       ('Đinh Tỵ', 'NV22 khu 12 ngõ 13 đường Lĩnh Nam, phường Mai Động, quận Hoàng Mai, Thành Phố Hà Nội', 'contacts@dinhtibooks.vn'),
       ('Kinokuniya Book Stores', 'Shinjuku, Tokyo, Japan', null),
       ('Nhà Sách Minh Thắng', '808 Đường Láng, Láng Thượng, Đống Đa, TP.Hà Nội', 'nhasachminhthang@yahoo.com.vn'),
       ('Walts comic shop', 'Wilhelm-von-Siemens-Straße 12, 12277 Berlin', 'info@waltscomicshop.com');
       
       
insert into NXB (TenNXB, DcNXB, EmailNXB)
values ('NXB Trẻ', '161B Lý Chính Thắng, Phường Võ Thị Sáu, Quận 3 , TP. Hồ Chí Minh', 'hopthubandoc@nxbtre.com.vn'),
	   ('Nhà Xuất Bản Kim Đồng', 'Số 55 Quang Trung, Nguyễn Du, Hai Bà Trưng, Hà Nội', 'cskh_online@nxbkimdong.com.vn'),
       ('Nhà xuất bản Tổng hợp thành phố Hồ Chí Minh', '62 Nguyễn Thị Minh Khai, Phường Đa Kao, Quận 1, TP. HCM', 'nstonhop@gmail.com'),
       ('Nhà xuất bản Hội Nhà văn', 'số 65 Nguyễn Du, Quận Hai Bà Trưng, Hà Nội ', 'nhaxuatbanhnv@gmail.com'),
       ('Nhà xuất bản Phụ nữ Việt Nam', '39 Hàng Chuối, Quận Hai Bà Trưng, Hà Nội', 'truyenthongvaprnxbpn@gmail.com'),
       ('Nhà xuất bản Lao Động ', '175 Giảng Võ, Đống Đa, Hà Nội ', 'nxblaodong@yahoo.com'),
       ('Nhã Nam', '59 Đỗ Quang, Cầu Giấy, Hà Nội', 'bookstore@nhanam.vn'),
       ('Đinh Tị Books', 'Nhà NV22 – Khu 12 – Ngõ 13 Lĩnh Nam – P. Mai Động – Q. Hoàng Mai – TP. Hà Nội', 'contacts@dinhtibooks.vn'),
       ('NXB Dân Trí', 'Số 9, ngõ 26, phố Hoàng Cầu, phường Ô Chợ Dừa, quận Đống Đa, Hà Nội', 'nxbdantri@gmail.com'),
       ('Thanh Niên', 'D29 Khu đô thị mới Cầu Giấy, phường Yên Hòa, quận Cầu Giấy, Hà Nội', 'info@nxbthanhnien.vn'),
       ('Công Ty Cổ Phần Công Nghệ Giáo Dục Trực Tuyến Aladanh', 'Tầng 3 No - 25 Tân Lập, Phường Bạch Mai, Quận Hai Bà Trưng, Thành phố Hà Nội, Việt Nam', null),
       ('Hà Nội', 'Số 4, phố Tống Duy Tân, phường Hàng Bông, quận Hoàn Kiếm, TP. Hà Nội', 'vanthu_nxbhn@hanoi.gov.vn'),
       ('Image Comics', 'Portland, Oregon 97293', ' international@imagecomics.com'),
       ('NXB Văn Học', '18 Nguyễn Trường Tộ - Ba Đình - Hà Nội', 'info@nxbvanhoc.com.vn'),
       ('Hồng Đức', '65 Tràng Thi, P.Hàng Bông, Q.Hoàn Kiếm, Hà Nội', 'nhaxuatbanhongduc65@gmail.com'),
	   ('Shueisha/Tsai Fong Books', null, null),
       ('‎Marvel Comics', '135 W. 50th Street, Manhattan, New York City', 'Ms-comms@marvelstudios.com'),
       ('Dc Comics', '4000 Warner Boulevard, Burbank, California', 'privacy@wb.com'),
       ('NXB Đại Học Quốc Gia Hà Nội', '16 Hàng Chuối, Phạm Đình Hổ, Hai Bà Trưng, Hà Nội, Vietnam', 'nxb@vnu.edu.vn'),
	   ('Harper Collins', '195 Broadway, New York City, New York, USA', 'consumercare@harpercollins.com'),
       ('Bloomsbury Publishing', '50 Bedford Square, London', 'contact@bloomsbury.com');
       
insert into TacGia (TenTG, NgSinhTG, GioiTinhTG)
values ('Gosho Aoyama', '1963-06-21', 0),
	   ('Daisuke Aizawa', null, null),
       ('Natsu Hyuuga', null, null),
       ('Emma Hạ My', null, 1),
       ('Hirotaka AKAGI', '1991-05-08', null),
       ('Toriyama Akira', '1955-04-05', 0),
       ('Gotoge Koyoharu', '1989-05-05', 1),
       ('Lưu Từ Hân', '1963-06-23', 0),
       ('Eiichiro Oda', '1975-01-01', 0),
       ('Edgar Allan Poe', '1809-01-19', 0),
       ('Bùi Văn Vinh', null, 0),
       ('Dương Hương', null, 1),
       ('Nguyễn Thế Duy', null, 0),
       ('Ngọc Linh', null, 1),
       ('Minna Lacey', null, 1),
       ('Joanne Rowling', '1965-07-31', 1),
       ('Nathalie Choux', null, 1),
       ('J.R.R. Tolkien', '1892-01-3', 1),
       ('Hồ Tâm', null, null),
       ('Clint Emerson', null, 0),
       ('Hà Yên', null, 1),
       ('Cửu Bả Đao', '1978-08-25', 0),
       ('Bạch Đường Tống Tử Tinh', null, null),
       ('Saekisan', '2009-01-15', 1),
       ('Dư Trình', null, null),
       ('Koume Fujichika', '1994-11-27', 1),
       ('Diệp Lạc Vô Tâm', null, null),
       ('Robert Kirkman', '1978-11-30', 0),
       ('Hajime Isayama', '1986-08-29', 0),
       ('Judd Winick', '1970-02-12', 0),
       ('Stan Lee', '1922-12-28', 0),
       ('Jack Kirby', '1917-08-28', 0),
       ('Oshioshio', null, 1);
       
insert into TheLoai (TenLoai)
values ('Tiểu thuyết'),
	   ('Kinh dị'),
       ('Giáo dục'),
       ('Manga'),
       ('Truyện tranh'),
       ('Lãng mạn'),
       ('Thiếu nhi');
       
INSERT INTO DauSach (TenSach, NamXB, SoTrang, MoTaChiTiet, GiaBan, SoLgTon, KichThuoc, MaLoai, MaTG, MaNXB, SoLgDaBan, MaNCC)
VALUES 
-- 1
('Thiên Sứ Nhà Bên - Tập 1', 2021, 320, 
'Thiên Sứ Nhà Bên - Tập 1\n\nHàng xóm kế bên căn hộ của Fujimiya Amane chính là nữ sinh xinh đẹp nhất trường cậu, Shiina Mahiru.\n\nHọ vốn chẳng có mối liên hệ nào cho đến một ngày mưa tầm tã, Amane tình nguyện đưa chiếc ô của mình cho cô bạn hàng xóm xinh đẹp tựa thiên thần, cả hai đã bắt đầu tương tác với nhau theo một cách kì quặc.\n\nChẳng thể chịu được lối sinh hoạt cẩu thả khi sống một mình của Amane, Mahiru đã quyết định sẽ chăm sóc cậu từ những điều nhỏ nhất.\n\nMột Mahiru thiếu thốn sự gắn kết với gia đình đang dần mở lòng hơn, cùng một Amane hay tự ti đang ngày một đổi thay theo chiều hướng tích cực. Khoảng cách giữa hai con người không chút thành thật ấy đang từng bước thu hẹp lại...\n\nĐây là câu chuyện tình ngọt ngào với cô gái nhà bên tuy lạnh lùng nhưng thật đáng yêu đã được ủng hộ nhiệt tình trên trang Shousetsuka ni Narou.\n\n* THIÊN SỨ NHÀ BÊNđược xem là cú hit của dòng Light Novel rom-com tại thị trường Nhật Bản, với nội dung hài hước - lãng mạn rất được yêu thích. Tác phẩm nằm top 10 Kono Light novel ga Sugoi năm 2021, đã bán ra hơn 400.000 bản chỉ với 4 tập truyện riêng tại Nhật Bản.\n\nSố tập: 5+ (on-going)\n\n---\n\nMột ấn phẩm của WINGS BOOKS - Thương hiệu sách trẻ của NXB Kim Đồng.', 
76000, 44, '19 x 13 cm', 1, 24, 2, 0, 1),

-- 2
('Chúa tể bóng tối - Tập 1', 2018, 422, 
'Bộ truyện với nhân vật chính siêu mạnh được chuyển sinh sang thế giới khác, chứa đầy hiểu nhầm hài hước đã chính thức ra mắt!!\n“Tên ta là Shadow. Ta ẩn mình trong bóng tối để săn lùng bóng tối…”\nKhông phải nhân vật chính, cũng chẳng phải trùm cuối. Ấy là những Chúa tể Bóng tối, bình thường thì che giấu thực lực, giả làm người thường, nhưng trong bóng tối lại thể hiện sức mạnh thực sự của mình để bí mật can thiệp vào câu chuyện. Cậu thiếu niên ngưỡng mộ Chúa tể Bóng tối của chúng ta ngày ngày rèn luyện trau dồi sức mạnh, đồng thời vẫn đóng vai một nhân vật quần chúng mờ nhạt trước mặt người đời, cho đến khi gặp tai nạn và được chuyển sinh sang một thế giới khác.\nVui sướng trước tình cảnh này, cậu thiếu niên, giờ mang tên Cid, đã quyết định “tưởng tượng” ra một “Giáo phái bóng tối” để (giả vờ) bí mật lật đổ, thoả mãn mong muốn đóng vai Chúa tể Bóng tối ở thế giới mới. Thế nhưng không ngờ “Giáo phái bóng tối” ấy lại có thật…?\nDo không ít hiểu nhầm mà những cô gái trở thành thuộc hạ của Cid đều sùng bái cậu, và chính bản thân Cid cũng không biết cậu đã trở thành một Chúa tể Bóng tối thực sự, tổ chức bóng đêm Shadow Garden do cậu đứng đầu đang dần tiêu diệt màn đêm che phủ thế giới…\n\n* CHÚA TỂ BÓNG TỐI là series light-novel ăn khách tại Nhật Bản, đã được chuyển thể thành manga, anime, chibi manga và cả game mobile với hơn 4 triệu bản sách đã bán ra! Phiên bản manga chuyển thể đã được mua bản quyền và sẽ phát hành trong thời gian tới!', 
102000, 20, '13x19 cm', 1, 2, 2, 0, 2),

-- 3
('Dược Sư Tự Sự - Tập 1', 2022, 408, 
'Miêu Miêu là một cô gái làm công việc hầu hạ trong cung đình thời phong kiến.\n\nCâu chuyện của chúng ta bắt đầu với việc cô gái từng hành nghề dược sư ở phố hoa này nghe thấy người ta đồn thổi rằng: tất cả những đứa con của Hoàng đế đều đoản mệnh.\n\nPhiên bản tiếng Việt rất được mong đợi của tác phẩm trinh thám cổ trang đã được công chúng đón nhận nồng nhiệt. Giữa bối cảnh phương Đông thời phong kiến, cô gái làm nhiệm vụ “thử độc” liên tiếp phá giải những vụ án hóc búa xảy ra ở chốn cung đình.\n\n* DƯỢC SƯ TỰ SỰ là series light-novel thể loại trinh thám vô cùng độc đáo lấy bối cảnh cung đình. Là một trong những bộ light-novel đình đám nhất trong những năm gần đây, series đã vượt mốc 13 triệu bản tại thị trường Nhật Bản và luôn thống trị bảng xếp hạng bán chạy mỗi khi ra tập mới!\n\nSố tập: 11 (on-going)\n\n---\n\nMột ấn phẩm của WINGS BOOKS - Thương hiệu sách trẻ của NXB Kim Đồng.', 
88000, 5, '19 x 13 x 2 cm', 1, 3, 2, 2, 3),

-- 4
('Mùa Hè Thứ Hai, Mất Em Mãi Mãi', 2023, 500, 
'Mùa Hè Thứ Hai, Mất Em Mãi Mãi\n\nSatoshi mê nhạc của ban nhạc nọ, nên đăng kí vào trường cấp ba idol từng theo học. Không ngờ chính tại idol này mà nhà trường cấm ngặt không cho học sinh hoạt động âm nhạc gì nữa, nếu trường có sự kiện cần văn nghệ, ban giám hiệu sẽ thuê ban văn nghệ ở bên ngoài về.\n\nBởi thế, Satoshi phải chơi nhạc âm thầm, không để trường phát hiện. Tình cờ năm lớp 12, cậu gặp Rin, một người vừa chuyển trường đến cũng vì mê ban nhạc nọ. Nhưng khác với cậu, cô quyết yêu cầu nhà trường cho thành lập ban nhạc. Cùng với các thành viên khác, họ đã biểu diễn ở lễ hội trường và tỏa sáng rực rỡ, đồng thời một cảm xúc rung động tuổi hoa cũng kín đáo nảy nở giữa hai người.\n\nTuy nhiên sau buổi diễn, Rin phải nhập viện. Trong phút lo lắng xúc động, Satoshi đã tỏ tình và nhận về phản ứng khá gay gắt.\n\nHối hận và chán nản, vài tháng sau ở nơi hai người gặp nhau lần đầu, Satoshi bất ngờ quay lại quá khứ. Để bù đắp tiếc nuối, giữ gìn quan hệ bạn bè dịu êm, Satoshi quyết định lần này sẽ giấu kín tình cảm, không tỏ bày gì khi tái ngộ nữa.\n\nTuy nhiên định mệnh, và những cảm xúc nồng nhiệt lớn dần theo tháng ngày vẫn có cách để những trái tim thanh xuân tìm đến nhau gắn bó.', 
69300, 12, null, 1, 5, 15, 0, 4),

-- 5
('Harry Potter and the Sorcerers Stone', 1998, 309, 
'Harry Potter has no idea how famous he is. Thats because hes being raised by his miserable aunt and uncle who are terrified Harry will learn that hes really a wizard, just as his parents were. But everything changes when Harry is summoned to attend an infamous school for wizards, and he begins to discover some clues about his illustrious birthright. From the surprising way he is greeted by a lovable giant, to the unique curriculum and colorful faculty at his unusual school, Harry finds himself drawn deep inside a mystical world he never knew existed and closer to his own noble destiny.', 
120000, 8, '19.6 x 12.8 x 2.6 cm', 1, 16, 21, 2, 5),

-- 6
('The Lord of the Rings', 1995, 1137, 
'Sauron, the Dark Lord, has gathered to him the Rings of Power - the means by which he will be able to rule the world. All he lacks in his plan for dominion is the Ruling Ring, which has fallen into the hands of the Hobbit Bilbo Baggins.', 
530000, 15, '5.3 x 12.7 x 19.6 cm', 1, 18, 20, 0, 6),

-- 7
('Dragon Ball SD - 7 Viên Ngọc Rồng Nhí - Tập 2 - Khuynh Đảo Đại Hội Võ Thuật', 2024, 188, 
'Dragon Ball SD - 7 Viên Ngọc Rồng Nhí - Tập 2 - Khuynh Đảo Đại Hội Võ Thuật\n\nGoku và người bạn đồng môn đã tới tham dự Đại hội võ thuật Thiên Hạ Vô Địch. Trong trận chung kết, Goku phải đối đầu với một địch thủ cực mạnh là ông lão Jackie Chun!! Liệu măng non có đấu nổi với tre già? Hãy cùng đón xem trận chiến của họ sẽ được thể hiện như thế nào qua tác phẩm “DRAGON BALL SD” này nhé.', 
67500, 10, '19 x 13 x 0.9 cm', 4, 6, 2, 0, 7),

-- 8
('Demon Slayer: Kimetsu No Yaiba - Yellow', 2022, 40, 
'鬼滅の刃 塗絵帳 -黄- Demon Slayer: Kimetsu No Yaiba - Yellow\n\n■吾峠呼世晴の原作イラストを用いた塗絵を、36点収録。\n■原作イラストの雰囲気を忠実に再現しており、お子さまはもちろん、大人の方も十分に楽しめる、“塗りごたえのある”一冊に仕上げました。\n■竈門炭治郎、時透無一郎、甘露寺蜜璃がカバーを飾る「ー黄ー(き)」。\n刀鍛冶の里での熱戦のイラストを、主に収録しました。\n■見開きイラストの塗絵を3点収録。\n9ページ目以降は、ミシン目が入っており、切り取れる仕様になっています。\n■カバー裏は、塗絵となったカラーイラストがデザインされた「特製ポスター」仕様となっています。\n塗絵の色見本としてもお使いいただけます。\n■塗りやすいように、柔軟性(開きやすい)・耐久性(丈夫である)に優れた製本となっています', 
248400, 1, '25.7 x 18.2 x 0.6 cm', 4, 7, 16, 1, 8),

-- 9
('One Piece 48', 2007, 232, 
'Follow the tales of a young pirate and his crew looking for the greatest treasure in the world, the One Piece! Record shattering best selling comic in Japan, and more! Volume 48 In Japanese. Annotation copyright Tsai Fong Books, Inc. Distributed by Tsai Fong Books, Inc.', 
101600, 12, '17.6 x 11.4 x 2 cm', 4, 9, 16, 4, 1),


-- 10
('Detective Conan - Tập 1 - Tái Bản 2023', 2023, 184, 
'Thám Tử Lừng Danh Conan - Tập 1\n\nKudo Shinichi là một cậu thám tử học sinh năng nổ với biệt tài suy luận có thể sánh ngang với Sherlock Holmes! Một ngày nọ, khi mải đuổi theo những kẻ khả nghi, cậu đã bị chúng cho uống một loại thuốc kì lạ khiến cho cơ thể bị teo nhỏ. Vậy là một thám tử tí hon xuất hiện với cái tên giả: Edogawa Conan!!\n\nGosho Aoyama\n\nXin chào, tôi là Aoyama đây!!\n\nTừ nhỏ tôi đã rất thích truyện trinh thám. Một khi vào hiệu sách, cứ thoáng thấy chữ “Holmes” hay tên một thám tử nổi tiếng nào đó là hai tay tự động vồ lấy. Vậy nên tôi đã cố vắt óc suy nghĩ để cho ra đời tác phẩm này. Liệu bạn có thể phá được vụ án trước Conan không nhỉ…', 
23000, 32, '17.6 x 11.3 x 1 cm', 4, 1, 2, 0, 2),

-- 11
('Nai Tơ Ngơ Ngác Nokotan - Tập 1 - Tặng Kèm Bookmark', 2025, 128, 
'Nai Tơ Ngơ Ngác Nokotan - Tập 1\n\nMột buổi sáng nọ, học sinh gương mẫu Koshi Torako cảm thấy có gì đó bắn thẳng vào mặt mình. Khi ngẩng lên, cô phát hiện một sinh vật đang bị mắc sừng trên dây điện, không thể cử động được!?\n\nTorako đã ra tay cứu giúp cô gái nọ khỏi màn tấn công dữ dội của đám chim xanh. Nào ngờ đó chính là nhân tố khiến cuộc sống bình thường của cô đảo lộn 360 độ! Câu chuyện về gái (từng là dân anh chị) gặp nai (?) chính thức bắt đầu!!', 
27000, 123, '18 x 13 x 0.6 cm', 4, 33, 2, 0, 3),

-- 12
('Bộ Manga - Attack On Titan: Tập 1 - 3 (Bộ 3 Tập) - Tặng Kèm Card PVC + Card Shikishi', 2024, 600, 
'Bộ Manga - Attack On Titan: Tập 1 - 3 (Bộ 3 Tập)\n\nATTACK ON TITAN KHÔNG CHỈ ĐƠN THUẦN CHỈ LÀ MỘT BỘ TRUYỆN TRANH\n\nĐÂY CÒN LÀ MỘT KIỆT TÁC MANGA CỦA THỜI ĐẠI\n\nSỰ LÔI CUỐN CỦA NHỮNG CHUYẾN PHIÊU LƯU\n\nTÍNH HẤP DẪN TỪ NHỮNG TÌNH TIẾT BÍ ẨN\n\nNỖI BÀNG HOÀNG KHI TRẢI QUA NHỮNG BƯỚC CHUYỂN BẤT NGỜ\n\nNHỮNG CẢM XÚC DÂNG TRÀO\n\nNHỮNG Ý NGHĨA NHÂN VĂN\n\nTẤT CẢ NHỮNG ĐIỀU TRÊN KẾT HỢP HÀI HÒA TRONG ATTACK ON TITAN\n\nCâu chuyện của ATTACK ON TITAN xoay quanh nền văn minh bên trong ba bức tường đồ sộ, được cho là nơi duy nhất mà nhân loại còn tồn tại. Ba bức tường được dựng thành ba vòng tròn đồng tâm để bảo vệ nhân loại khỏi những tên khổng lồ ăn thịt người được gọi là Titan.\n\nEren Yeager, nhân vật chính của bộ truyện, người đã thề sẽ tiêu diệt toàn bộ Titan trên thế giới sau khi chứng kiến chúng phá hủy bức tường, tàn phá quê hương và làm hại người thân. Khi Eren bị một Titan ăn thịt trong lúc cố gắng cứu bạn thân là Armin, bằng một cách nào đó Eren đã biến thành Titan nhưng những tình tiết sau đó đã gây ngỡ ngàng cho tất cả.\n\nBạn đọc sẽ phải đặt nhiều câu hỏi, sẽ phải bàn luận rất nhiều khi dõi theo bộ truyện với hàng loạt những chi tiết bí ẩn, những khám phá bất ngờ, những biến cố chạm đến rung cảm... Câu chuyện còn ẩn chứa những tầng lớp ý nghĩa nào, thế giới trong ATTACK ON TITAN có phải chỉ giới hạn trong những bước tường, nhân vật chính Eren của chúng ta sẽ có vai trò gì trong cuộc chiến giữa loài người và Titan?\n\nTHÔNG TIN PHÁT HÀNH CỦA BỘ TRUYỆN\n\nATTACK ON TITAN được đăng tải dài kì trên tạp chí Bessatsu Shounen của Kodansha từ tháng 09 năm 2009 đến tháng 04 năm 2021 và được xuất bản thành 34 tập lẻ.\n\nPhiên bản anime chuyển thể được Wit Studio (mùa 1–3) và MAPPA (mùa 4) sản xuất. Tập cuối của anime ATTACK ON TITAN thật sự bùng nổ, đã gây ra hiệu ứng “Break Internet” hàng loạt trang web chiếu phim nhận vào lượng truy cập quá lớn chỉ trong một thời gian ngắn.\n\nATTACK ON TITAN rất thành công về mặt đánh giá chuyên môn cũng như hiệu quả thương mại. ATTACK ON TITAN đã được xuất bản bằng 18 ngôn ngữ và hơn 180 quốc gia trên thế giới. Tính đến tháng 11 năm 2023, lượng phát hành tích lũy của bộ truyện trên toàn thế giới đã vượt qua 140 triệu bản, giúp bộ truyện lọt vào top 10 những manga bán chạy nhất mọi thời đại.\n\nTruyện giành được nhiều giải thưởng có giá trị như Giải Manga Kodansha, Giải Attilio Micheluzzi và Giải Harvey…', 
130000, 45, '19 x 13 x 3.1 cm', 4, 29, 1, 12, 4),

-- 13
('Những Án Mạng Ở Phố Nhà Xác Rue', 2025, 128, 
'Những Án Mạng Ở Phố Nhà Xác Rue - Tuyển Tập Truyện Ngắn Kinh Dị Edgar Allan Poe\n\n“Những án mạng ở phố nhà xác Rue” là một kiệt tác kinh điển của Edgar Allan Poe - bậc thầy khắc họa những câu chuyện ám ảnh và giàu tính biểu tượng. Ông là một trong những tác giả tiên phong khi nhắc tới văn học trinh thám thế giới, trở thành nguồn cảm hứng cho các nhà văn sau này như Arthur Conan Doyle và Agatha Christie.\n\nCuốn sách bao gồm 5 truyện ngắn đặc sắc, dẫn dắt bạn khám phá thế giới nội u ám nhưng đầy sức hút, vừa diệu kỳ vừa quái đản. Ở đó có sự giằng xé giữa lương tâm và bản năng thú vật, có những câu chuyện tưởng như đơn giản nhưng lại ẩn chứa nhiều điều vượt ra khỏi khuôn mẫu cuộc sống: một dịch bệnh khủng khiếp tràn lan khắp thế giới với triệu chứng máu chảy từ lỗ chân lông, một tên sát nhân giết hàng xóm vì nghi ngờ ông luôn soi mói mình, một con đười ươi xổng chuồng chặt xác nạn nhân rồi ném qua cửa sổ…\n\n“Phía sau tòa nhà, họ tìm thấy xác của bà lão. Cổ của bà ấy gần như bị cắt đứt và khi họ cố gắng nâng bà lên, cái đầu đã rơi ra.” \n\nNhững câu chuyện trong “Những án mạng ở phố nhà xác Rue” không chỉ mang màu sắc kinh dị mà còn là tấm gương phản chiếu sự độc ác vặn xoắn trong tâm trí con người - nơi sâu thẳm đáng sợ hơn bất cứ thế lực siêu nhiên nào. Edgar Allan Poe đã khéo léo đẩy tâm lý căng thẳng, phức tạp lên đến đỉnh điểm thông qua mỗi trang viết. Đen đặc, đẫm máu nhưng cực kỳ thu hút. \n\nHãy cùng bước vào thế giới ma mị, siêu thực của Edgar Allan Poe để tìm ra những nỗi sợ dị thường tiềm ẩn bên trong bạn.', 
60000, 123, '19 x 12 x 0.6 cm', 2, 10, 10, 0, 5),

-- 14
('50 Đề Thực Chiến Luyện Thi Tiếng Anh Vào Lớp 10 (Có Đáp Án)', 2025, 264, 
'50 Đề Thực Chiến Luyện Thi Tiếng Anh Vào Lớp 10 (Có Đáp Án)\n\nKỳ thi vào lớp 10 luôn là một cột mốc quan trọng trong hành trình học tập của mỗi học sinh. Đây không chỉ là thử thách về kiến thức, mà còn là cơ hội để các em khẳng định bản thân, mở ra cánh cửa bước vào môi trường học tập mới. Trong số các môn thi, Tiếng Anh luôn là một môn học "được lòng" học sinh nhưng cũng đầy thử thách, đòi hỏi sự đầu tư nghiêm túc và chiến lược học tập hiệu quả.\n\nCuốn sách 50 ĐỂ THỰC CHIẾN LUYỆN THI TIẾNG ANH VÀO LỚP 10 ra đời với mong muốn trở thành người bạn đồng hành đáng tin cậy của các em học sinh trong quá trình ôn luyện môn tiếng Anh. Được biên soạn theo cấu trúc và nội dung của đề thi minh họa mới nhất, cuốn sách này sẽ cung cấp cho các em 50 đề thi sát với kỳ thi thực tế vào lớp 10, từ đó giúp các em làm quen với các dạng bài, nâng cao khả năng phân tích và giải quyết vấn đề một cách nhanh chóng, chính xác.\n\nHy vọng rằng cuốn sách này sẽ là người bạn đồng hành đáng tin cậy, giúp các em chuẩn bị tốt nhất cho kỳ thi vào lớp 10 môn Tiếng Anh. Chúc các em sẽ đạt được kết quả cao và mở ra một chương mới đầy hứa hẹn trong hành trình học tập của mình!', 
112000, 2, '27 x 19 x 1.3 cm', 3, 11, 12, 2, 6),

-- 15
('Chinh Phục Luyện Thi Vào 10 Môn Tiếng Anh Theo Chủ Đề', 2022, 224, 
'Chinh phục luyện thi vào 10 môn Tiếng Anh theo chủ đề là cuốn sách trong bộ sách “Chinh phục luyện thi vào 10 theo chủ đề” được biên soạn bởi các tác giả uy tín và nhiều năm kinh nghiệm giảng dạy, luyện thi vào lớp 10. Cuốn sách được tổng hợp bài bản, cập nhật mới nhất các nội dung được đưa vào đề thi môn tiếng Anh những năm gần đây, chắc chắn sẽ giúp các em vững vàng kiến thức, tự tin đạt điểm cao trong kỳ thi sắp tới.\n\nChinh phục luyện thi vào 10 theo chủ đề: Hơn cả sự mong đợi về một bộ sách tổng hợp chuyên đề trọng tâm cho học sinh lớp 9.\n\nBộ sách Chinh phục luyện thi vào 10 theo chủ đề:\n\n- Đầy đủ và chi tiết nhất về các chuyên đề trọng tâm 100% có trong đề thi\n\n- Bổ sung lý thuyết, kiến thức căn bản một cách bài bản, dễ hiểu, dễ vận dụng\n\n- Lộ trình kiến thức khoa học từ cơ bản đến nâng cao\n\n- Đáp án, lời giải chi tiết, rõ ràng\n\n5 ƯU ĐIỂM NỔI BẬT CHỈ CÓ Ở CHINH PHỤC LUYỆN THI VÀO 10 MÔN TIẾNG ANH THEO CHỦ ĐỀ\n\n 1. Tổng hợp đầy đủ 16 chuyên đề trọng tâm trong chương trình thi\n\nCác chuyên đề 100% xuất hiện trong đề thi như Ngữ âm, Các thì của động từ, Câu tường thuật, Mệnh đề quan hệ, Câu điều kiện, So sánh…\n\n2. Diễn giải chi tiết, khoa học các kiến thức cần ghi nhớ mỗi chuyên đề\n\nMỗi chuyên đề đều được biên soạn đầy đủ, chi tiết Định nghĩa – Cấu trúc – Cách sử dụng – Các trường hợp đặc biệt – Ví dụ - Bài tập vận dụng…\n\n3. Trình bày khoa học, bài bản các vấn đề quan trọng nhất cần ghi nhớ\n\nSử dụng bảng biểu rõ ràng, sách in 2 màu và in đậm dễ nhìn, dễ học và ghi nhớ\n\n4. Trang bị kỹ năng và mẹo làm bài\n\nPhần lời giải chi tiết, đi kèm dịch nghĩa cụ thể, học sinh mọi năng lực có thể học hiểu dễ dàng. Các em có thể tự nhận xét được năng lực bản thân, thấy được lỗi sai cần tránh, kịp thời lấp đầy lỗ hổng kiến thức, tìm ra các phương pháp làm bài nhanh, từ đó nâng cao năng lực của bản thân\n\n5. Phù hợp với mọi đối tượng học sinh có học lực từ trung bình, khá đến giỏi\n\nCuốn sách Chinh phục luyện thi vào 10 môn Tiếng Anh theo chủ đề được biên tập khoa học, phù hợp với mọi đối tượng học sinh có học lực từ trung bình - khá đến giỏi. Kiến thức được biên soạn từ cơ bản đến nâng cao giúp học sinh có học lực trung bình củng cố vững chắc kiến thức nền tảng, vận dụng với các bài tập cơ bản; học sinh có học lực khá, giỏi nâng cao tư duy và kỹ năng giải đề với các bài tập vận dụng nâng cao\n\nVới những ƯU ĐIỂM trên, cuốn sách Chinh phục luyện thi vào 10 môn Tiếng Anh theo chủ đề chắc chắn sẽ là người bạn đồng hành, giúp các bạn học sinh lớp 9 chinh phục thành công kỳ thi vào lớp 10 sắp tới.', 
127000, 22, '29.5 x 20.5 x 1 cm', 3, 12, 19, 0, 7),

-- 16
('100 Đề Minh Họa Thi Vào 10 - Môn Toán', 2025, 360, 
'100 Đề Minh Họa Thi Vào 10 - Môn Toán\n\nCuốn sách được nhóm tác giả biên soạn dựa trên cấu trúc ĐỀ MINH HOẠ KỲ THI TUYỂN SINH LỚP 10 THPT THEO CHƯƠNG TRÌNH GDPT 2018 mà các SỞ GIÁO DỤC VÀ ĐÀO TẠO trên cả nước công bố.\n\nCuốn sách gồm 4 phần với nội dung như sau:\n\n- Phần I: 45 đề cấu trúc trắc nghiệm và tự luận.\n\n- Phần II: 45 đề cấu trúc tự luận.\n\n- Phần III: 10 đề cấu trúc trắc nghiệm.\n\n- Phần IV: Tổng hợp đề thi thử của các Trường, Sở Giáo Dục trên cả nước.', 
139000, 45, '27 x 19 x 1.8 cm', 3, 13, 9, 0, 8),

-- 17
('200 Miếng Bóc Dán Thông Minh - Bé Học Toán', 2018, 30, 
'Đây là cuốn sách được tuyển chọn và những trò chơi dán hình, giúp cho đôi tay của các em thêm linh hoạt, khéo léo, nhận biết được các hình để bóc và dán cho đúng chỗ...', 
38000, 33, '26 x 26 cm', 7, 14, 10, 0, 1),

-- 18
('Big Book - Cuốn Sách Khổng Lồ Về Các Loài Động Vật Biển (Tái Bản)', 2018, 32, 
'Big Book - Cuốn Sách Khổng Lồ Về Các Loài Động Vật Biển (Tái Bản)\n\nBộ sách có kích thước khổng lồ sẽ mở ra một thế giới đại dương rộng lớn trước mắt bé. Những loài động vật dưới biển to lón như cá voi, thân thiện như cá heo, nho nhỏ như ốc, cua, cá hề,… đều xuất hiện trong cùng 1 trang sách. Các bé có thể thỏa sức khám phá trọn vẹn một gia đình động vật dưới biển mà không bị giới hạn bởi kích thước của trang sách!', 
126000, 126, '24.5 x 29.5 cm', 7, 15, 10, 1, 2),

-- 19
('Sách Chuyển Động Thông Minh Đa Ngữ Việt - Anh - Pháp: Động Vật Nuôi - Domestic Animals - Les Animaux De Compagnie', 2022, 10, 
'Xuất bản lần đầu tại Pháp với tên gọi Kididoc do NXB Nathan (NXB sách thiếu nhi hàng đầu của Pháp) phát hành, bộ sách chuyển động thông minh đã nhanh chóng được phổ biến tại 22 quốc gia khắp thế giới và trở thành một trong những bộ sách bestseller dành cho trẻ trong độ tuổi 0-6.\n\nĐúng như tên gọi lạ lẫm của mình, bộ sách chuyển động gồm những trang sách có thể tái hiện những chuyển động như hình ảnh quả trứng tách vỏ, cầu thủ đá bóng, chiếc máy xúc nâng lên, hạ xuống, cá voi phun nước hay hình em bé chơi đua ngựa,…\n\nCác hình ảnh chuyển động này không chỉ giúp bé ghi nhớ từ nhanh chóng, phát triển tư duy logic về vận động của các sự vật mà còn giúp bé luyện các hoạt động bằng tay khi tự mình điều khiển các khuôn hình.', 
83000, 48, '17 x 17 cm', 7, 17, 10, 0, 3),

-- 20
('Giáo Dục Đầu Đời Cho Trẻ - Những Bài Học Tự Bảo Vệ Bản Thân - Không Được Chạm Vào Vùng Riêng Tư Của Tớ', 2023, 48, 
'Giáo Dục Đầu Đời Cho Trẻ - Những Bài Học Tự Bảo Vệ Bản Thân - Không Được Chạm Vào Vùng Riêng Tư Của Tớ\n\nTrong xã hội ngày nay, việc trang bị cho trẻ em những kiến thức an toàn để tự bảo vệ bản thân là điều hết sức cần thiết. Thấu hiểu điều này, bộ sách Giáo dục đầu đời cho trẻ - Những bài học tự bảo vệ bản thân đã ra đời nhằm giúp các em nhận thức rõ về cơ thể mình, bồi dưỡng những quan niệm đúng đắn về giới tính, đồng thời nắm được những nguy cơ tiềm tàng trong cuộc sống, tránh xa mọi hiểm nguy.\n\nVới nội dung được lồng ghép tinh tế kèm tranh minh họa sinh động, chắc chắn các em sẽ tiếp thu những điều bổ ích trong sách rất nhanh và dễ dàng áp dụng vào cuộc sống đấy! Hãy mở sách và khám phá nhé!', 
27000, 14, '20.5 x 18.5 x 0.4 cm', 7, 19, 10, 0, 4),

-- 21
('Gieo Mầm Tính Cách - Tự Tin (Tái Bản 2019)', 2019, 84, 
'Tính cách của trẻ được hình thành từ rất sớm, thông qua sự giáo dục trong gia đình, qua những việc làm, lời nói, cách ứng xử của những người xung quanh. Nhưng ở độ tuổi nhỏ, không thể ép trẻ phát triển tính cách theo ý muốn của cha mẹ bằng lời dạy dỗ suông, bằng những bài học đạo đức khô khan, mà những tấm gương đẹp về tính cách đó phải được gieo vào trẻ từ từ bằng những câu chuyện sinh động, hấp dẫn.\n\nBộ sách Gieo mầm tính cách (12 tập) là tập hợp những câu chuyện như vậy. Mỗi tập là một hạt giống tính cách gieo vào trẻ những bài học Tử tế, Tha thứ, Kiên trì, Thật thà, Quan tâm, Yêu thương, Mạnh mẽ, Tự tin, Ước mơ, Lịch sự, Hiếu thảo, Công bằng bằng những câu chuyện cảm động, đầy ý nghĩa đáng để suy ngẫm.\n\nMỗi câu chuyện được trình bày kèm với một câu tục ngữ, thành ngữ, ca dao, danh ngôn nhằm nhấn mạnh thêm thông điệp mà người tuyển chọn muốn gửi gắm. Không chỉ vậy, những bài học sau mỗi câu chuyện được xây dựng gần gũi, nhiều gợi mở cho người đọc triển khai thêm nhiều suy nghĩ sau khi đọc truyện, so sánh, áp dụng thực tế và tự xét bản thân.\n\nTruyện được minh họa hai màu sinh động.', 
29000, 7, '14 x 18.5 cm', 7, 21, 1, 0, 5),

-- 22
('Cô Bạn Tôi Thầm Thích Lại Quên Mang Kính Rồi - Tập 12 - Bản Đặc Biệt', 2025, 210, 
'Cô Bạn Tôi Thầm Thích Lại Quên Mang Kính Rồi - Tập 12\n\nThời gian thấm thoắt trôi qua. Chẳng mấy chốc đã đến lễ tốt nghiệp.\n\nDù con đường họ chọn có khác nhau, nhưng câu chuyện bắt đầu từ cặp bạn ngồi cạnh trong lớp sẽ còn tiếp diễn.', 
68000, 29, '18 x 13 x 1 cm', 4, 26, 2, 5, 6),

-- 23
('Sĩ Số Lớp Vắng 0', 2023, 264, 
'Sĩ Số Lớp Vắng 0\n\n“Tiếng gọi bí ẩn trong căn phòng đó dường như chỉ có mình tôi nghe thấy.”\n\n“Lớp học này từng có người c.h.ế.t.”\n\n“Người ta đồn rằng, vào buổi tối, trường này có ma.”\n\nSau khi bóng đêm nuốt trọn ngôi trường, những điều quỷ dị đã xảy ra…Nơi chiếc bàn học cuối lớp thỉnh thoảng lại vang lên tiếng gọi, chẳng nghe rõ tiếng nhưng như một loại thuốc mê khiến con người ta không thể điều khiển nổi tâm trí mà đi theo… một thứ quỷ dị đanglen lỏi trong từng ngóc ngách của lớp học này.\n\n“SĨ SỐ LỚP VẮNG 0” là cuốn sách được chắp bút bởi EMMA HẠ MY - chủ sở hữu kênh Youtube “Truyện của Emma” đăng tải những câu chuyện kinh dị tự sáng tác bằng hình ảnh hoạt họa do chính tác giả thực hiện. Cuốn sách bao gồm “Vệt Phấn Trên Bảng Đen” và 9 truyện ngắn khác CHƯA TỪNG xuất hiện trên kênh của Emma Hạ My.\n\nTrải qua 10 câu chuyện, cuốn sách sẽ đưa bạn bước vào một thế giới đầy ám ảnh rùng mình khi nhắc đến như: hồn ma của nữ sinh bị g….iết và hã…m hi…ếp rồi ngụy tạo thành tr.eo c.ổ t..ự t..ử; nam sinh đang tr.eo c.ổ lắc lư trên thanh xà ngang học thể dục dựng ở giữa sân trường; là hồn ma của một nữ sinh, thường lang thang khắp nơi trong trường để dọa dẫm học sinh…\n\nTưởng chừng những sự việc hãi hùng kia dường như chỉ là cơn á.c m.ộng mà họ trải qua trong một đêm say giấc nồng. Nhưng rồi hiện thực phải đối diện tát cho họ một cú đau điếng. Những gì xảy ra đêm qua đều có thật.', 
77000, 23, '20.5 x 13 x 1.3 cm', 2, 4, 9, 0, 7),

-- 24
('Tam Thể 1 (Tái Bản 2021)', 2021, 365, 
'Uông Diểu, vị giáo sư về vật liệu nano ngày nào cũng đăng nhập vào “Tam Thể”. Tại trò chơi online đó, anh đắm chìm trong một thế giới khác, nơi một nền văn minh có thể chỉ kéo dài vài ngày, bầu trời có thể xuất hiện ba mặt trời cùng lúc và con người còn phải biến thành xác khô để sinh tồn.\n\nNhưng anh không thể ngờ, thế giới khắc nghiệt trong Tam Thể là có thực, chỉ cách trái đất chừng bốn năm ánh sáng, và trò chơi ảo kia lại là một cánh cửa để những sinh vật của thế giới ấy bước đến xâm chiếm địa cầu này. Kinh hoàng, Uông Diểu tìm mọi cách ngăn chặn điều đó. Nhưng anh, cũng như cả địa cầu, không biết rằng, cánh cửa nọ đã được mở toang, từ mấy chục năm về trước...\n\nHùng tráng, kịch tính, triết lý, nên thơ, với những tri thức khoa học thú vị, Tam thể là phần mở đầu mang cảm hứng sử thi cho tam bộ khúc của Lưu Từ Hân. Sau tất cả những mưu toan ly kỳ, nham hiểm, những nỗ lực tưởng chừng tuyệt vọng để sinh tồn, câu hỏi còn đọng lại, không phải "Loài người nên làm gì để đối phó với sự xâm lăng của Tam Thể?", mà là "Loài người đã làm gì chính mình?"', 
12000, 71, '24 x 15 cm', 2, 8, 12, 0, 8),

-- 25
('Fantastic Four issue 1', 1961, 32, 
'Meet Marvels First Family: Mr. Fantastic, the Invisible Girl, the Human Torch, and The Thing. \nIn this first issue, the FF must confront the menace known as the Mole Man and his giant underground monsters, \nas they attack atomic plants all over the world', 
250000, 153, '16.8 x 26 cm', 5, 32, 17, 0, 1),

-- 26
('Invincible issue 1', 2003, 32, 
'Four months into the future, Invincible flies a man with a bomb strapped to his chest to Antarctica. The bomb explodes, sending Invincible crashing into the icy ground. After recovering, he sighs and flies away.\nIn the present, Deborah Grayson is trying to convince her son Mark to get out of the bathroom so he wont be late for school.\nMark finishes reading his Science Dog comic book in there and walks into the kitchen to get breakfast. His mom turns on the TV,\nwhere they see the superhero known as Omni-Man fighting a dragon in Taiwan. Mark casually comments how Omni-Man is his dad.\nLater that day, Mark has to reject his friend Williams invitation to hang out, as he has work. At work, while attempting to toss a trash bag into the dumpster, \nMark accidentally sends it flying through the sky, indicating that he has finally developed his powers.\nBack at his house that night, Marks dad Nolan arrives late to dinner due to a flood in Egypt he had to deal with. He mentions how the Guardians of the Globe, \nthe worlds premiere superhero team, should cover for him sometimes. Mark mentions how hes gotten superpowers.\nTwo weeks later, Mark, in a homemade costume, stops a supervillain with rock-hard skin from stealing jewels. \nNolan arrives and takes Mark to his friend Arts Tailor Shoppe, where he secretly makes superhero costumes. After Mark rejects an orange and yellow costume, Nolan leaves to deal with another supervillain.\nArt tells Mark that itd be easier to design a costume for him once he picks out a name. After a class the next day, the teacher tells a student to stay behind. As Mark leaves, he sees his locker neighbor being bullied.\nMark uses minimal strength to take down the bully, but is sent to the principals office. Principal Winslow commends Mark for sticking up to a bully, but warns him that he isnt invincible. Later, \nMark debuts in his new Invincible uniform, and attempts to stop some thieves. When they try to shoot him, he tells them that hes "Invincible".', 
330000, 37, '16.8 x 25.9 cm', 5, 28, 13, 2, 2),

-- 27
('Batman: Under the Red Hood', 2006, 384, 
'Batman is confronted with a hidden face from the past its the return of the vigilante Red Hood who appears to be Batman&;s one-time partner Jason Todd, \nthe same Jason Todd that died many years ago. But the Red Hoods violent ways pit him against the Dark Knight in his hunt for the very person responsible for his death: The Joker.', 
575000, 69, '16.8 x 25.9 cm', 5, 30, 18, 0, 3),

-- 28
('Amazing Fantasy #15', 2003, 245, 
'The First Appearance of the Amazing Spider-Man! When young Peter Parker gains remarkable abilities from a radioactive spider, \nhe must step up and try to become a hero — while also dealing with the fantastic pressures of an everyday teenager! For with great power, there must also come great responsibility!', 
780000, 20, '24.13 × 17.78 × 1.78 cm', 5, 31, 17, 0, 4),

-- 29
('Sau Khi Tôi Chết, Anh Ấy Không Cưới Thêm Ai Nữa', 2024, 204, 
'Sau Khi Tôi Chết, Anh Ấy Không Cưới Thêm Ai Nữa\nSinh mệnh giống như chiếc đồng hồ cát được ấn nút tạm dừng, cuối cùng anh cũng đã thấy được khuôn mặt người mình yêu thương cả đời. Cô vẫn dừng chân ở tuổi ba mươi, cô tựa vào lòng anh khóc lóc nũng nịu:\n"Nguyễn Chính Ý, em vẫn luôn ở bên anh, chưa có giây phút nào rời xa,\nđồ ngốc, tại sao anh không chịu tái hôn, em hy vọng anh tái hôn, hy vọng anh có con cháu đầy đàn, hy vọng anh một đời bình an, sao anh lại ngốc như vậy?"\nBàn tay bị cắm kim truyền đưa lên vuốt tóc cô. "Tô Uyển Uyển, cuộc đời này có em, anh không còn gì hối tiếc. Dù không được bên nhau dài lâu, nhưng hồi ức giữa chúng ta đã đủ để anh sống hết đời này."', 
76000, 92, '20.5 x 14.5 x 1 cm', 6, 23, 17, 0, 5),

-- 30
('Sự Dịu Dàng Khó Cưỡng (Tái Bản 2019)', 2019, 304, 
'Sinh nhật lần thứ 14, Quan Tiểu Úc gặp tình yêu sét đánh tại Bule Pub. Anh chàng lạ mắt trông cao quý và hấp dẫn đã thu hút ánh nhìn và trái tim cô bé mới lớn. Rồi khi nhìn chàng trai xa lạ kia khoác vai người đẹp rời đi, \n“mối tình đầu thơ ngây” của cô bỗng tan thành mây khói.\nNăm cô 22 tuổi, bố mẹ cô sắp xếp một cuộc gặp mặt với Âu Dương Y Phàm, anh chàng nổi tiếng đẹp trai, giỏi giang, con nhà gia, hai nhà đã có hẹn ước với nhau từ nhỏ. Nhưng vì nghe nói anh ta là một “hoa hoa công tử”, \nthay người yêu còn nhanh hơn cả thay áo, Quan Tiểu Úc chưa kịp gặp mặt đã lén trốn đi mất. Cô rất ghét loại người như anh ta.\nRời khỏi quán trà, cô vô tình đụng phải Ivan, anh chàng đẹp trai cô tình cờ gặp trong bữa tiệc sinh nhật một người bạn. Và trong lúc “nguy cấp”, cô đã lên xe anh ta để chạy trốn khỏi cuộc gặp không mong muốn. Tiếp xúc nhiều với Ivan, \ncô mới hiểu đằng sau khuôn mặt bất cần đời, luôn ung dung, tươi cười kia là một người hết lòng vì bạn bè, một con người quyết đoán trong công việc đầy áp lực và hơn hết là một trái tim si tình trong tình yêu. \nDần dần cô có cảm tình rồi rung động trước Ivan, quyết định cho anh cơ hội để có thể trở thành bạn trai của cô. Nhưng định mệnh thật trớ trêu khi đến sinh nhật lần thứ 23, Tiểu Úc phát hiện tên hoa hoa công tử Âu Dương Y Phàm và Ivan hóa ra chỉ là một người…', 
56000, 1, '20.5 x 14.5 x 1.5 cm', 6, 27, 14, 3, 6),

-- 31
('Cô Gái Năm Ấy Chúng Ta Cùng Theo Đuổi (Tái Bản 2019)', 2019, 310, 
'Rất nhiều cậu trai để ý Thẩm Giai Nghi.\nTạ Minh Hòa hiểu biết, có thể nói với cô từ chuyện xe hơi sang chuyện máy tính, rồi lại sang chuyện phong tục tập quán.\nTạ Mạnh Học học giỏi, hay làm thơ vớ vẩn tặng Giai Nghi.\nLiêu Anh Hoằng vui vẻ, giỏi kể chuyện cười.\nTrương Gia Huấn tính tình quai quái, rất hay điện thoại đến cà kê dê ngỗng với cô.\nKha Cảnh Đằng sôi nổi nghịch ngợm, luôn làm Giai Nghi bất ngờ.\nBắt đầu cuộc chạy đua âm thầm có, công khai có, để giành được thiện cảm của cô bạn xinh xắn học giỏi nhất trường.\nDù ai thắng, ai thua, ai thành công, ai thất bại, ai bỏ cuộc, ai ù nhầm, thì cô bé Thẩm Giai Nghi cũng đã trở thành hiện thân đẹp đẽ nhất của một thời niên thiếu trẻ trung sôi nổi trong họ.\nNên, "hãy cứ để mình tiếp tục thích cậu."', 
77000, 138, '14 x 20.5 cm', 6, 22, 5, 0, 7),

-- 32
('Lạc Trì (Bộ 2 Tập) - Tái Bản', 2021, 832, 
'Lạc Trì\nDiệp Khâm – cậu thiếu niên trong thời kỳ phản nghịch và nổi loạn khi biết cha mình ngoại tình làm tổn thương mẹ khiến cậu trở nên mẫn cảm hơn. Nhất là người cậu tưởng là con riêng của cha lại học cùng trường với cậu, \nmọi mặt đều giỏi hơn cậu như là mối đe doạ lớn cho gia đình ngưỡng tưởng hạnh phúc trong mắt người ngoài kia. Vậy nên, với sự bồng bột tuổi trẻ khiến cậu đồng ý với phương án đám bạn bày mưu tính kế cho mà chạy theo người con trai cậu ghét nhất, \nlà người đã phá hoại hạnh phúc gia đình cậu, đe doạ đến quyền thừa hưởng tài sản sau này của cậu,… Diệp Khâm dù không chịu thừa nhận nhưng chẳng biết tự lúc nào cậu chàng khờ dại này đã lỡ yêu chính người mà cậu ghét nhất – Trình Phi Trì.\nTrình Phi Trì – trầm ổn, ôn nhu là một học sinh giỏi toàn diện từ học thức đến thể thao. Anh mang trong mình một vết thương lòng được dấu kín kẽ trong trái tim chẳng ai có thể chạm tới. \nLà một cỗ máy luôn hoạt động hết công xuất với một ý nghĩ kiếm tiền mãnh liệt để cho mẹ một cuộc sống tốt hơn không cần trải qua những khổ cực mà cả 2 đã từng phải chịu lúc trước nữa. \nTrong tâm trí của anh chỉ có hai thứ học và làm việc kiếm tiền; cho đến một ngày bóng dáng nhỏ gầy xinh xắn cứ thể điềm nhiên bước vào cuộc sống của anh từ lúc nào không hay. \nNgưỡng tưởng cậu ta chỉ chơi đùa chốc lát rồi đi, anh sẵn sàng bồi chơi một chút vậy mà cậu cứ lỳ lợm ở đấy mãi, khuấy đảo cuộc sống của anh, gan lỳ không từ bỏ từng chút từng chút len lói vào trái tim anh; đó là Diệp Khâm.\nBắt đầu từ một hiểu lầm tai hại, cậu chàng Diệp Khâm stun và bốc đồng đã trăm phương ngàn kế kéo Trình Phi Trì và mình từ 2 đường thẳng song song không thể chạm tới vào thể giới của mình. Dù mục đích ban đầu là trò trả thù ấu trĩ ngu ngốc, \nnhưng Diệp Khâm chẳng thể ngờ rằng, bản thân lại vô tình chìm đắm trong sự dịu dàng của anh. Trình Phi Trì như ngọn nến sưởi ấm trái tim bị tổn thương vì gia đình rạn nứt của Diệp Khâm, còn Diệp Khâm cũng chính là vầng mặt trời nhỏ xua tan lạnh lẽo trong cuộc đời anh. \nNhưng rồi bởi nguồn căn hiểu lầm từ trước, cộng thêm sự vội vã ngông cuồng mà non nớt của tuổi trẻ, Diệp Khâm đã làm tổn thương sâu sắc Trình Phi Trì ngay trong lúc anh yếu đuối nhất. Mối tình đầu ngây ngô những tưởng sẽ kéo dài cả đời, giờ đây chỉ còn là giấc mộng vỡ tan.\nNăm năm sau, hoàn cảnh của hai người hoàn toàn đảo ngược, Diệp Khâm là nghệ sĩ nhỏ chẳng có tiếng tăm bị kẻ khác bắt nạt đủ đường, còn Trình Phi Trì đã trở thành một doanh nhân thành đạt được người người ngưỡng mộ. Tình cảm chôn sâu trong trái tim trước đây lại ùa về, \nsố phận dẫn dắt cả hai quay lại với nhau, một lần nữa chữa lành những tổn thương và giải tỏa hiểu lầm trước kia.\n"Nơi có anh sẽ là phương hướng của em.\nAnh ở đâu, em sẽ đặt chân đến đấy."', 
215000, 35, '24 x 16 cm', 6, 25, 15, 0, 8);

INSERT INTO ngdung (TenND, DcND, EmailND, GioiTinhND, SDT, NgSinhND)
VALUES
('Nguyễn Văn A', '123 Đường ABC, TP.HCM', 'nguyenvana@gmail.com', 1, '0901234567', '1995-05-20'),
('Trần Thị B', '456 Đường XYZ, Hà Nội', 'tranthib@gmail.com', 0, '0912345678', '1998-10-15'),
('Lê Hoàng C', '789 Đường DEF, Đà Nẵng', 'lehoangc@gmail.com', 1, '0923456789', '2000-03-08'),
('Phạm Thị D', '111 Đường GHI, Cần Thơ', 'phamthid@gmail.com', 0, '0934567890', '1992-07-22'),
('Hoàng Minh E', '222 Đường JKL, Hải Phòng', 'hoangminhe@gmail.com', 1, '0945678901', '1997-09-30'),
('Đỗ Thị F', '333 Đường MNO, Nha Trang', 'dothif@gmail.com', 0, '0956789012', '1993-12-05'),
('Vũ Quốc G', '444 Đường PQR, Huế', 'vuquocg@gmail.com', 1, '0967890123', '1999-06-18'),
('Ngô Thanh H', '555 Đường STU, Bình Dương', 'ngothanhh@gmail.com', 1, '0978901234', '2001-01-25'),
('Lý Hồng I', '666 Đường VWX, Vũng Tàu', 'lyhongi@gmail.com', 0, '0989012345', '1996-04-14'),
('Bùi Văn J', '777 Đường YZ, Đồng Nai', 'buivanj@gmail.com', 1, '0990123456', '1994-08-07');

INSERT INTO TaiKhoan (TenTK, LoaiTK, NgLap, TinhTrang, MKTK, MaND) VALUES
('user1', 0, '2025-03-21', 1, SHA2('pass1', 256), 1),	-- khách hàng
('user2', 2, '2025-03-21', 1, SHA2('pass2', 256), 2),	-- nhân viên
('user3', 0, '2025-03-21', 1, SHA2('pass3', 256), 3),
('user4', 3, '2025-03-21', 1, SHA2('pass4', 256), 4),	-- admin
('user5', 2, '2025-03-21', 1, SHA2('pass5', 256), 5),
('user6', 0, '2025-03-21', 1, SHA2('pass6', 256), 6),
('user7', 0, '2025-03-21', 1, SHA2('pass7', 256), 7),
('user8', 0, '2025-03-21', 1, SHA2('pass8', 256), 8),
('user9', 1, '2025-03-21', 1, SHA2('pass9', 256), 9),	-- quản lý
('user10', 4, '2025-03-21', 1, SHA2('pass10', 256), 10);	-- chủ doanh nghiệp

-- INSERT INTO QuanLy (MaTKQL, MaTKBQL) VALUES
-- (4, 1),
-- (4, 2),
-- (4, 3),
-- (4, 4),
-- (4, 5),
-- (4, 6),
-- (4, 7),
-- (4, 8),
-- (4, 9),
-- (10, 1),
-- (10, 2),
-- (10, 3),
-- (10, 4),
-- (10, 5),
-- (10, 6),
-- (10, 7),
-- (10, 8),
-- (10, 9);

INSERT INTO DanhGia (NoiDung, PhanHoi, NgayViet, MaKH, MaAdmin, MaSach) VALUES
('Sách rất hay, nội dung hấp dẫn!', 'Cảm ơn bạn đã ủng hộ, chúc bạn đọc sách vui vẻ!', '2025-03-20 14:30:00', 1, 4, 5),
('Chất lượng giấy in tốt, giao hàng nhanh.', 'Cảm ơn phản hồi của bạn, mong bạn tiếp tục ủng hộ!', '2025-03-19 09:15:00', 2, 10, 10),
('Cốt truyện lôi cuốn, đáng để đọc.', null, '2025-03-18 16:45:00', 3, null, 2),
('Hình ảnh minh họa đẹp, bé nhà mình rất thích.', null, '2025-03-17 20:10:00', 4, null, 17),
('Sách hơi nhàu khi giao nhưng nội dung rất hay.', 'Xin lỗi về vấn đề giao hàng, chúng tôi sẽ cải thiện dịch vụ tốt hơn!', '2025-03-16 12:00:00', 5, 4, 24);

INSERT INTO PhNhap (MaNCC, MaTK, NgNhap, TongTien) VALUES
(1, 2, CURDATE(), 31131520),
(2, 2, CURDATE(), 22153600),
(3, 2, CURDATE(), 33317200),
(4, 5, CURDATE(), 16953720),
(5, 5, CURDATE(), 11042500),
(6, 5, CURDATE(), 7653800),
(7, 10, CURDATE(), 11106200),
(8, 2, CURDATE(), 10590160);

INSERT INTO CTPN (SoLgNhap, GiaNhap, MaSach, MaPhNhap) VALUES
(44, 53200, 1, 1),
(20, 71400, 2, 2),
(7, 61600, 3, 3),
(12, 48510, 4, 4),
(10, 84000, 5, 5),
(15, 371000, 6, 6),
(10, 47250, 7, 7),
(2, 173880, 8, 8),
(16, 71120, 9, 1),
(32, 16100, 10, 2),
(123, 18900, 11, 3),
(57, 91000, 12, 4),
(123, 42000, 13, 5),
(4, 78400, 14, 6),
(22, 88900, 15, 7),
(45, 97300, 16, 8),
(33, 26600, 17, 1),
(127, 88200, 18, 2),
(48, 58100, 19, 3),
(14, 18900, 20, 4),
(7, 20300, 21, 5),
(34, 47600, 22, 6),
(23, 53900, 23, 7),
(71, 8400, 24, 8),
(153, 175000, 25, 1),
(39, 231000, 26, 2),
(69, 402500, 27, 3),
(20, 546000, 28, 4),
(92, 53200, 29, 5),
(4, 39200, 30, 6),
(138, 53900, 31, 7),
(35, 150500, 32, 8);

INSERT INTO HoaDon (MaNV, MaKH, NgLap, TrangThaiDH, GhiChu, DiaChiGiaoHang, PhThucTT, PhThucVC, SDT, TongTien) VALUES
(2, 1, '2025-03-21', 1, 'Giao hàng nhanh', '123 Nguyễn Văn Cừ, Quận 5, TP.HCM', 1, 1, 0123456789, 240000),   
(5, 3, '2025-03-21', 2, NULL, '45 Lê Lợi, Quận 1, TP.HCM', 1, 1, 0123456789, 248400),   
(2, 6, '2025-03-21', 1, 'Kiểm tra hàng trước khi nhận', '98 Đinh Tiên Hoàng, Q.Bình Thạnh', 2, 1, 0123456789, 390000),   
(5, 7, '2025-03-21', 3, 'Giao buổi chiều', '789 Trần Phú, Quận 7', 2, 1, 0123456789, 176000),   
(10, 8, '2025-03-21', 1, NULL, '159 Pasteur, Quận 3', 1, 1, 0123456789, 466400),   
(10, 1, '2025-03-21', 2, 'Ưu tiên giao sáng', '88 Lý Tự Trọng, Quận 1', 2, 1, 0123456789, 224000),  
(2, 3, '2025-03-21', 3, NULL, '67 Bạch Đằng, Quận Tân Bình', 1, 1, 0123456789, 126000),  
(5, 6, '2025-03-21', 1, 'Chuyển khoản trước', '23 Võ Văn Tần, Quận 10', 1, 1, 0123456789, 340000),   
(5, 7, '2025-03-21', 1, 'Giao trong tuần', '56 Nguyễn Trãi, Quận 5', 2, 1, 0123456789, 660000),   
(10, 8, '2025-03-21', 2, NULL, '12 An Dương Vương, Quận 6', 1, 1, 0123456789, 168000);

INSERT INTO CTHD (SoLg, MaHD, MaSach) VALUES
( 2, 1, 5),
( 1, 2, 8),
( 3, 3, 12),
( 2, 4, 3),
( 4, 5, 9),
( 2, 6, 14),
( 1, 7, 18),
( 5, 8, 22),
( 2, 9, 26),
( 3, 10, 30);

INSERT INTO ctgh (MaSach, MaGH, SoLg) VALUES
(1, 1, 2),  
(3, 2, 1),  
(5, 3, 3),  
(7, 4, 1),  
(10, 5, 2),  
(12, 6, 1), 
(15, 7, 4), 
(20, 8, 2),  
(25, 9, 1), 
(30, 10, 2);

insert into HinhAnh (DgDanAnh, MaND, MaSach)
values ('/project-Web2/common/images/Tiểu thuyết/Thiên Sứ Nhà Bên - Tập 1/1.jpg', NULL, 1),
	   ('/project-Web2/common/images/Tiểu thuyết/Thiên Sứ Nhà Bên - Tập 1/2.jpg', null, 1),
       ('/project-Web2/common/images/Tiểu thuyết/Chúa tể bóng tối - Tập 1/1.png', null, 2),
       ('/project-Web2/common/images/Tiểu thuyết/Dược Sư Tự Sự - Tập 1/1.jpg', null, 3),
       ('/project-Web2/common/images/Tiểu thuyết/Dược Sư Tự Sự - Tập 1/2.jpg', null, 3),
       ('/project-Web2/common/images/Tiểu thuyết/Mùa Hè Thứ Hai, Mất Em Mãi Mãi/1.jpg', null, 4),
       ('/project-Web2/common/images/Tiểu thuyết/Mùa Hè Thứ Hai, Mất Em Mãi Mãi/2.jpg', null, 4),
       ('/project-Web2/common/images/Tiểu thuyết/Mùa Hè Thứ Hai, Mất Em Mãi Mãi/3.jpg', null, 4),
       ('/project-Web2/common/images/Tiểu thuyết/Harry Potter  and the Sorcerers Stone/1.jpg', null, 5),
       ('/project-Web2/common/images/Tiểu thuyết/the Lords of the Ring/1.jpg', null, 6),
       ('/project-Web2/common/images/Tiểu thuyết/the Lords of the Ring/2.jpg', null, 6),
       ('/project-Web2/common/images/Tiểu thuyết/the Lords of the Ring/3.jpg', null, 6),
       ('/project-Web2/common/images/Manga/Dragon Ball SD - 7 Viên Ngọc Rồng Nhí - Tập 2 - Khuynh Đảo Đại Hội Võ Thuật/1.jpg', null, 7),
       ('/project-Web2/common/images/Manga/Dragon Ball SD - 7 Viên Ngọc Rồng Nhí - Tập 2 - Khuynh Đảo Đại Hội Võ Thuật/2.jpg', null, 7),
       ('/project-Web2/common/images/Manga/Demon Slayer Kimetsu No Yaiba - Yellow/1.jpg', null, 8),
       ('/project-Web2/common/images/Manga/Demon Slayer Kimetsu No Yaiba - Yellow/2.jpg', null, 8),
       ('/project-Web2/common/images/Manga/Demon Slayer Kimetsu No Yaiba - Yellow/3.jpg', null, 8),
       ('/project-Web2/common/images/Manga/One Piece 48/1.jpg', null, 9),
       ('/project-Web2/common/images/Manga/One Piece 48/2.jpg', null, 9),
       ('/project-Web2/common/images/Manga/One Piece 48/3.jpg', null, 9),
       ('/project-Web2/common/images/Manga/Detective Conan - Tập 1 - Tái Bản 2023/1.jpg', null, 10),
       ('/project-Web2/common/images/Manga/Detective Conan - Tập 1 - Tái Bản 2023/2.jpg', null, 10),
       ('/project-Web2/common/images/Manga/Detective Conan - Tập 1 - Tái Bản 2023/3.jpg', null, 10),
       ('/project-Web2/common/images/Manga/Nai Tơ Ngơ Ngác Nokotan - Tập 1 - Tặng Kèm Bookmark/1.jpg', null, 11),
       ('/project-Web2/common/images/Manga/Nai Tơ Ngơ Ngác Nokotan - Tập 1 - Tặng Kèm Bookmark/2.png', null, 11),
       ('/project-Web2/common/images/Manga/Bộ Manga - Attack On Titan Tập 1 - 3 (Bộ 3 Tập) - Tặng Kèm Card PVC + Card Shikishi/1.jpg', null, 12),
       ('/project-Web2/common/images/Manga/Bộ Manga - Attack On Titan Tập 1 - 3 (Bộ 3 Tập) - Tặng Kèm Card PVC + Card Shikishi/2.jpg', null, 12),
       ('/project-Web2/common/images/Manga/Bộ Manga - Attack On Titan Tập 1 - 3 (Bộ 3 Tập) - Tặng Kèm Card PVC + Card Shikishi/3.jpg', null, 12),
       ('/project-Web2/common/images/Manga/Bộ Manga - Attack On Titan Tập 1 - 3 (Bộ 3 Tập) - Tặng Kèm Card PVC + Card Shikishi/4.jpg', null, 12),
       ('/project-Web2/common/images/Kinh dị/Những Án Mạng Ở Phố Nhà Xác Rue/1.jpg', null, 13),
       ('/project-Web2/common/images/Kinh dị/Những Án Mạng Ở Phố Nhà Xác Rue/2.png', null, 13),
       ('/project-Web2/common/images/Giáo dục/50 Đề Thực Chiến Luyện Thi Tiếng Anh Vào Lớp 10 (Có Đáp Án)/1.jpg', null, 14),
       ('/project-Web2/common/images/Giáo dục/50 Đề Thực Chiến Luyện Thi Tiếng Anh Vào Lớp 10 (Có Đáp Án)/2.png', null, 14),
       ('/project-Web2/common/images/Giáo dục/chinh Phục Luyện Thi Vào 10 Môn Tiếng Anh Theo Chủ Đề/1.jpg', null, 15),
       ('/project-Web2/common/images/Giáo dục/chinh Phục Luyện Thi Vào 10 Môn Tiếng Anh Theo Chủ Đề/2.jpg', null, 15),
       ('/project-Web2/common/images/Giáo dục/chinh Phục Luyện Thi Vào 10 Môn Tiếng Anh Theo Chủ Đề/3.jpg', null, 15),
       ('/project-Web2/common/images/Giáo dục/100 Đề Minh Họa Thi Vào 10 - Môn Toán/1.jpg', null, 16),
       ('/project-Web2/common/images/Giáo dục/100 Đề Minh Họa Thi Vào 10 - Môn Toán/2.jpg', null, 16),
       ('/project-Web2/common/images/Giáo dục/100 Đề Minh Họa Thi Vào 10 - Môn Toán/3.jpg', null, 16),
       ('/project-Web2/common/images/Thiếu nhi/200 Miếng Bóc Dán Thông Minh - Bé Học Toán/1.jpg', null, 17),
       ('/project-Web2/common/images/Thiếu nhi/200 Miếng Bóc Dán Thông Minh - Bé Học Toán/2.jpg', null, 17),
       ('/project-Web2/common/images/Thiếu nhi/Big Book - Cuốn Sách Khổng Lồ Về Các Loài Động Vật Biển (Tái Bản)/1.jpg', null, 18),
       ('/project-Web2/common/images/Thiếu nhi/Big Book - Cuốn Sách Khổng Lồ Về Các Loài Động Vật Biển (Tái Bản)/2.jpg', null, 18),
       ('/project-Web2/common/images/Thiếu nhi/Big Book - Cuốn Sách Khổng Lồ Về Các Loài Động Vật Biển (Tái Bản)/3.jpg', null, 18),
       ('/project-Web2/common/images/Thiếu nhi/Sách Chuyển Động Thông Minh Đa Ngữ Việt - Anh - Pháp Động Vật Nuôi - Domestic Animals - Les Animaux De Compagnie/1.jpg', null, 19),
       ('/project-Web2/common/images/Thiếu nhi/Sách Chuyển Động Thông Minh Đa Ngữ Việt - Anh - Pháp Động Vật Nuôi - Domestic Animals - Les Animaux De Compagnie/2.jpg', null, 19),
       ('/project-Web2/common/images/Thiếu nhi/Sách Chuyển Động Thông Minh Đa Ngữ Việt - Anh - Pháp Động Vật Nuôi - Domestic Animals - Les Animaux De Compagnie/3.jpg', null, 19),
	   ('/project-Web2/common/images/Thiếu nhi/Giáo Dục Đầu Đời Cho Trẻ - Những Bài Học Tự Bảo Vệ Bản Thân - Không Được Chạm Vào Vùng Riêng Tư Của Tớ/1.jpg', null, 20),
       ('/project-Web2/common/images/Thiếu nhi/Gieo Mầm Tính Cách - Tự Tin (Tái Bản 2019)/1.jpg', null, 21),
       ('/project-Web2/common/images/Thiếu nhi/Gieo Mầm Tính Cách - Tự Tin (Tái Bản 2019)/2.jpg', null, 21),
       ('/project-Web2/common/images/Manga/Cô Bạn Tôi Thầm Thích Lại Quên Mang Kính Rồi - Tập 12 - Bản Đặc Biệt/1.jpg', null, 22),
       ('/project-Web2/common/images/Manga/Cô Bạn Tôi Thầm Thích Lại Quên Mang Kính Rồi - Tập 12 - Bản Đặc Biệt/2.jpg', null, 22),
       ('/project-Web2/common/images/Kinh dị/Sĩ Số Lớp Vắng 0/1.jpg', null, 23),
       ('/project-Web2/common/images/Kinh dị/Sĩ Số Lớp Vắng 0/2.jpeg', null, 23),
       ('/project-Web2/common/images/Kinh dị/Sĩ Số Lớp Vắng 0/3.jpg', null, 23),
       ('/project-Web2/common/images/Kinh dị/Tam Thể 1 (Tái Bản 2021)/1.jpg', null, 24),
       ('/project-Web2/common/images/Kinh dị/Tam Thể 1 (Tái Bản 2021)/2.jpg', null, 24),
       ('/project-Web2/common/images/Truyện tranh/Fantastic Four issue 1/1.webp', null, 25),
       ('/project-Web2/common/images/Truyện tranh/Invincible issue 1/1.webp', null, 26),
       ('/project-Web2/common/images/Truyện tranh/Batman Under the Red Hood/1.jpg', null, 27),
       ('/project-Web2/common/images/Truyện tranh/Amazing Fantasy #15/1.jpg', null, 28),
       ('/project-Web2/common/images/Truyện tranh/Amazing Fantasy #15/2.jpg', null, 28),
       ('/project-Web2/common/images/Lãng mạn/Sau Khi Tôi Chết, Anh Ấy Không Cưới Thêm Ai Nữa/1.jpg', null, 29),
       ('/project-Web2/common/images/Lãng mạn/Sự Dịu Dàng Khó Cưỡng (Tái Bản 2019)/1.jpg', null, 30),
       ('/project-Web2/common/images/Lãng mạn/Cô Gái Năm Ấy Chúng Ta Cùng Theo Đuổi (Tái Bản 2019)/1.jpg', null, 31),
       ('/project-Web2/common/images/Lãng mạn/Lạc Trì (Bộ 2 Tập) - Tái Bản/1.jpg', null, 32),
       ('/project-Web2/common/images/Lãng mạn/Lạc Trì (Bộ 2 Tập) - Tái Bản/2.jpg', null, 32),
       ('/project-Web2/common/images/Lãng mạn/Lạc Trì (Bộ 2 Tập) - Tái Bản/3.jpg', null, 32);
       
-- SET SQL_SAFE_UPDATES = 0;

-- UPDATE HinhAnh
-- SET DgDanAnh = '/project-Web2/common/images/defaultuser.png'
-- WHERE MaND IS NOT NULL;

-- SET SQL_SAFE_UPDATES = 1;
-- use webbookstore;
-- SELECT MaND FROM TaiKhoan ORDER BY MaTK DESC LIMIT 1;


-- INSERT INTO TaiKhoan (TenTK, LoaiTK, NgLap, TinhTrang, MKTK, MaND) 
-- VALUES ('test', 0, '2025-04-07', 1, 'hashedpassword', 12);

-- SELECT * FROM HinhAnh WHERE MaND = 12;
