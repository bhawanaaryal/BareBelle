<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Product Categories | BareBelle Skincare</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet"/>

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: #fffafc;
      padding-top: 80px;
    }

    .navbar {
      background-color: #c3cfea;
    }

    .navbar-brand {
      font-weight: 700;
      color: #9f5f80;
    }

    .nav-link {
      font-weight: 500;
      color: #333;
    }

    .nav-link:hover {
      color: #f8c8dc;
    }

    .categories {
      padding: 60px 20px;
    }

    .categories h2 {
      text-align: center;
      color: #9f5f80;
      margin-bottom: 40px;
      font-weight: 600;
    }

    .category-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
      gap: 30px;
    }

    .category-box {
      background-color: #fff;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .category-box:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
    }

    .category-box img {
      width: 100%;
      height: 180px;
      object-fit: cover;
    }

    .category-box p {
      margin: 0;
      padding: 12px 0;
      font-weight: 600;
      color: #7a4c5c; /* updated  a more elegant, muted tone */
      background-color: #fbeff3;
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

    @media (max-width: 768px) {
      .category-box img {
        height: 160px;
      }
    }
  </style>
</head>
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
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="productscategories.html">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

  <!-- Categories Section -->
  <section class="categories">
    <div class="container">
      <h2>Product Categories</h2>
      <div class="category-grid">
        <div class="category-box">
          <a href="products.php?category=moisturizer">
            <img src="pics/mosturizer.jpeg" alt="Moisturizer">
            <p>Moisturizer</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=serum">
            <img src="pics/serum.jpeg" alt="Serums">
            <p>Serums</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=sunscreen">
            <img src="pics/sunscreen.jpeg" alt="Sunscreens">
            <p>Sunscreens</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=facemask">
            <img src="pics/facemask.jpeg" alt="Face Mask">
            <p>Face Mask</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=toner">
            <img src="pics/toner.jpeg" alt="Toner">
            <p>Toner</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=facewash">
            <img src="pics/face wash.jpeg" alt="Face Wash">
            <p>Face Wash</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=cleanser">
            <img src="pics/cleanser.jpeg" alt="Cleanser">
            <p>Cleanser</p>
          </a>
        </div>
      </div>
    </div>
  </section>
  

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer>
        <div class="container">
            &copy; 2025 GlowCare Skincare. All rights reserved.
        </div>
    </footer>
</html>