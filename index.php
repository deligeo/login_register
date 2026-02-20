<?php

session_start();
require_once 'config.php';

$errors = [
  'login' => $_SESSION['login_error'] ?? '',
  'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'login';

$query = "SELECT id, school_name FROM schools ORDER BY school_name ASC";
$school_result = $conn->query($query);

session_unset();

function showError($error) {
  return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
  return $formName === $activeForm ? 'active' : '';
}

?>

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
    <div class="form-box <?= isActiveForm('login', $activeForm); ?>" id="login-form">
      <form action="login_register.php" method="post">
        <h2>Login</h2>
        <?= showError($errors['login']); ?>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
        <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
      </form>
    </div>

    <div class="form-box <?= isActiveForm('register', $activeForm); ?>" id="register-form">
      <form action="login_register.php" method="post">
        <h2>Register</h2>
        <?= showError($errors['register']); ?>
        <!-- <select name="school" required>
          <option value="">--Select School--</option>
          <option value="school1">Rajagiri Public School, Kochi</option>
          <option value="school2">Chinmaya Vidyalaya, Kochi</option>
          <option value="school3">St. Mary's School, Kochi</option>
        </select> -->
        <select name="school" required>
          <option value="">--Select School--</option>
          <?php 
          if ($school_result && $school_result->num_rows > 0) {
              while($row = $school_result->fetch_assoc()) {
                  echo "<option value='" . $row['id'] . "'>" . $row['school_name'] . "</option>";
              }
          }
          ?>
        </select>
        <input type="text" name="name" placeholder="Name" required>
        
            <!-- Gender Field -->
            <div class="gender-box">
              <label class="gender-label">Gender:</label>
              <label><input type="radio" name="gender" value="male" required> Male</label>
              <label><input type="radio" name="gender" value="female"> Female</label>
            </div>
        <input type="number" name="age" placeholder="Age" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>
        <input type="text" name="address" placeholder="Address" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" name="register">Register</button>
        <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
      </form>
  </div>
  <script src="script.js"></script>
</body>
</html>