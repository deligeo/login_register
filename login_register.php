<?php

session_start();
require_once 'config.php';

if(isset($_POST['register'])) {
  $school = $_POST['school'];
  $name = $_POST['name'];
  $gender = $_POST['gender'];
  $age = $_POST['age'];
  $phone = $_POST['phone'];
  $address = $_POST['address'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
  
  if($checkEmail->num_rows > 0) {
    $_SESSION['register_error'] = 'Email is already registered';
    $_SESSION['active_form'] = 'register';
  } else {
    $conn->query("INSERT INTO users (school, name, gender, age, phone, address, email, password) VALUES ('$school', '$name', '$gender', '$age', '$phone', '$address', '$email', '$password')");
  }

  header('Location: index.php');
  exit();
}
?>