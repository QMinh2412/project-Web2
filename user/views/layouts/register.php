<link rel="stylesheet" href="../../assets/css/register.css">
  <body>
    <div class="register-container">
      <h2>Đăng ký</h2>
      <form action="">
        <div class="form-group">
          <div class="form-column">
            <label for="fullname">Họ tên *</label>
            <input type="text" name="fullname" id="fullname" required />
          </div>
          <div class="form-column">
            <label for="username">Tên tài khoản *</label>
            <input type="text" name="username" id="username" required />
          </div>
        </div>

        <div class="form-group">
          <div class="form-column">
            <label for="email">Email *</label>
            <input type="email" name="email" id="email" required />
          </div>
          <div class="form-column">
            <label for="password">Mật khẩu *</label>
            <input type="password" name="password" id="password" required />
          </div>
        </div>

        <div class="form-group">
          <div class="form-column">
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" id="phone" />
          </div>
          <div class="form-column">
            <label for="dob">Ngày sinh *</label>
            <input type="date" name="dob" id="dob" required />
          </div>
        </div>

        <div class="form-group">
          <label>Giới tính *</label>
          <div class="gender-group">
            <label
              ><input
                type="radio"
                name="gender"
                value="0"
                required
              />Nam</label
            >
            <label
              ><input type="radio" name="gender" value="1" required />
              Nữ</label
            >
          </div>
        </div>
        <div class="form-group">
          <label for="city">Địa chỉ</label>
        </div>
        <div class="form-group">
          <div class="form-column">
            <select name="city" id="city">
              <option value="">Tỉnh / Thành</option>
            </select>
          </div>
          <div class="form-column">
            <select name="district" id="district">
              <option value="">Quận / Huyện</option>
            </select>
          </div>
        </div>

        <div class="form-group">
          <div class="form-column">
            <select name="commund" id="commund">
              <option value="">Phường / Xã</option>
            </select>
          </div>
          <div class="form-column">
            <input type="text" name="house" id="house" placeholder="Số nhà, đường">
          </div>
        </div>

        <button type="submit">Đăng ký</button>
      </form>
      <div class="login-link">Đã có tài khoản? <a href="login.php">Đăng nhập</a></div>
    </div>
  </body>
<script src="../../assets/js/register.js"></script>
