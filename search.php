<?php
session_start();

// Check if search query is provided
if (isset($_GET['query'])) {
    $searchQuery = $_GET['query'];

    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "glowcare"; // Your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // SQL query to search for products
    $sql = "SELECT * FROM products WHERE name LIKE '%$searchQuery%' OR description LIKE '%$searchQuery%'";
    $result = $conn->query($sql);

    // Close the connection
    $conn->close();
} else {
    echo "No search query provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Search Results | BareBelle</title>
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

        .search-results {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 20px;
            padding: 40px;
        }

        .product-card {
            background-color: #fff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }

        .product-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-card h5 {
            color: #9f5f80;
            font-weight: 600;
        }

        .product-card p {
            color: #333;
            line-height: 1.6;
        }

        .product-card .price {
            font-size: 1.5rem;
            color: #9f5f80;
            font-weight: 600;
            margin-top: 20px;
        }

        .product-card .btn-custom {
            background-color: #9f5f80;
            color: white;
            border: none;
            padding: 12px 20px;
            font-size: 1.1rem;
            cursor: pointer;
            border-radius: 6px;
            transition: background-color 0.3s;
            margin-top: 10px;
        }

        .product-card .btn-custom:hover {
            background-color: #703f5d;
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
            margin-top: auto;
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
                <li class="nav-item ms-3">
                    <a class="btn" href="logout.php" style="background-color: #f8c8dc; color: black;">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="floating-icons">
    <a href="wishlist.php" title="Wishlist">
        <i class="bi bi-heart"></i>
    </a>
    <a href="cart.php" title="Shopping Cart">
        <i class="bi bi-cart3"></i>
    </a>
</div>

<!-- Search Results Section -->
<div class="container search-results">
    <?php
    if (isset($result) && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<div class="product-card">';
            echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" />';
            echo '<h5>' . $row['name'] . '</h5>';
            echo '<p>' . $row['description'] . '</p>';
            echo '<p class="price">Rs. ' . number_format($row['price'], 2) . '</p>';
            // Updated "View Product" button to a link
            echo '<a href="product.php?id=' . $row['id'] . '" class="btn-custom">View Product</a>';
            echo '</div>';
        }
    } else {
        echo "<p>No products found for '<strong>" . htmlspecialchars($searchQuery) . "</strong>'.</p>";
    }
    ?>
</div>

<!-- Footer -->
<footer>
    <p>&copy; 2025 BareBelle. All rights reserved.</p>
</footer>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
