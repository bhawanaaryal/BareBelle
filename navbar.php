<?php
// ✅ Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>BareBelle</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    /* Navbar Styles */

    .navbar, 
    .navbar * {
    font-family: 'Quicksand', sans-serif !important;
    }

    .navbar {
      background-color: #c3cfea;
      padding: 15px 0;
    }

    .navbar-brand {
      font-weight: 700;
      color: #9f5f80;
    }

    .navbar-nav .nav-link {
      color: #333;
      font-weight: 500;
      padding: 10px 15px;
    }

    .navbar-nav .nav-link:hover {
      color: #f8c8dc;
    }

    .btn-login,
    .btn-logout {
      background-color: #f8c8dc;
      color: black;
      font-weight: 600;
      border: none;
      padding: 8px 18px;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .btn-login:hover,
    .btn-logout:hover {
      background-color: #b4a8f0ff;
      color: white;
    }

    /* Make navbar content fit nicely on smaller screens */
    @media (max-width: 991px) {
      .navbar-nav {
        text-align: center;
      }
      .navbar-nav .nav-item {
        margin-bottom: 10px;
      }
      form.d-flex {
        justify-content: center;
        margin-bottom: 10px;
      }
    }
  </style>
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light shadow fixed-top">
    <div class="container">
      <a class="navbar-brand" href="home.php">BareBelle</a>

      <!-- Mobile toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <!-- Search Form -->
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

          <!-- Login / Logout Conditional -->
          <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <li class="nav-item ms-3">
              <a class="btn btn-logout" href="logout.php">Logout</a>
            </li>
          <?php else: ?>
            <li class="nav-item ms-3">
              <a class="btn btn-login" href="login.php">Login</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
