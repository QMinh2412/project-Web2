create database webbookstore;
drop database webbookstore;
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
	`NamXB`date,
	`SoTrang` int,
	`MoTaChiTiet` varchar(1000),
	`GiaBan` long,
	`SoLgTon` long,
	`TinhTrang` int default 0,
	`KichThuoc` varchar(50),
    `MaLoai` int not null,
    `MaTG` int not null,
    `MaNXB` int not null
);

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
    `TinhTrang` int not null,
    `MKTK` varchar(255) not null,
    `MaND` int not null
);

create table `QuanLy`(
	`MaTKQL` int not null,
	`MaTKBQL` int not null
);

create table `DanhGia` (
	`MaDG` int primary key not null auto_increment,
	`PhanHoi` varchar(1000),
	`NoiDung` varchar(1000),
	`NgayViet` datetime,
    `MaKH` int not null,
    `MaAdmin` int not null,
    `MaSach` int not null
);

create table `HoaDon` (
	`MaHD` int primary key not null auto_increment,
    `MaNV` int not null,
    `MaKH` int not null
);

create table `CTHD` (
	`NgLap` date not null,
	`TrangThaiDH` int default 0,
	`SoLg` int not null,
	`GiaBan` long not null,
	`GhiChu` varchar(1000),
	`DiaChiGiaoHang` varchar(255) not null,
	`PhThucTT` int default 0,
    `MaHD` int not null,
    `MaSach` int not null
);

create table `PhNhap` (
	`MaPhNhap` int primary key not null auto_increment,
    `MaNCC` int not null,
    `MaTK` int not null
);

create table `CTPN` (
	`SoLgNhap` long not null,
	`GiaNhap` long not null,
	`NgNhap` date not null,
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
	`TinhTrang` int default 0,
	`SoLg` int not null,
	`GiaBan` long not null
);

create table `HinhAnh` (
	`MaHA` int primary key not null auto_increment,
	`DgDanAnh` varchar(100),
    `MaND` int,
    `MaSach` int
);


-- KHOAI CHINH --
alter table `CTPN` add constraint PK_DS_PN PRIMARY KEY(MaSach, MaPhNhap);
alter table `CTHD` add constraint PK_DS_HD PRIMARY KEY (MaSach, MaHD);
alter table `CTGH` add constraint PK_DS_GH PRIMARY KEY (MaSach, MaGH);
alter table `QuanLy` add constraint PK_TKQL_TKBQL PRIMARY KEY (MaTKQL, MaTKBQL);

-- KHOAI NGOAI --
alter table `DauSach` add constraint FK_DS_TL foreign key(MaLoai) references TheLoai(MaLoai);
alter table `DauSach` add constraint FK_DS_NXB foreign key(MaNXB) references NXB(MaNXB);
alter table `DauSach` add constraint FK_DS_TG foreign key(MaTG) references TacGia(MaTG);
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
alter table `QuanLy` add constraint FK_QL_TK FOREIGN KEY (MaTKQL) REFERENCES TaiKhoan(MaTK);
alter table `QuanLy` add constraint FK_QL_TK_2 FOREIGN KEY (MaTKBQL) REFERENCES TaiKhoan(MaTK);
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
        VALUES ('default_profile_pic.jpg', NEW.MaND);
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
       ('Đinh Tỵ', 'NV22 khu 12 ngõ 13 đường Lĩnh Nam, phường Mai Động, quận Hoàng Mai, Thành Phố Hà Nội', 'contacts@dinhtibooks.vn');
       
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
       ('Thanh Niên', 'D29 Khu đô thị mới Cầu Giấy, phường Yên Hòa, quận Cầu Giấy, Hà Nội', 'info@nxbthanhnien.vn');
       
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
       ('Robert Kirkman', '1978-11-31', 0),
       ('Hajime Isayama', '1986-08-29', 0),
       ('Judd Winick', '1970-02-12', 0),
       ('Stan Lee', '1922-12-28', 0),
       ('Jack Kirby', '1917-08-28', 0);
       
insert into TheLoai (TenLoai)
values ('Tiểu thuyết'),
	   ('Kinh dị'),
       ('Giáo dục'),
       ('Manga'),
       ('Truyện tranh'),
       ('Lãng mạn'),
       ('Thiếu nhi');
       
insert into DauSach (TenSach, )


