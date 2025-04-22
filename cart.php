<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit(); // Ensure no further code is executed
}

// Your cart page code goes here (replace the following with the actual cart logic)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Cart | GlowCare</title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet"/>

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #c3cfea, #f8c8dc);
      padding-top: 80px;
    }

    .navbar {
      background-color: #c3cfea;
    }

    .navbar-brand {
      font-weight: 700;
      color: #9f5f80;
    }

    .navbar-nav .nav-link {
      color: #333;
      font-weight: 500;
    }

    .navbar-nav .nav-link:hover {
      color: #f8c8dc;
    }

    .cart-title {
  margin-bottom: 30px;
  font-size: 2rem;
  font-weight: 700;
  color: #9f5f80;
  display: flex;
  align-items: center;
  gap: 12px;
  border-bottom: 2px solid #f8c8dc;
  padding-bottom: 10px;
}
.cart-title i {
  font-size: 1.8rem;
  color: #9f5f80;
}


    .cart-card {
      background-color: #ffffff;
      border: 1px solid #dee2e6;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .cart-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 8px;
    }

    .total-section {
      font-size: 1.2rem;
      font-weight: 600;
      text-align: right;
      margin-top: 30px;
    }

    .empty-cart {
      text-align: center;
      padding: 80px 20px;
      color: #777;
    }

    .empty-cart h3 {
      margin-bottom: 20px;
    }

    .empty-cart .btn {
      background-color: #f8c8dc;
      border: none;
      color: white;
      padding: 10px 20px;
    }

    .empty-cart .btn:hover {
      background-color: #e4b2c2;
    }

    .quantity-input {
      width: 60px;
      border: 1px solid #ccc;
      border-radius: 4px;
      text-align: center;
    }

    .remove-btn {
      border: none;
      background: none;
      color: #dc3545;
      font-size: 1.2rem;
    }

    .checkout-btn {
      background-color: #9f5f80;
      color: #fff;
      padding: 10px 30px;
      font-weight: 500;
      border-radius: 8px;
      float: right;
    }

    .checkout-btn:hover {
      background-color: #88476e;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light shadow fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">BareBelle</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
          <li class="nav-item"><a class="nav-link" href="products.html">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">

    <div id="cartContainer">
    <h2 class="cart-title"><i class="bi bi-bag-heart-fill"></i> Your Shopping Cart</h2>

      <!-- Cart Item -->
      <div class="cart-card d-flex align-items-center">
        <img src="https://via.placeholder.com/100" alt="Product" class="cart-img me-4">
        <div class="flex-grow-1">
          <h5 class="mb-1">Glow Hydrating Serum</h5>
          <p class="mb-1">Price: Rs. 1200</p>
          <div class="d-flex align-items-center gap-2">
            <label for="qty1" class="mb-0">Qty:</label>
            <input type="number" id="qty1" class="quantity-input" value="2" min="1">
          </div>
        </div>
        <div class="text-end">
          <p class="fw-bold mb-2">Subtotal: Rs. 2400</p>
          <button class="remove-btn" title="Remove"><i class="bi bi-trash"></i></button>
        </div>
      </div>

      <!-- Cart Item -->
      <div class="cart-card d-flex align-items-center">
        <img src="https://via.placeholder.com/100" alt="Product" class="cart-img me-4">
        <div class="flex-grow-1">
          <h5 class="mb-1">Radiant Cleanser</h5>
          <p class="mb-1">Price: Rs. 950</p>
          <div class="d-flex align-items-center gap-2">
            <label for="qty2" class="mb-0">Qty:</label>
            <input type="number" id="qty2" class="quantity-input" value="1" min="1">
          </div>
        </div>
        <div class="text-end">
          <p class="fw-bold mb-2">Subtotal: Rs. 950</p>
          <button class="remove-btn" title="Remove"><i class="bi bi-trash"></i></button>
        </div>
      </div>

      <!-- Total + Checkout -->
      <div class="total-section">
        Total: Rs. 3350
        <br>
        <button class="checkout-btn mt-3">Proceed to Checkout</button>
      </div>
    </div>

    <!-- Empty Cart Message -->
    <div id="emptyCart" class="empty-cart d-none">
      <h3>Your cart is empty.</h3>
      <a href="products.html" class="btn">Shop Products</a>
    </div>

  </div>

  <!-- Bootstrap JS + Icons -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <script>
    // Toggle this to simulate an empty cart
    const isCartEmpty = false;

    if (isCartEmpty) {
      document.getElementById('cartContainer').classList.add('d-none');
      document.getElementById('emptyCart').classList.remove('d-none');
    }
  </script>
</body>
</html>
