<?php
session_start();

// Ensure product ID is passed via URL
if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$productId = $_GET['id'];

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch product details
$stmt = $conn->prepare("SELECT name, description, image, price FROM products WHERE id = ?");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
} else {
    echo "Product not found.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?php echo $product['name']; ?> | BareBelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
    <style>
        html, body {
            height: 100%;
            margin: 0;
            font-family: 'Quicksand', sans-serif;
        }

        body {
            background: #f4f4f4;
            display: flex;
            flex-direction: column;
            padding-top: 60px;
        }

        .product-container {
            display: flex;
            justify-content: center;
            gap: 40px;
            padding: 40px;
            flex: 1; /* Allow content to grow and push footer down */
        }

        .product-img {
            max-width: 400px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .product-details {
            max-width: 500px;
        }

        .product-details h2 {
            color: #9f5f80;
            font-weight: 600;
        }

        .product-details p {
            color: #333;
            line-height: 1.6;
        }

        .product-details .price {
            font-size: 1.5rem;
            color: #9f5f80;
            font-weight: 600;
            margin-top: 20px;
        }

        .product-details .buttons {
            margin-top: 30px;
        }

        .btn-custom {
            background-color: #9f5f80;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1.1rem;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.3s;
        }

        .btn-custom:hover {
            background-color: #703f5d;
        }

        footer {
            background-color: #f0f0f0;
            padding: 15px 0;
            text-align: center;
            color: #555;
            font-size: 0.95rem;
            margin-top: auto; /* Push footer to the bottom */
        }
    </style>
</head>
<body>

    <!-- Product Details Section -->
    <div class="container product-container">
        <div>
            <!-- Product Image -->
            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="product-img" />
        </div>
        <div class="product-details">
            <!-- Product Name -->
            <h2><?php echo $product['name']; ?></h2>

            <!-- Product Description -->
            <p><?php echo $product['description']; ?></p>

            <!-- Product Price -->
            <p class="price">Rs.<?php echo $product['price']; ?></p>

            <!-- Buttons for Cart and Wishlist -->
            <div class="buttons">
                <button class="btn-custom add-to-cart" data-id="<?php echo $productId; ?>">Add to Cart</button>
                <button class="btn-custom add-to-wishlist" data-id="<?php echo $productId; ?>">Add to Wishlist</button>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 BareBelle. All rights reserved.</p>
    </footer>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function(){
            // Add to Cart
            $('.add-to-cart').click(function(){
                const productId = $(this).data('id');
                $.ajax({
                    url: 'add_to_cart.php',
                    method: 'POST',
                    data: { id: productId },
                    success: function(response) {
                        alert(response); // Display success/failure message
                    },
                    error: function() {
                        alert("An error occurred while adding to cart.");
                    }
                });
            });

            // Add to Wishlist
            $('.add-to-wishlist').click(function(){
                const productId = $(this).data('id');
                $.ajax({
                    url: 'add_to_wishlist.php',
                    method: 'POST',
                    data: { id: productId },
                    success: function(response) {
                        alert(response); // Display success/failure message
                    },
                    error: function() {
                        alert("An error occurred while adding to wishlist.");
                    }
                });
            });
        });
    </script>
</body>
</html>
