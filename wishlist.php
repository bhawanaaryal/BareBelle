<?php
session_start(); // Start the session

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

// Get wishlist items
$wishlist_query = mysqli_query($conn, "SELECT w.id, w.product_id, p.name, p.price, p.image 
                                       FROM wishlist w 
                                       JOIN products p ON w.product_id = p.id 
                                       WHERE w.user_id = '$user_id'");

// Check if query was successful
if (!$wishlist_query) {
    // Display error for debugging (remove in production)
    $error_message = "Database Error: " . mysqli_error($conn);
    $wishlist_items = [];
    $is_wishlist_empty = true;
} else {
    // Get wishlist items
    $wishlist_items = [];
    while ($item = mysqli_fetch_assoc($wishlist_query)) {
        $wishlist_items[] = $item;
    }

    // Check if wishlist is empty
    $is_wishlist_empty = (count($wishlist_items) == 0);
}

// Close the database connection
$conn->close();
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
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            font-family: 'Quicksand', sans-serif;
            padding-top: 80px;
            padding-bottom: 50px;
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

        .wishlist-item-actions button {
            color: #fff;
            padding: 8px 14px;
            border-radius: 30px;
            font-size: 0.9rem;
            transition: background-color 0.3s;
            border: none;
        }

        .btn-add-to-cart {
            background-color: #9f5f80;
        }

        .btn-add-to-cart:hover {
            background-color: #865069;
        }

        .btn-remove {
            background-color: #dc3545;
        }

        .btn-remove:hover {
            background-color: #bb2d3b;
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
        
        .alert {
            position: fixed;
            top: 90px;
            right: 20px;
            max-width: 300px;
            z-index: 1050;
            display: none;
        }
        
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
    <div class="alert" id="wishlistAlert" role="alert" style="display: none;"></div>

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
                    <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="cart.php">Cart</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <!-- Display error if any -->
        <?php if(isset($error_message)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $error_message; ?>
        </div>
        <?php endif; ?>
        
        <div class="wishlist-container">
            <h2 class="wishlist-title">Your Wishlist</h2>

            <?php if(!$is_wishlist_empty): ?>
                <!-- Wishlist Items -->
                <?php foreach($wishlist_items as $item): ?>
                <div class="wishlist-item" id="wishlist-item-<?php echo $item['product_id']; ?>">
                    <?php if(!empty($item['image'])): ?>
                        <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                    <?php else: ?>
                        <img src="product_images/placeholder.jpg" alt="Product Image">
                    <?php endif; ?>
                    
                    <div class="wishlist-item-details">
                        <h5><?php echo htmlspecialchars($item['name']); ?></h5>
                        <p>Price: Rs. <?php echo number_format($item['price'], 2); ?></p>
                    </div>
                    
                    <div class="wishlist-item-actions">
                        <button class="btn-add-to-cart" onclick="addToCart(<?php echo $item['product_id']; ?>, '<?php echo addslashes($item['name']); ?>')">
                            <i class="bi bi-cart-plus"></i> Add to Cart
                        </button>
                        <button class="btn-remove" onclick="removeFromWishlist(<?php echo $item['product_id']; ?>, '<?php echo addslashes($item['name']); ?>')">
                            <i class="bi bi-trash"></i> Remove
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Empty Wishlist Message -->
                <div class="empty-wishlist-message">
                    <p>Your wishlist is empty.</p>
                    <a href="products.php" class="btn-shop-products">Shop Products</a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Floating Icons -->
    <div class="floating-icons">
        <a href="wishlist.php" title="Wishlist">
            <i class="bi bi-heart"></i>
        </a>
        <a href="cart.php" title="Shopping Cart">
            <i class="bi bi-cart3"></i>
        </a>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            &copy; 2025 Barebelle Skincare. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Debug functions
        function logDebug(message) {
            const output = document.getElementById('debugOutput');
            const timestamp = new Date().toLocaleTimeString();
            output.innerHTML += `<div>[${timestamp}] ${message}</div>`;
            output.scrollTop = output.scrollHeight;
            console.log(`[${timestamp}] ${message}`);
        }
        
        function toggleDebugConsole() {
            const console = document.getElementById('debugConsole');
            console.style.display = console.style.display === 'none' ? 'block' : 'none';
        }
        
        // Function to show alert message
        function showAlert(message, type = 'success') {
            logDebug(`Alert: ${message} (${type})`);
            const alert = document.getElementById('wishlistAlert');
            alert.textContent = message;
            alert.className = `alert alert-${type}`;
            alert.style.display = 'block';
            
            // Hide after 3 seconds
            setTimeout(() => {
                alert.style.display = 'none';
            }, 3000);
        }

        // Log that JS is loaded
        document.addEventListener('DOMContentLoaded', function() {
            logDebug('DOM fully loaded - JavaScript initialized');
            logDebug('User login status: <?php echo isset($_SESSION['user_id']) ? 'Logged in (ID: '.$_SESSION['user_id'].')' : 'Not logged in'; ?>');
        });
        
        // Function to add product to cart from wishlist
        function addToCart(productId, productName) {
            logDebug(`Adding product ID: ${productId} (${productName}) to cart`);
            
            const formData = new FormData();
            formData.append('product_id', productId);
            
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
                
                if (data.includes('added')) {
                    showAlert(`${productName} added to cart successfully`, 'success');
                } else if (data.includes('already_in_cart')) {
                    showAlert(`${productName} is already in your cart`, 'info');
                } else {
                    showAlert(`Failed to add ${productName} to cart: ${data}`, 'danger');
                }
            })
            .catch(error => {
                logDebug(`Error occurred: ${error}`);
                showAlert(`An error occurred: ${error}`, 'danger');
            });
        }
        
        // Function to remove product from wishlist
        function removeFromWishlist(productId, productName) {
            logDebug(`Removing product ID: ${productId} (${productName}) from wishlist`);
            
            const formData = new FormData();
            formData.append('product_id', productId);
            
            fetch('wishlist_actions.php?action=remove', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                logDebug(`Received response with status: ${response.status}`);
                return response.text();
            })
            .then(data => {
                logDebug(`Server response: "${data}"`);
                
                if (data === 'removed') {
                    // Remove the item from the DOM
                    const itemElement = document.getElementById(`wishlist-item-${productId}`);
                    if (itemElement) {
                        itemElement.remove();
                        
                        // Check if wishlist is now empty
                        const wishlistItems = document.querySelectorAll('.wishlist-item');
                        if (wishlistItems.length === 0) {
                            // Show empty wishlist message
                            const wishlistContainer = document.querySelector('.wishlist-container');
                            const emptyMessage = document.createElement('div');
                            emptyMessage.className = 'empty-wishlist-message';
                            emptyMessage.innerHTML = `
                                <p>Your wishlist is empty.</p>
                                <a href="products.php" class="btn-shop-products">Shop Products</a>
                            `;
                            wishlistContainer.innerHTML = '<h2 class="wishlist-title">Your Wishlist</h2>';
                            wishlistContainer.appendChild(emptyMessage);
                        }
                    }
                    
                    showAlert(`${productName} removed from wishlist`, 'success');
                } else {
                    showAlert(`Failed to remove ${productName} from wishlist: ${data}`, 'danger');
                }
            })
            .catch(error => {
                logDebug(`Error occurred: ${error}`);
                showAlert(`An error occurred: ${error}`, 'danger');
            });
        }
    </script>
</body>
</html>