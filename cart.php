<?php
session_start(); // Start the session

// Simple debug function
function debug_log($message, $level = 'INFO') {
    // You can customize this to log to file if needed
    return;
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit(); // Ensure no further code is executed
}

// Include database connection
include 'db_connect.php';

// Get user ID
$user_id = $_SESSION['user_id'];

// Get cart items - Make sure column names match your DB schema
$cart_query = mysqli_query($conn, "SELECT c.id, c.quantity, p.id as product_id, p.name, p.price, p.image 
                                    FROM cart c 
                                    JOIN products p ON c.product_id = p.id 
                                    WHERE c.user_id = '$user_id'");

// Check if query was successful
if (!$cart_query) {
    // Display error for debugging (remove in production)
    $error_message = "Database Error: " . mysqli_error($conn);
    $cart_items = [];
    $total = 0;
    $is_cart_empty = true;
} else {
    // Calculate total
    $total = 0;
    $cart_items = [];

    while ($item = mysqli_fetch_assoc($cart_query)) {
        $cart_items[] = $item;
        $total += $item['price'] * $item['quantity'];
    }

    // Check if cart is empty
    $is_cart_empty = (count($cart_items) == 0);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Cart | GlowCare </title>

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet"/>
  
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
    
    .alert {
      position: fixed;
      top: 90px;
      right: 20px;
      max-width: 300px;
      z-index: 1050;
      display: none;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">GlowCare</a>
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
        <li class="nav-item"><a class="nav-link" href="productscategories.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container mt-4">
  <!-- Error message if any -->
  <?php if(isset($error_message)): ?>
  <div class="alert alert-danger" role="alert">
    <?php echo $error_message; ?>
  </div>
  <?php endif; ?>

  <!-- Alert for notifications -->
  <div class="alert alert-success" id="cartAlert" role="alert" style="display: none;"></div>

  <?php if(!$is_cart_empty): ?>
  <div id="cartContainer">
    <h2 class="cart-title"><i class="bi bi-bag-heart-fill"></i> Your Shopping Cart</h2>

    <?php foreach($cart_items as $item): ?>
    <!-- Cart Item -->
    <div class="cart-card d-flex align-items-center" id="item-<?php echo $item['product_id']; ?>">
      <!-- Use image if available, or use a placeholder -->
      <?php if(!empty($item['image'])): ?>
        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" class="cart-img me-4">
      <?php else: ?>
        <img src="product_images/placeholder.jpg" alt="Product Image" class="cart-img me-4">
      <?php endif; ?>
      
      <div class="flex-grow-1">
        <h5 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h5>
        <p class="mb-1">Price: Rs. <?php echo number_format($item['price'], 2); ?></p>
        <div class="d-flex align-items-center gap-2">
          <label for="qty<?php echo $item['product_id']; ?>" class="mb-0">Qty:</label>
          <input type="number" id="qty<?php echo $item['product_id']; ?>" class="quantity-input" 
                 value="<?php echo $item['quantity']; ?>" min="1" 
                 data-product-id="<?php echo $item['product_id']; ?>"
                 onchange="updateQuantity(<?php echo $item['product_id']; ?>, this.value)">
        </div>
      </div>
      <div class="text-end">
        <p class="fw-bold mb-2">Subtotal: Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></p>
        <button class="remove-btn" title="Remove" onclick="removeFromCart(<?php echo $item['product_id']; ?>)">
          <i class="bi bi-trash"></i>
        </button>
      </div>
    </div>
    <?php endforeach; ?>

    <!-- Total + Checkout -->
    <div class="total-section">
      Total: Rs. <span id="cartTotal"><?php echo number_format($total, 2); ?></span>
      <br>
      <button class="checkout-btn mt-3" onclick="location.href='place_order.php'">Proceed to Checkout</button>
    </div>
  </div>
  <?php else: ?>
  <!-- Empty Cart Message -->
  <div id="emptyCart" class="empty-cart">
    <h3>Your cart is empty.</h3>
    <a href="products.php" class="btn">Shop Products</a>
  </div>
  <?php endif; ?>

</div>

<!-- Bootstrap JS + Icons -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Floating Cart & Wishlist Icons -->
<div class="floating-icons">
  <a href="wishlist.php" title="Wishlist">
    <i class="bi bi-heart"></i>
  </a>
  <a href="cart.php" title="Shopping Cart">
    <i class="bi bi-cart3"></i>
  </a>
</div>

<footer>
  <div class="container">
    &copy; 2025 GlowCare Skincare. All rights reserved.
  </div>
</footer>

<script>
// Function to show alert message
function showAlert(message, type = 'success') {
  const alert = document.getElementById('cartAlert');
  if (alert) {
    alert.textContent = message;
    alert.className = `alert alert-${type}`;
    alert.style.display = 'block';
    
    // Hide after 3 seconds
    setTimeout(() => {
      alert.style.display = 'none';
    }, 3000);
  } else {
    console.error('Alert element not found');
  }
}

// Function to update item quantity
function updateQuantity(productId, quantity) {
  const formData = new FormData();
  formData.append('product_id', productId);
  formData.append('quantity', quantity);
  
  fetch('cart_actions.php?action=update', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    if (data === 'updated') {
      // Recalculate subtotal and total
      updateCartTotals();
      showAlert('Cart updated successfully');
    } else {
      showAlert('Failed to update cart', 'danger');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showAlert('An error occurred', 'danger');
  });
}

// Function to remove item from cart
function removeFromCart(productId) {
  const formData = new FormData();
  formData.append('product_id', productId);
  
  fetch('cart_actions.php?action=remove', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    if (data === 'removed') {
      // Remove item from DOM
      const itemElement = document.getElementById(`item-${productId}`);
      if (itemElement) {
        itemElement.remove();
      }
      
      // Recalculate total
      updateCartTotals();
      
      // Check if cart is now empty
      const cartItems = document.querySelectorAll('.cart-card');
      if (cartItems.length === 0) {
        const cartContainer = document.getElementById('cartContainer');
        const emptyCart = document.getElementById('emptyCart');
        
        // Only access style if elements exist
        if (cartContainer) {
          cartContainer.style.display = 'none';
        }
        
        if (emptyCart) {
          emptyCart.style.display = 'block';
        } else {
          // If emptyCart element doesn't exist, we need to create one
          createEmptyCartMessage();
        }
      }
      
      showAlert('Item removed from cart');
    } else {
      showAlert('Failed to remove item', 'danger');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showAlert('An error occurred', 'danger');
  });
}

// Function to update cart totals
function updateCartTotals() {
  let total = 0;
  const cartItems = document.querySelectorAll('.cart-card');
  const cartTotalElement = document.getElementById('cartTotal');
  
  if (!cartTotalElement) {
    console.error('Cart total element not found');
    return;
  }
  
  cartItems.forEach(item => {
    const productId = item.id.replace('item-', '');
    const priceElement = item.querySelector('p.mb-1');
    const quantityElement = document.getElementById(`qty${productId}`);
    const subtotalElement = item.querySelector('.fw-bold');
    
    if (priceElement && quantityElement && subtotalElement) {
      const price = parseFloat(priceElement.textContent.replace('Price: Rs. ', '').replace(',', ''));
      const quantity = parseInt(quantityElement.value);
      const subtotal = price * quantity;
      
      // Update subtotal display
      subtotalElement.textContent = `Subtotal: Rs. ${subtotal.toFixed(2)}`;
      
      total += subtotal;
    }
  });
  
  // Update total display
  cartTotalElement.textContent = total.toFixed(2);
}

// Function to create empty cart message if it doesn't exist
function createEmptyCartMessage() {
  const container = document.querySelector('.container.mt-4');
  if (container) {
    // Remove existing cart container if it exists
    const cartContainer = document.getElementById('cartContainer');
    if (cartContainer) {
      cartContainer.remove();
    }
    
    // Create empty cart message
    const emptyCart = document.createElement('div');
    emptyCart.id = 'emptyCart';
    emptyCart.className = 'empty-cart';
    emptyCart.innerHTML = `
      <h3>Your cart is empty.</h3>
      <a href="products.php" class="btn">Shop Products</a>
    `;
    
    // Add to container
    container.appendChild(emptyCart);
  }
}

// Add to cart function (for product pages)
function addToCart(productId) {
  const formData = new FormData();
  formData.append('product_id', productId);
  
  fetch('cart_actions.php?action=add', {
    method: 'POST',
    body: formData
  })
  .then(response => response.text())
  .then(data => {
    if (data === 'added') {
      showAlert('Item added to cart');
    } else if (data === 'already_in_cart') {
      showAlert('Item is already in your cart', 'info');
    } else {
      showAlert('Failed to add item to cart', 'danger');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    showAlert('An error occurred', 'danger');
  });
}

// Initialize page
document.addEventListener('DOMContentLoaded', function() {
  console.log('Cart page loaded');
});
</script>
</body>
</html>