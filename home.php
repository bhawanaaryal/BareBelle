<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GlowCare Skincare</title>

    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<!-- Floating Cart & Wishlist Icons -->
<div class="floating-icons">
    <a href="wishlist.php" title="Wishlist">
        <i class="bi bi-heart"></i>
    </a>
    <a href="cart.php" title="Shopping Cart">
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
</head>
<body>
<?php include 'navbar.php'; ?>
<!--

<nav class="navbar navbar-expand-lg navbar-light shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">BareBelle</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
   
      <form class="d-flex me-3" action="search.php" method="GET">
        <input class="form-control me-2" type="search" name="query" placeholder="Search..." aria-label="Search" style="width: 180px;">
        <button class="btn btn-outline-secondary" type="submit">
          <i class="bi bi-search"></i>
        </button>
      </form>

      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="productscategories.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <li class="nav-item ms-3">
        <a class="btn" href="logout.php" style="background-color: #f8c8dc; color: black;">Logout</a>
        </li>
      </ul>
      </ul>
    </div>
  </div>
</nav>
!--> 
    <!-- Hero Section with Banner Image -->
    <section class="hero">
        <img src="pics/banner.jpg.jpeg" alt="Banner Image" class="hero-img">
        <div class="hero-text">
            <h1>Your Glow, Our Care – Discover Skincare That Loves You Back</h1>
        </div>
    </section>
    

    <!-- Featured Products Section -->
<section class="featured-products">
    <div class="container">
      <h2 class="section-title">Featured Products</h2>
      <div class="product-grid">
        <!-- Product Card 1 -->
        <div class="product-card">
          <img src="pics/featured1.jpeg" alt="Product 1">
          <div class="product-info">
            <h5>Ordinary Face Serum</h5>
          </div>
        </div>
  
        <!-- Product Card 2 -->
        <div class="product-card">
          <img src="pics/featured2.jpeg" alt="Product 2">
          <div class="product-info">
            <h5>Beauty of Joseon Sunscreen</h5>
          </div>
        </div>
  
        <!-- Product Card 3 -->
        <div class="product-card">
          <img src="pics/featuredd3.jpeg" alt="Product 3">
          <div class="product-info">
            <h5>Cetaphil Moisturizer 3</h5>
          </div>
        </div>
      </div>
    </div>
  </section>
  
    <!-- Brand Promise Section -->
    <section class="brand-promise">
        <div class="container">
            <h2>Our Promise to You</h2>
            <p>We believe in skincare that nourishes and rejuvenates. Our products are carefully crafted with love, ensuring your skin gets the care it deserves.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            &copy; 2025 BareBelle Skincare. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>