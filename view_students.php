<?php

session_start();
require_once 'config.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: index.php');
  exit();
}

if(!isset($_GET['school_id']) || !is_numeric($_GET['school_id'])) {
  header('Location: admin_page.php');
  exit();
}

$school_id = $_GET['school_id'];

$stmt_school = $conn->prepare("SELECT school_name FROM schools where id = ?");
$stmt_school->bind_param("i", $school_id);
$stmt_school->execute();
$result_school = $stmt_school->get_result();

if($result_school->num_rows === 0) {
  header('Location: admin_page.php');
  exit();
}

$school = $result_school->fetch_assoc();
$stmt_school->close();

$stmt = $conn->prepare("
    SELECT id, name, gender, age, phone, email, address 
    FROM users 
    WHERE school_id = ? AND role = 'user'
");
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Students - <?php echo htmlspecialchars($school['school_name']); ?></title>
</head>
<body>

<h1>Students of <?php echo htmlspecialchars($school['school_name']); ?></h1>

<button onclick="window.location.href='admin_page.php'">⬅ Back to School List</button>

<hr>

<?php if($result->num_rows > 0): ?>

<table border="1" cellpadding="10" width="100%">
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Phone</th>
        <th>Email</th>
        <th>Address</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['gender']); ?></td>
            <td><?php echo $row['age']; ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['address']); ?></td>
        </tr>
    <?php endwhile; ?>

</table>

<?php else: ?>
    <p>No students found for this school.</p>
<?php endif; ?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>