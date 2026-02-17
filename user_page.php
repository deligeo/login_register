<?php

session_start();

if(!isset($_SESSION['email'])) {
  header('Location: index.php');
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  <div class="box">
    <h1>Welcome</h1>
    <p>User: <?= $_SESSION['name']; ?></p>
    <button onclick="window.location.href='logout.php'">Logout</button>
  </div>
</body>
</html>