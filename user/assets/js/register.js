const cities = [
  { value: 1, name: "An Giang" },
  { value: 2, name: "Bà Rịa - Vũng Tàu" },
  { value: 3, name: "Bạc Liêu" },
  { value: 4, name: "Bắc Giang" },
  { value: 5, name: "Bắc Kạn" },
  { value: 6, name: "Bắc Ninh" },
  { value: 7, name: "Bến Tre" },
  { value: 8, name: "Bình Định" },
  { value: 9, name: "Bình Dương" },
  { value: 10, name: "Bình Phước" },
  { value: 11, name: "Bình Thuận" },
  { value: 12, name: "Cà Mau" },
  { value: 13, name: "Cần Thơ" },
  { value: 14, name: "Cao Bằng" },
  { value: 15, name: "Đà Nẵng" },
  { value: 16, name: "Đắk Lắk" },
  { value: 17, name: "Đắk Nông" },
  { value: 18, name: "Điện Biên" },
  { value: 19, name: "Đồng Nai" },
  { value: 20, name: "Đồng Tháp" },
  { value: 21, name: "Gia Lai" },
  { value: 22, name: "Hà Giang" },
  { value: 23, name: "Hà Nam" },
  { value: 24, name: "Hà Nội" },
  { value: 25, name: "Hà Tĩnh" },
  { value: 26, name: "Hải Dương" },
  { value: 27, name: "Hải Phòng" },
  { value: 28, name: "Hậu Giang" },
  { value: 29, name: "Hòa Bình" },
  { value: 30, name: "Hưng Yên" },
  { value: 31, name: "Khánh Hòa" },
  { value: 32, name: "Kiên Giang" },
  { value: 33, name: "Kon Tum" },
  { value: 34, name: "Lai Châu" },
  { value: 35, name: "Lâm Đồng" },
  { value: 36, name: "Lạng Sơn" },
  { value: 37, name: "Lào Cai" },
  { value: 38, name: "Long An" },
  { value: 39, name: "Nam Định" },
  { value: 40, name: "Nghệ An" },
  { value: 41, name: "Ninh Bình" },
  { value: 42, name: "Ninh Thuận" },
  { value: 43, name: "Phú Thọ" },
  { value: 44, name: "Phú Yên" },
  { value: 45, name: "Quảng Bình" },
  { value: 46, name: "Quảng Nam" },
  { value: 47, name: "Quảng Ngãi" },
  { value: 48, name: "Quảng Ninh" },
  { value: 49, name: "Quảng Trị" },
  { value: 50, name: "Sóc Trăng" },
  { value: 51, name: "Sơn La" },
  { value: 52, name: "Tây Ninh" },
  { value: 53, name: "Thái Bình" },
  { value: 54, name: "Thái Nguyên" },
  { value: 55, name: "Thanh Hóa" },
  { value: 56, name: "Thừa Thiên Huế" },
  { value: 57, name: "Tiền Giang" },
  { value: 58, name: "TP. Hồ Chí Minh" },
  { value: 59, name: "Trà Vinh" },
  { value: 60, name: "Tuyên Quang" },
  { value: 61, name: "Vĩnh Long" },
  { value: 62, name: "Vĩnh Phúc" },
  { value: 63, name: "Yên Bái" },
];

const districts = [
  // TP. Hồ Chí Minh
  { cityId: 58, value: 1, name: "Quận 1" },
  { cityId: 58, value: 2, name: "Quận 2" },
  { cityId: 58, value: 3, name: "Quận 3" },
  { cityId: 58, value: 4, name: "Quận 4" },
  { cityId: 58, value: 5, name: "Quận 5" },
  { cityId: 58, value: 6, name: "Quận 6" },
  { cityId: 58, value: 7, name: "Quận 7" },
  { cityId: 58, value: 8, name: "Quận 8" },
  { cityId: 58, value: 9, name: "Quận 9" },
  { cityId: 58, value: 10, name: "Quận 10" },
  { cityId: 58, value: 11, name: "Quận 11" },
  { cityId: 58, value: 12, name: "Quận 12" },
  { cityId: 58, value: 13, name: "Bình Thạnh" },
  { cityId: 58, value: 14, name: "Gò Vấp" },
  { cityId: 58, value: 15, name: "Phú Nhuận" },
  { cityId: 58, value: 16, name: "Tân Bình" },
  { cityId: 58, value: 17, name: "Tân Phú" },
  { cityId: 58, value: 18, name: "Bình Tân" },
  { cityId: 58, value: 19, name: "Thủ Đức" },
  { cityId: 58, value: 20, name: "Huyện Bình Chánh" },
  { cityId: 58, value: 21, name: "Huyện Củ Chi" },
  { cityId: 58, value: 22, name: "Huyện Hóc Môn" },
  { cityId: 58, value: 23, name: "Huyện Nhà Bè" },
  { cityId: 58, value: 24, name: "Huyện Cần Giờ" },

  // Hà Nội
  { cityId: 24, value: 25, name: "Ba Đình" },
  { cityId: 24, value: 26, name: "Hoàn Kiếm" },
  { cityId: 24, value: 27, name: "Hai Bà Trưng" },
  { cityId: 24, value: 28, name: "Đống Đa" },
  { cityId: 24, value: 29, name: "Cầu Giấy" },
  { cityId: 24, value: 30, name: "Thanh Xuân" },
  { cityId: 24, value: 31, name: "Long Biên" },
  { cityId: 24, value: 32, name: "Tây Hồ" },
  { cityId: 24, value: 33, name: "Hoàng Mai" },
  { cityId: 24, value: 34, name: "Nam Từ Liêm" },
  { cityId: 24, value: 35, name: "Bắc Từ Liêm" },
  { cityId: 24, value: 36, name: "Hà Đông" },

  // Đà Nẵng
  { cityId: 15, value: 37, name: "Hải Châu" },
  { cityId: 15, value: 38, name: "Thanh Khê" },
  { cityId: 15, value: 39, name: "Sơn Trà" },
  { cityId: 15, value: 40, name: "Ngũ Hành Sơn" },
  { cityId: 15, value: 41, name: "Liên Chiểu" },
  { cityId: 15, value: 42, name: "Cẩm Lệ" },
  { cityId: 15, value: 43, name: "Huyện Hòa Vang" },

  // Hải Phòng
  { cityId: 27, value: 44, name: "Hồng Bàng" },
  { cityId: 27, value: 45, name: "Lê Chân" },
  { cityId: 27, value: 46, name: "Ngô Quyền" },
  { cityId: 27, value: 47, name: "Hải An" },
  { cityId: 27, value: 48, name: "Kiến An" },
  { cityId: 27, value: 49, name: "Dương Kinh" },

  // Một số tỉnh khác
  { cityId: 19, value: 50, name: "Biên Hòa (Đồng Nai)" },
  { cityId: 19, value: 51, name: "Long Khánh (Đồng Nai)" },
  { cityId: 9, value: 52, name: "Thủ Dầu Một (Bình Dương)" },
  { cityId: 9, value: 53, name: "Dĩ An (Bình Dương)" },
  { cityId: 9, value: 54, name: "Thuận An (Bình Dương)" },
  { cityId: 9, value: 55, name: "Tân Uyên (Bình Dương)" },
  { cityId: 38, value: 56, name: "Tân An (Long An)" },
  { cityId: 38, value: 57, name: "Cần Giuộc (Long An)" },
  { cityId: 38, value: 58, name: "Bến Lức (Long An)" },
];

const wards = [
  // Quận 1
  { districtId: 1, value: 1, name: "Phường Bến Nghé" },
  { districtId: 1, value: 2, name: "Phường Bến Thành" },
  { districtId: 1, value: 3, name: "Phường Cầu Kho" },
  { districtId: 1, value: 4, name: "Phường Cầu Ông Lãnh" },
  { districtId: 1, value: 5, name: "Phường Đa Kao" },

  // Quận 2
  { districtId: 2, value: 6, name: "Phường An Khánh" },
  { districtId: 2, value: 7, name: "Phường An Lợi Đông" },
  { districtId: 2, value: 8, name: "Phường Bình An" },
  { districtId: 2, value: 9, name: "Phường Bình Trưng Tây" },
  { districtId: 2, value: 10, name: "Phường Thảo Điền" },

  // Quận 3
  { districtId: 3, value: 11, name: "Phường Võ Thị Sáu" },
  { districtId: 3, value: 12, name: "Phường 2" },
  { districtId: 3, value: 13, name: "Phường 3" },

  // Quận 4
  { districtId: 4, value: 14, name: "Phường 1" },
  { districtId: 4, value: 15, name: "Phường 2" },
  { districtId: 4, value: 16, name: "Phường 3" },

  // Quận 5
  { districtId: 5, value: 17, name: "Phường 1" },
  { districtId: 5, value: 18, name: "Phường 2" },
  { districtId: 5, value: 19, name: "Phường 3" },

  // Quận 6
  { districtId: 6, value: 20, name: "Phường 1" },
  { districtId: 6, value: 21, name: "Phường 2" },

  // Quận 7
  { districtId: 7, value: 22, name: "Phường Tân Phú" },
  { districtId: 7, value: 23, name: "Phường Tân Thuận Tây" },

  // Quận 8
  { districtId: 8, value: 24, name: "Phường 1" },
  { districtId: 8, value: 25, name: "Phường 2" },

  // Quận 9
  { districtId: 9, value: 26, name: "Phường Hiệp Phú" },
  { districtId: 9, value: 27, name: "Phường Long Thạnh Mỹ" },

  // Quận 10
  { districtId: 10, value: 28, name: "Phường 1" },
  { districtId: 10, value: 29, name: "Phường 2" },

  // Quận 11
  { districtId: 11, value: 30, name: "Phường 1" },
  { districtId: 11, value: 31, name: "Phường 2" },

  // Quận 12
  { districtId: 12, value: 32, name: "Phường An Phú Đông" },
  { districtId: 12, value: 33, name: "Phường Đông Hưng Thuận" },

  // Bình Thạnh
  { districtId: 13, value: 34, name: "Phường 1" },
  { districtId: 13, value: 35, name: "Phường 2" },

  // Gò Vấp
  { districtId: 14, value: 36, name: "Phường 1" },
  { districtId: 14, value: 37, name: "Phường 2" },

  // Phú Nhuận
  { districtId: 15, value: 38, name: "Phường 1" },
  { districtId: 15, value: 39, name: "Phường 2" },

  // Tân Bình
  { districtId: 16, value: 40, name: "Phường 1" },
  { districtId: 16, value: 41, name: "Phường 2" },

  // Tân Phú
  { districtId: 17, value: 42, name: "Phường Sơn Kỳ" },
  { districtId: 17, value: 43, name: "Phường Tân Sơn Nhì" },

  // Bình Tân
  { districtId: 18, value: 44, name: "Phường An Lạc" },
  { districtId: 18, value: 45, name: "Phường Tân Tạo" },
];

function updateDistrict() {
  const city = document.getElementById(`city`);

  let districtList = document.getElementById(`district`);
  districtList.innerHTML = `<option value="0">Quận / Huyện</option>`;

  for (let i = 0; i < districts.length; i++) {
    if (districts[i].cityId == city.value) {
      let option = document.createElement(`option`);
      option.value = districts[i].value;
      option.textContent = districts[i].name;
      districtList.appendChild(option);
    }
  }
}

function updateCommund() {
  const selectedDistrict = document.getElementById(`district`);

  let commundList = document.getElementById(`commund`);
  commundList.innerHTML = `<option value="0">Phường / Xã</option>`;

  for (let i = 0; i < wards.length; i++) {
    if (wards[i].districtId == selectedDistrict.value) {
      let option = document.createElement(`option`);
      option.value = wards[i].value;
      option.textContent = wards[i].name;
      commundList.appendChild(option);
    }
  }
}

document.addEventListener("DOMContentLoaded", () => {
  let citylist = document.getElementById("city");

  citylist.innerHTML = `<option value="0">Tỉnh / Thành</option>`;

  for (let i = 0; i < cities.length; i++) {
    let option = document.createElement(`option`);
    option.value = cities[i].value;
    option.textContent = cities[i].name;
    citylist.appendChild(option);
  }

  document.getElementById(`city`).addEventListener("change", () => {
    updateDistrict();
    if (document.getElementById(`city`).value != 0) {
      document.getElementById(`city`).style.color = `black`;
    } else {
      document.getElementById(`city`).style.color = `gray`;
    }
  });

  document.getElementById(`district`).addEventListener("change", () => {
    updateCommund();
    if (document.getElementById(`district`).value != 0) {
      document.getElementById(`district`).style.color = `black`;
    } else {
      document.getElementById(`district`).style.color = `gray`;
    }
  });

  document.getElementById(`commund`).addEventListener("change", function () {
    if (document.getElementById(`commund`).value != 0) {
      document.getElementById(`commund`).style.color = `black`;
    } else {
      document.getElementById(`commund`).style.color = `gray`;
    }
  });
});
