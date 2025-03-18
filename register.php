<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Đăng ký</title>
    <style>
      body {
        background-color: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
      }
      .register-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        width: 600px;
        text-align: center;
      }
      .register-container h2 {
        color: #a64b2a;
        margin-bottom: 20px;
      }
      .form-group {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
      }
      .form-group label {
        display: block;
        font-weight: bold;
        font-size: 14px;
        margin-bottom: 5px;
        color: #5a2e17;
        float: left;
      }
      .form-group input,
      .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
      }
      .form-column {
        width: 48%;
      }
      .gender-group {
        display: flex;
        align-items: center;
        justify-content: center;
      }
      .gender-group input {
        margin-left: 5px;
      }
      .register-container button {
        width: 100%;
        padding: 10px;
        background-color: #a64b2a;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 10px;
      }
      .register-container button:hover {
        background-color: #8a3e21;
      }
      .login-link {
        margin-top: 10px;
        font-size: 14px;
      }
      .login-link a {
        color: #a64b2a;
        text-decoration: none;
      }
      .login-link a:hover {
        text-decoration: underline;
      }
      input::placeholder,
      select {
        color: rgba(0, 0, 0, 0.5);
        font-style: italic;
      }
    </style>
  </head>
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
                value="Nam"
                required
              />Nam</label
            >
            <label
              ><input type="radio" name="gender" value="Nữ" required />
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
            <select name="house" id="house">
              <option value="">Số nhà / Đường</option>
            </select>
          </div>
        </div>

        <button type="submit">Đăng ký</button>
      </form>
      <div class="login-link">Đã có tài khoản? <a href="">Đăng nhập</a></div>
    </div>
  </body>
</html>
