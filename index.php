<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Register using PHP</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <div class="form-box active" id="login-form">
      <form action="login_register.php" method="post">
        <h2>Login</h2>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
      </form>
    </div>

    <div class="form-box" id="register-form">
      <form action="login_register.php" method="post">
        <h2>Register</h2>
        <select name="school" required>
          <option value="">--Select School--</option>
          <option value="school1">Rajagiri Public School, Kochi</option>
          <option value="school2">Chinmaya Vidyalaya, Kochi</option>
          <option value="school3">St. Mary's School, Kochi</option>
        </select>
        <input type="text" name="name" placeholder="Name" required>
        
            <!-- Gender Field -->
            <div class="gender-box">
              <label class="gender-label">Gender:</label>
              <label><input type="radio" name="gender" value="male" required> Male</label>
              <label><input type="radio" name="gender" value="female"> Female</label>
            </div>
        <input type="age" name="age" placeholder="Age" required>
        <input type="phone" name="phone" placeholder="Phone Number" required>
        <input type="address" name="address" placeholder="Address" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" name="register">Register</button>
        <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
      </form>
  </div>
  <script src="script.js"></script>
</body>
</html>