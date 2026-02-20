<?php

session_start();
require_once 'config.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

$message = '';

if(isset($_POST['add-school'])) {
  $school_name = $_POST['school_name'];
  $address = $_POST['address'];
  $phone = $_POST['phone'];
  $pincode = $_POST['pin'];

  $stmt = $conn->prepare("SELECT id FROM schools WHERE school_name = ?");
  $stmt->bind_param("s", $school_name);
  $stmt->execute();
  $stmt->store_result();
  
  if($stmt->num_rows > 0) {
    $message = "School is already registered";
    $_SESSION['active_form'] = 'register';
  } else {
    $stmt_insert = $conn->prepare("INSERT INTO schools (school_name, address, phone, pincode) VALUES (?, ?, ?, ?)");
    $stmt_insert->bind_param("ssss", $school_name, $address, $phone, $pincode);
    if($stmt_insert->execute()) {
        $message = "School added successfully!";
    } else {
        $message = "Error adding school.";
    }
    $stmt_insert->close();
  }
  $stmt->close();
}

// school details to an array
$schools = [];

$result = $conn->query("SELECT id, school_name, address, pincode, phone FROM schools");

if($result->num_rows >0) {
  while($row = $result->fetch_assoc()) {
    $schools[] = $row;
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Page</title>
</head>
<body>
  <h1>Welcome, Admin</h1>
  <!-- Logout Button -->
  <button onclick="window.location.href='logout.php'">Logout</button>

  <!-- Add School Form -->
  <div class="adding-school">
    <?php if($message): ?>
      <p style="color:red;"><?php echo $message; ?></p>
    <?php endif; ?>
    <form method="post">
      <h2>Add School</h2>
      <input type="text" name="school_name" placeholder="School Name" required>
      <input type="text" name="address" placeholder="Address" required>
      <input type="tel" name="phone" placeholder="Phone Number" required>
      <input type="number" name="pin" placeholder="Pin Code" required>

      <button type="submit" name="add-school">Add School</button>
    </form>
  </div>

  <!-- Display Schools -->
   <div class="all-schools">
      <table>
    <h2>School List</h2>
    <?php if(count($schools) > 0):?>
        <thead>
          <tr>
            <th>ID</th>
            <th>School Name</th>
            <th>Address</th>
            <th>Phone</th>
            <th>Pincode</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach($schools as $school): ?>
            <tr>
              <td><?php echo $school['id']; ?></td>
              <td><?php echo $school['school_name']; ?></td>
              <td><?php echo $school['address']; ?></td>
              <td><?php echo $school['phone']; ?></td>
              <td><?php echo $school['pincode']; ?></td>
              <td>
                <a href="view_students.php?school_id=<?php echo $school['id']; ?>">
                    <button>View Students</button>
                </a>
            </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No schools registered yet.</p>
    <?php endif; ?>
   </div>
</body>
</html>