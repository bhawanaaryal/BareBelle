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
        <tr>
          <td>101</td>
          <td>Bhawana Aryal</td>
          <td>Cetaphil Moisturizing Cream (80g)</td>
          <td>2</td>
          <td>Rs. 935</td>
          <td>2025-04-18</td>
          <td><span class="badge bg-warning text-dark">Pending</span></td>
          <td>
            <button class="btn btn-sm btn-complete">Mark as Completed</button>
            <button class="btn btn-sm btn-cancel">Cancel</button>
          </td>
        </tr>
        <tr>
          <td>102</td>
          <td>Elina Joshi</td>
          <td>Uv Doux Sunscreen Gel, Spf 50+, 50gm</td>
          <td>1</td>
          <td>Rs. 1125</td>
          <td>2025-04-17</td>
          <td><span class="badge bg-success">Completed</span></td>
          <td>
            <button class="btn btn-sm btn-cancel">Delete</button>
          </td>
        </tr>
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
