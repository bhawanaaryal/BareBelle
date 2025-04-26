<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products - BareBelle </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
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

        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }

        .table td, .table th {
            vertical-align: middle;
        }

        .btn-edit {
            background-color: #f8c8dc;
            color: #333;
        }

        .btn-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-edit:hover {
            background-color: #e4acc2;
        }

        .btn-delete:hover {
            background-color: #e95b5b;
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
    <div class="title">Manage Products</div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle bg-white shadow">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample Row: Replace with dynamic PHP rows later -->
                <tr>
                    <td><img src="product_images/fixdermamoist.jpg" alt="Product"></td>
                    <td>Fixderma Durave Moisturizer Deep Hydration Face Moisturizer - 50g</td>
                    <td>Moisturizer</td>
                    <td>5</td>
                    <td>Rs. 472</td>
                    <td>
                        <a href="edit_product.php?id=1" class="btn btn-sm btn-edit">Edit</a>
                        <a href="delete_product.php?id=1" class="btn btn-sm btn-delete">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td><img src="product_images/aqualogicasun.JPG" alt="Product"></td>
                    <td>Aqualogica Glow+ Sunscreen 80g</td>
                    <td>Sunscreen</td>
                    <td>10</td>
                    <td>Rs. 911</td>
                    <td>
                        <a href="edit_product.php?id=2" class="btn btn-sm btn-edit">Edit</a>
                        <a href="delete_product.php?id=2" class="btn btn-sm btn-delete">Delete</a>
                    </td>
                </tr>
                <!-- Add more rows dynamically later -->
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
