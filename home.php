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
          <a href="wishlist.html" class="btn btn-outline-primary">Edit Wishlist</a>
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
          <a href="cart.html" class="btn btn-outline-primary">Edit Cart</a>
        </div>
      </div>
    </div>
  </div>
</head>
<body>
 
    <!-- Navbar -->
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