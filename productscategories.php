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
      color: #7a4c5c; /* updated to a more elegant, muted tone */
      background-color: #fbeff3;
    }

    @media (max-width: 768px) {
      .category-box img {
        height: 160px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.html">BareBelle</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.html">About</a></li>
          <li class="nav-item"><a class="nav-link active" href="productscategories.php">Products</a></li>
          <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
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
            <img src="mosturizer.jpeg" alt="Moisturizer">
            <p>Moisturizer</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=serum">
            <img src="serum.jpeg" alt="Serums">
            <p>Serums</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=sunscreen">
            <img src="sunscreen.jpeg" alt="Sunscreens">
            <p>Sunscreens</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=facemask">
            <img src="facemask.jpeg" alt="Face Mask">
            <p>Face Mask</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=toner">
            <img src="toner.jpeg" alt="Toner">
            <p>Toner</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=facewash">
            <img src="face wash.jpeg" alt="Face Wash">
            <p>Face Wash</p>
          </a>
        </div>
        <div class="category-box">
          <a href="products.php?category=cleanser">
            <img src="cleanser.jpeg" alt="Cleanser">
            <p>Cleanser</p>
          </a>
        </div>
      </div>
    </div>
  </section>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
