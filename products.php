<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare"; // still using glowcare unless you've changed the DB name too

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$products = [];

if (!empty($category)) {
  $stmt = $conn->prepare("SELECT name, image, price FROM products WHERE category = ?");
  $stmt->bind_param("s", $category);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo ucfirst($category); ?> | BareBelle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #fff0f3, #e4d3dc);
      padding-top: 90px;
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
    h2 {
      text-align: center;
      color: #9f5f80;
      margin-bottom: 40px;
      font-weight: 600;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .product-card {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      overflow: hidden;
      text-align: center;
      padding: 20px;
      transition: transform 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-8px);
    }

    .product-card img {
      height: 220px;
      width: 100%;
      object-fit: cover;
      border-radius: 12px;
    }

    .product-card h5 {
      margin-top: 15px;
      color: #333;
      font-weight: 600;
    }

    .product-card .price {
      color: #9f5f80;
      font-size: 1.1rem;
      margin-bottom: 10px;
    }

    .icons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .icons i {
      cursor: pointer;
      font-size: 1.2rem;
      color: #9f5f80;
      transition: color 0.3s;
    }

    .icons i:hover {
      color: #703f5d;
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
TODO: Be ablle to add the products to cart and wishlist later on so that i can fetch later to display it on the pages and modals.

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

      <div class="container">
    <h2><?php echo ucfirst($category); ?></h2>
    <div class="product-grid">
      <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
          <div class="product-card">
          <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" />
          <h5><?php echo $product['name']; ?></h5>
            <p class="price">Rs. <?php echo $product['price']; ?></p>
            <div class="icons">
                    <i class="bi bi-cart add-to-cart" data-name="<?php echo $product['name']; ?>"></i>
                    <i class="bi bi-heart add-to-wishlist" data-name="<?php echo $product['name']; ?>"></i>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;">No products found in this category.</p>
      <?php endif; ?>
    </div>
  </div>
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

      <!-- Footer -->
      <footer>
        <div class="container">
            &copy; 2025 GlowCare Skincare. All rights reserved.
        </div>
    </footer>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
  // Add to Cart
  $('.add-to-cart').click(function(){
    const productName = $(this).data('name');
    $.ajax({
      url: 'add_to_cart.php',
      method: 'POST',
      data: { name: productName },
      success: function(response) {
        alert(response);
      }
    });
  });

  // Add to Wishlist
  $('.add-to-wishlist').click(function(){
    const productName = $(this).data('name');
    $.ajax({
      url: 'add_to_wishlist.php',
      method: 'POST',
      data: { name: productName },
      success: function(response) {
        alert(response);
      }
    });
  });
});
</script>


</body>
</html>
