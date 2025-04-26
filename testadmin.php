<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare"; // Use your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch orders from the database
$sql = "SELECT orders.id, customers.name, products.name AS product_name, orders.quantity, orders.total, orders.order_date, orders.status 
        FROM orders
        JOIN customers ON orders.customer_id = customers.id
        JOIN products ON orders.product_id = products.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Orders List - BareBelle</title>
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

    .btn-complete {
      background-color: #6bcf63;
      color: white;
    }

    .btn-cancel {
      background-color: #ff6b6b;
      color: white;
    }

    .btn-complete:hover {
      background-color: #5abb55;
    }

    .btn-cancel:hover {
      background-color: #e65b5b;
    }

    .table td,
    .table th {
      vertical-align: middle;
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

        <!-- Logout Button -->
        <li class="nav-item ms-3">
          <a class="btn" href="logout.php" style="background-color: #f8c8dc; color: black;">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  <div class="title">Customer Orders</div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped bg-white shadow text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Product(s)</th>
          <th>Quantity</th>
          <th>Total</th>
          <th>Order Date</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody id="ordersTable">
        <?php if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) { ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><?php echo $row['name']; ?></td>
              <td><?php echo $row['product_name']; ?></td>
              <td><?php echo $row['quantity']; ?></td>
              <td>Rs. <?php echo $row['total']; ?></td>
              <td><?php echo $row['order_date']; ?></td>
              <td>
                <?php if ($row['status'] == 'Completed') { ?>
                  <span class="badge bg-success">Completed</span>
                <?php } else { ?>
                  <span class="badge bg-warning text-dark">Pending</span>
                <?php } ?>
              </td>
              <td>
                <?php if ($row['status'] != 'Completed') { ?>
                  <button class="btn btn-sm btn-complete">Mark as Completed</button>
                  <button class="btn btn-sm btn-cancel">Cancel</button>
                <?php } else { ?>
                  <button class="btn btn-sm btn-cancel">Delete</button>
                <?php } ?>
              </td>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td colspan="8">No orders found</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  document.querySelectorAll('.btn-complete').forEach(btn => {
    btn.addEventListener('click', function () {
      const row = this.closest('tr');
      row.querySelector('td:nth-child(7)').innerHTML = '<span class="badge bg-success">Completed</span>';
    });
  });

  document.querySelectorAll('.btn-cancel').forEach(btn => {
    btn.addEventListener('click', function () {
      if (confirm("Are you sure you want to cancel/delete this order?")) {
        this.closest('tr').remove();
      }
    });
  });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$conn->close(); // Close the connection
?>
