
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

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500;700&display=swap" rel="stylesheet">

  <style>
    /* Navbar Styles */
    .navbar, .navbar * {
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
      transition: color 0.3s;
    }

    .navbar-nav .nav-link:hover {
      color: #f8c8dc;
    }

    /* Glowing Skin Analysis Button */
    .btn-glow {
      background: linear-gradient(90deg, #f8c8dc, #b4a8f0);
      color: #fff;
      font-weight: 600;
      border: none;
      padding: 8px 20px;
      border-radius: 8px;
      box-shadow: 0 0 12px rgba(180, 168, 240, 0.6);
      animation: glowPulse 2s infinite;
      transition: transform 0.3s ease;
    }

    .btn-glow:hover {
      transform: scale(1.05);
      box-shadow: 0 0 18px rgba(180, 168, 240, 0.8);
    }

    @keyframes glowPulse {
      0% { box-shadow: 0 0 10px rgba(180, 168, 240, 0.6); }
      50% { box-shadow: 0 0 20px rgba(248, 200, 220, 0.9); }
      100% { box-shadow: 0 0 10px rgba(180, 168, 240, 0.6); }
    }

    /* Login / Logout Buttons */
    .btn-login, .btn-logout {
      background-color: #f8c8dc;
      color: black;
      font-weight: 600;
      border: none;
      padding: 8px 18px;
      border-radius: 6px;
      transition: all 0.3s ease;
    }

    .btn-login:hover, .btn-logout:hover {
      background-color: #b4a8f0ff;
      color: white;
    }

    /* Collapsible Search */
    .search-container {
      position: relative;
    }

    .search-input {
      width: 0;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
    }

    .search-container.active .search-input {
      width: 180px;
      opacity: 1;
      visibility: visible;
    }

    .search-btn {
      background-color: transparent;
      border: none;
      color: #333;
      font-size: 1.2rem;
      cursor: pointer;
    }

    @media (max-width: 991px) {
      .navbar-nav {
        text-align: center;
      }
      .navbar-nav .nav-item {
        margin-bottom: 10px;
      }
      .search-container {
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
        <form class="d-flex me-3 search-container" action="search.php" method="GET" id="searchForm">
          <input class="form-control me-2 search-input" type="search" name="query" placeholder="Search..." aria-label="Search">
          <button class="search-btn" type="button" id="searchToggle">
            <i class="bi bi-search"></i>
          </button>
        </form>

        <!-- Navigation Links -->
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="productscategories.php">Products</a></li>

          <!-- ✨ Glowing Button -->
          <li class="nav-item ms-2">
            <a href="diagnosis.php" class="btn btn-glow">Skin Analysis</a>
          </li>

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

  <!-- Search Toggle Script -->
  <script>
    const searchToggle = document.getElementById('searchToggle');
    const searchForm = document.getElementById('searchForm');

    searchToggle.addEventListener('click', () => {
      searchForm.classList.toggle('active');
      const input = searchForm.querySelector('.search-input');
      if (searchForm.classList.contains('active')) {
        input.focus();
      } else {
        input.blur();
      }
    });
  </script>
</body>
</html>
