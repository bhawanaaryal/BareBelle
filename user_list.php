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

        <!-- Logout Button -->
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
      <tbody id="usersTable">
        <tr>
          <td>1</td>
          <td>Bhawana Aryal</td>
          <td>bhawana@example.com</td>
          <td>9812345678</td>
          <td>Pokhara, Nepal</td>
          <td>Customer</td>
          <td><button class="btn btn-sm btn-delete">Delete</button></td>
        </tr>
        <tr>
          <td>2</td>
          <td>Admin User</td>
          <td>admin@barebelle.com</td>
          <td>9800000000</td>
          <td>Kathmandu, Nepal</td>
          <td>Admin</td>
          <td><button class="btn btn-sm btn-delete">Delete</button></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<script>
  document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', function () {
      if (confirm("Are you sure you want to delete this user?")) {
        this.closest('tr').remove();
      }
    });
  });
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
