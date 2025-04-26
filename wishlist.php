<?php
session_start(); // Start the session

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit(); // Ensure no further code is executed
}

// Example of wishlist data (replace with dynamic data from the database or session)
$wishlist_items = []; // This will be an array of wishlist products (use database logic here)
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Wishlist - BareBelle Skincare</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="teststyle3.css"/>

    <style>
        body {
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            font-family: 'Quicksand', sans-serif;
            padding-bottom: 50px;
        }

        .wishlist-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 18px;
            box-shadow: 0 12px 18px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        .wishlist-title {
            font-size: 2.4rem;
            font-weight: 700;
            color: #9f5f80;
            border-bottom: 3px solid #f8c8dc;
            padding-bottom: 10px;
            margin-bottom: 20px;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .wishlist-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 25px;
            border-radius: 12px;
            padding: 12px;
            background-color: #f0f0f0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .wishlist-item img {
            width: 90px;
            height: 90px;
            object-fit: cover;
            border-radius: 12px;
        }

        .wishlist-item-details {
            flex: 1;
            margin-left: 15px;
        }

        .wishlist-item-details h5 {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 5px;
        }

        .wishlist-item-details p {
            font-size: 0.9rem;
            color: #777;
            margin: 0;
        }

        .wishlist-item-actions {
            display: flex;
            gap: 10px;
        }

        .wishlist-item-actions a {
            text-decoration: none;
            color: #9f5f80;
            padding: 8px 14px;
            background-color: #f8c8dc;
            border-radius: 30px;
            border: 1px solid #f8c8dc;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .wishlist-item-actions a:hover {
            background-color: #c3cfea;
            border-color: #c3cfea;
        }

        .empty-wishlist-message {
            font-size: 1.2rem;
            color: #777;
            text-align: center;
            padding: 40px 0;
            font-weight: 600;
        }

        .btn-shop-products {
            display: block;
            margin: 0 auto;
            font-size: 1rem;
            padding: 12px 35px;
            background-color: #9f5f80;
            color: #fff;
            border-radius: 30px;
            text-decoration: none;
            text-align: center;
            border: 2px solid #9f5f80;
            transition: background-color 0.3s, color 0.3s;
        }

        .btn-shop-products:hover {
            background-color: #f8c8dc;
            color: #333;
            border-color: #f8c8dc;
        }

        .wishlist-item img:hover {
            transform: scale(1.1);
            transition: transform 0.3s ease;
        }

        .wishlist-item-details h5:hover {
            color: #9f5f80;
            transition: color 0.3s ease;
        }
        .floating-icons {
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.floating-icons a {
    width: 50px;
    height: 50px;
    background-color: #f8c8dc;
    color: #fff;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    transition: background-color 0.3s;
}

.floating-icons a:hover {
    background-color: #c3cfea;
}
footer {
            background-color: #f0f0f0;
            padding: 15px 0;
            text-align: center;
            color: #555;
            font-size: 0.95rem;
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
      
      <!-- Search Form with Icon -->
      <form class="d-flex me-3" action="search.php" method="GET">
        <input class="form-control me-2" type="search" name="query" placeholder="Search..." aria-label="Search" style="width: 180px;">
        <button class="btn btn-outline-secondary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>

      <!-- Navigation Links -->
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="productscategories.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>

        <!-- Logout Button -->
        <li class="nav-item ms-3">
        <a class="btn" href="logout.php" style="background-color: #f8c8dc; color: black;">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container my-5">
        <div class="wishlist-container">
            <h2 class="wishlist-title">Your Wishlist</h2>

            <!-- Example Wishlist Item -->
            <div class="wishlist-item">
                <img src="product_images/dotandkeymoist.JPG" alt="Product Image">
                <div class="wishlist-item-details">
                    <h5>Dot & Key Watermelon Moisturizer- 60 Ml

</h5>
                    <p>Price: Rs. 752</p>
                </div>
                <div class="wishlist-item-actions">
                    <a href="cart.php" class="btn btn-outline-primary">Add to Cart</a>
                    <a href="#" class="btn btn-outline-danger">Remove</a>
                </div>
            </div>

            <!-- Example Wishlist Item -->
            <div class="wishlist-item">
                <img src="product_images/beautyofjoseonsun.JPG" alt="Product Image">
                <div class="wishlist-item-details">
                    <h5>Beauty Of Joseon Spf 50 Relief Sun Cream: Rice + Probiotics - 50ml

</h5>
                    <p>Price: Rs. 2090</p>
                </div>
                <div class="wishlist-item-actions">
                    <a href="cart.php" class="btn btn-outline-primary">Add to Cart</a>
                    <a href="#" class="btn btn-outline-danger">Remove</a>
                </div>
            </div>

            <!-- Empty Wishlist (when no items) -->
            <div class="empty-wishlist-message" id="empty-wishlist-message">
                <a href="productscategories.php" class="btn-shop-products">Shop Products</a>
            </div>

        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Floating Cart & Wishlist Icons -->
<div class="floating-icons">
    <a href="#" data-bs-toggle="modal" data-bs-target="#wishlistModal" title="Wishlist">
        <i class="bi bi-heart"></i>
    </a>
    <a href="#" data-bs-toggle="modal" data-bs-target="#cartModal" title="Shopping Cart">
        <i class="bi bi-cart3"></i>
    </a>
</div>

<!-- Wishlist Modal -->
<div class="modal fade" id="wishlistModal" tabindex="-1" aria-labelledby="wishlistModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-end">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Your Wishlist</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>No items in wishlist.</p>
          <!-- You can use PHP/JS here later to show dynamic content -->
        </div>
        <div class="modal-footer">
          <a href="wishlist.php" class="btn btn-outline-primary">Edit Wishlist</a>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Cart Modal -->
  <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-end">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Your Cart</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <p>No items in cart.</p>
          <!-- Replace this with dynamic product listing -->
        </div>
        <div class="modal-footer">
          <a href="cart.php" class="btn btn-outline-primary">Edit Cart</a>
        </div>
      </div>
    </div>
  </div>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
