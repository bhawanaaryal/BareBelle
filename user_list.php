<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page or show an error message
    header("Location: login.php");
    exit();
}
// Connect to database
$conn = new mysqli('localhost', 'root', '', 'glowcare'); // Update credentials if needed

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle update request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $role = $_POST['role'];

    $update_sql = "UPDATE users SET name='$name', email='$email', phone='$phone', address='$address', role='$role' WHERE id='$id'";
    $conn->query($update_sql);
}

// Handle delete request
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $delete_sql = "DELETE FROM users WHERE id='$id'";
    $conn->query($delete_sql);
}

// Fetch all users
$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Users List - BareBelle</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #c3cfea, #f8c8dc);
      padding: 60px 20px;
      min-height: 100vh;
    }
    .title {
      text-align: center;
      font-size: 2rem;
      font-weight: bold;
      color: #9f5f80;
      margin-bottom: 30px;
    }
    .btn-update {
      background-color: #f8c8dc;
      color: #333;
    }
    .btn-update:hover {
      background-color: #e4acc2;
    }
    .btn-delete {
      background-color: #ff6b6b;
      color: white;
    }
    .btn-delete:hover {
      background-color: #e55c5c;
    }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">BareBelle Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_products.php">Manage Products</a></li>
        <li class="nav-item"><a class="nav-link" href="view_order.php">Manage Orders</a></li>
        <li class="nav-item"><a class="nav-link" href="user_list.php">Manage Customers</a></li>
        <li class="nav-item ms-3">
          <a class="btn" href="logout.php" style="background-color: #f8c8dc; color: black;">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="title">Registered Users</div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped bg-white shadow text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Address</th>
          <th>Role</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php $i = 1; while($row = $result->fetch_assoc()): ?>
            <tr>
              <form method="post" action="">
                <td><?php echo $i++; ?></td>
                <td>
                  <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($row['name']); ?>" required>
                </td>
                <td>
                  <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                </td>
                <td>
                  <input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($row['phone']); ?>" required>
                </td>
                <td>
                  <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($row['address']); ?>" required>
                </td>
                <td>
                  <select name="role" class="form-select" required>
                    <option value="customer" <?php if($row['role'] == 'customer') echo 'selected'; ?>>Customer</option>
                    <option value="admin" <?php if($row['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                  </select>
                </td>
                <td class="d-flex justify-content-center gap-2">
                  <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                  <button type="submit" name="update" class="btn btn-sm btn-update">Update</button>
                  <button type="submit" name="delete" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                </td>
              </form>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="7">No users found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close();
?>
