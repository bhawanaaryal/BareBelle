<?php
session_start(); // Start the session
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare";

// Simple debug function that doesn't require an external file
function debug_log($message, $level = 'INFO') {
    // You can customize this function to log to a file if needed
    // For now, we'll just return so the page works without errors
    return;
}

debug_log("Category page loaded");

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  debug_log("Database connection failed: " . $conn->connect_error, "ERROR");
  die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$products = [];

debug_log("Browsing category: " . ($category ? $category : "none"));

if (!empty($category)) {
  $stmt = $conn->prepare("SELECT id, name, image, price FROM products WHERE category = ?");
  $stmt->bind_param("s", $category);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }
  
  debug_log("Found " . count($products) . " products in category: $category");

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

.alert {
    position: fixed;
    top: 90px;
    right: 20px;
    max-width: 300px;
    z-index: 1050;
    display: none;
}

/* Debug Console Styles */
#debugConsole {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #f8f9fa;
    border-top: 1px solid #dee2e6;
    padding: 10px;
    font-family: monospace;
    font-size: 12px;
    display: none;
    max-height: 200px;
    overflow-y: auto;
    z-index: 2000;
}

.debug-btn {
    position: fixed;
    bottom: 20px;
    left: 20px;
    z-index: 2001;
    opacity: 0.7;
}

.debug-entry {
    margin-bottom: 4px;
    padding: 2px 0;
    border-bottom: 1px dotted #ccc;
}

.debug-time {
    color: #777;
    margin-right: 8px;
}

.debug-type {
    display: inline-block;
    padding: 1px 5px;
    border-radius: 3px;
    margin-right: 8px;
    font-weight: bold;
}

.debug-type-info {
    background-color: #d1ecf1;
    color: #0c5460;
}

.debug-type-warning {
    background-color: #fff3cd;
    color: #856404;
}

.debug-type-error {
    background-color: #f8d7da;
    color: #721c24;
}

.debug-msg {
    color: #333;
}
  </style>
</head>
<body>
    <!-- Debug Console -->
    <button class="btn btn-sm btn-secondary debug-btn" onclick="toggleDebugConsole()">Debug</button>
    <div id="debugConsole">
        <h6>Debug Console</h6>
        <div id="debugOutput"></div>
    </div>
    
    <!-- Alert for notifications -->
    <div class="alert" id="productAlert" role="alert" style="display: none;"></div>
    
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

<!-- This should be placed outside of the product grid -->
<div class="floating-icons">
    <a href="wishlist.php" title="Wishlist">
        <i class="bi bi-heart"></i>
    </a>
    <a href="cart.php" title="Shopping Cart">
        <i class="bi bi-cart3"></i>
    </a>
</div>

<div class="container">
    <h2><?php echo ucfirst($category); ?></h2>
    <div class="product-grid">
      <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
          <div class="product-card">
            <a href="product.php?id=<?php echo $product['id']; ?>"> <!-- Link to individual product page -->
              <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" />
              <h5><?php echo $product['name']; ?></h5>
              <p class="price">Rs. <?php echo $product['price']; ?></p>
              <div class="icons">
                <i class="bi bi-cart-plus-fill" title="Add to Cart" onclick="addToCart(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>')"></i>
                <i class="bi bi-heart-fill" title="Add to Wishlist" onclick="addToWishlist(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>')"></i>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;">No products found in this category.</p>
      <?php endif; ?>
    </div>
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
            &copy; 2025 BareBelle Skincare. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Function to show alert message
        function showAlert(message, type = 'success') {
            const alert = document.getElementById('productAlert');
            alert.textContent = message;
            alert.className = `alert alert-${type}`;
            alert.style.display = 'block';
            
            // Log to debug console
            logDebug(`Alert: ${message} (${type})`);
            
            // Hide after 3 seconds
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }
        
        // Debug functions
        function logDebug(message, type = 'INFO') {
            const output = document.getElementById('debugOutput');
            const timestamp = new Date().toLocaleTimeString();
            
            // Create debug entry with styling
            const entryDiv = document.createElement('div');
            entryDiv.className = 'debug-entry';
            
            const timeSpan = document.createElement('span');
            timeSpan.className = 'debug-time';
            timeSpan.textContent = timestamp;
            
            const typeSpan = document.createElement('span');
            typeSpan.className = `debug-type debug-type-${type.toLowerCase()}`;
            typeSpan.textContent = type;
            
            const msgSpan = document.createElement('span');
            msgSpan.className = 'debug-msg';
            msgSpan.textContent = message;
            
            entryDiv.appendChild(timeSpan);
            entryDiv.appendChild(typeSpan);
            entryDiv.appendChild(msgSpan);
            
            output.appendChild(entryDiv);
            
            // Auto-scroll to bottom
            output.scrollTop = output.scrollHeight;
            
            // Also log to browser console for developers
            console.log(`[${timestamp}] [${type}] ${message}`);
        }
        
        function toggleDebugConsole() {
            const console = document.getElementById('debugConsole');
            console.style.display = console.style.display === 'none' ? 'block' : 'none';
        }
        
        // Function to add to cart
        function addToCart(productId, productName) {
            logDebug(`Adding product to cart: ${productName} (ID: ${productId})`);
            
            // Check if user is logged in
            <?php if(!isset($_SESSION['user_id'])): ?>
                logDebug("User not logged in. Redirecting to login page.", "WARNING");
                window.location.href = 'login.php';
                return;
            <?php endif; ?>
            
            // Create form data
            const formData = new FormData();
            formData.append('product_id', productId);
            
            // Send AJAX request
            logDebug(`Sending request to cart_actions.php?action=add for product ID: ${productId}`);
            
            fetch('cart_actions.php?action=add', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                logDebug(`Received response with status: ${response.status}`);
                return response.text();
            })
            .then(data => {
                logDebug(`Server response: "${data}"`);
                
                if (data === 'added') {
                    showAlert(`${productName} added to cart successfully`);
                } else if (data === 'already_in_cart') {
                    showAlert(`${productName} is already in your cart`, 'info');
                } else if (data === 'not_logged_in') {
                    logDebug("Session expired or user logged out", "WARNING");
                    window.location.href = 'login.php';
                } else {
                    logDebug(`Failed to add to cart: ${data}`, "ERROR");
                    showAlert(`Failed to add ${productName} to cart: ${data}`, 'danger');
                }
            })
            .catch(error => {
                logDebug(`Error occurred: ${error}`, "ERROR");
                console.error('Error:', error);
                showAlert(`An error occurred: ${error}`, 'danger');
            });
        }
        
        // Function to add to wishlist
        function addToWishlist(productId, productName) {
            logDebug(`Adding product to wishlist: ${productName} (ID: ${productId})`);
            
            // Check if user is logged in
            <?php if(!isset($_SESSION['user_id'])): ?>
                logDebug("User not logged in. Redirecting to login page.", "WARNING");
                window.location.href = 'login.php';
                return;
            <?php endif; ?>
            
            // Create form data
            const formData = new FormData();
            formData.append('product_id', productId);
            
            // Send AJAX request
            logDebug(`Sending request to wishlist_actions.php?action=add for product ID: ${productId}`);
            
            fetch('wishlist_actions.php?action=add', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                logDebug(`Received response with status: ${response.status}`);
                return response.text();
            })
            .then(data => {
                logDebug(`Server response: "${data}"`);
                
                if (data === 'added') {
                    showAlert(`${productName} added to wishlist successfully`);
                } else if (data === 'already_in_wishlist') {
                    showAlert(`${productName} is already in your wishlist`, 'info');
                } else if (data === 'not_logged_in') {
                    logDebug("Session expired or user logged out", "WARNING");
                    window.location.href = 'login.php';
                } else {
                    logDebug(`Failed to add to wishlist: ${data}`, "ERROR");
                    showAlert(`Failed to add ${productName} to wishlist: ${data}`, 'danger');
                }
            })
            .catch(error => {
                logDebug(`Error occurred: ${error}`, "ERROR");
                console.error('Error:', error);
                showAlert(`An error occurred: ${error}`, 'danger');
            });
        }
        
        // Initialize debug console when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            logDebug("Page loaded successfully");
            logDebug("User login status: <?php echo isset($_SESSION['user_id']) ? 'Logged in (ID: '.$_SESSION['user_id'].')' : 'Not logged in'; ?>");
            logDebug("Category: <?php echo $category ? $category : 'None selected'; ?>");
            logDebug("Products loaded: <?php echo count($products); ?>");
        });
    </script>
</body>
</html>