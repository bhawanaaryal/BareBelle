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
</head>
<body>
 
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">GlowCare</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                    <li class="nav-item"><a class="nav-link" href="productscategories.php">Products</a></li>
                    <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Banner Image -->
    <section class="hero">
        <img src="banner.jpg.jpeg" alt="Banner Image" class="hero-img">
        <div class="hero-text">
            <h1>Your Glow, Our Care – Discover Skincare That Loves You Back</h1>
        </div>
    </section>
    

    <!-- Featured Products Section -->
    <section class="featured-products">
        <div class="container">
            <h2>Featured Products</h2>
            <!-- Add your featured products here -->
            <div class="row">
                <!-- Example of product card -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="product1.jpg" class="card-img-top" alt="Product 1">
                        <div class="card-body">
                            <h5 class="card-title">Product 1</h5>
                            <p class="card-text">A brief description of the product.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="product2.jpg" class="card-img-top" alt="Product 2">
                        <div class="card-body">
                            <h5 class="card-title">Product 2</h5>
                            <p class="card-text">A brief description of the product.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="product3.jpg" class="card-img-top" alt="Product 3">
                        <div class="card-body">
                            <h5 class="card-title">Product 3</h5>
                            <p class="card-text">A brief description of the product.</p>
                        </div>
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
            &copy; 2025 GlowCare Skincare. All rights reserved.
        </div>
    </footer>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>