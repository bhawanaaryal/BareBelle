<?php
session_start();

// Connect to the database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $address = $_POST["address"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.'); window.location.href = 'register.php';</script>";
        exit();
    }

    // Check if email already exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already taken.'); window.location.href = 'register.php';</script>";
        exit();
    }

    // Validate password strength
    if (strlen($password) < 8) {
        echo "<script>alert('Password must be at least 8 characters long.'); window.location.href = 'register.php';</script>";
        exit();
    }
    if (!preg_match("/[A-Z]/", $password)) {
        echo "<script>alert('Password must contain at least one uppercase letter.'); window.location.href = 'register.php';</script>";
        exit();
    }
    if (!preg_match("/[0-9]/", $password)) {
        echo "<script>alert('Password must contain at least one number.'); window.location.href = 'register.php';</script>";
        exit();
    }
    if (!preg_match("/[\W]/", $password)) {
        echo "<script>alert('Password must contain at least one special character.'); window.location.href = 'register.php';</script>";
        exit();
    }

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user data into the database
    $sql = "INSERT INTO users (name, address, phone, email, password) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $address, $phone, $email, $hashedPassword);

    if ($stmt->execute()) {
        // Redirect to login page after successful registration
        echo "<script>alert('Registration successful. Redirecting to login...'); window.location.href = 'login.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = 'register.php';</script>";
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
  <title>BareBelle Registration</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Google Fonts (Optional) -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
  
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #c3cfea, #f8c8dc);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
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

    .form-container {
      max-width: 500px;
      background-color: #ffffff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      margin: 100px auto 30px;
    }

    .form-heading {
      font-weight: 600;
      color: #9f5f80;
      margin-bottom: 20px;
    }

    .login-link {
      text-align: center;
      margin-top: 15px;
      font-size: 0.95rem;
    }

    .login-link a {
      color: #9f5f80;
      text-decoration: none;
    }

    .login-link a:hover {
      text-decoration: underline;
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
  <nav class="navbar navbar-expand-lg shadow-sm fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">BareBelle</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
          <li class="nav-item"><a class="nav-link active" href="register.php">Register</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Registration Form -->
  <div class="container form-container">
    <h2 class="form-heading text-center">Create Your BareBelle Account</h2>
    <form action="#" method="post">
      <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" class="form-control" id="name" name="name" required />
      </div>
      <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address" required />
      </div>
      <div class="mb-3">
        <label for="phone" class="form-label">Phone Number</label>
        <input type="tel" class="form-control" id="phone" name="phone" required />
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" class="form-control" id="email" name="email" required />
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Create Password</label>
        <input type="password" class="form-control" id="password" name="password" required />
      </div>
      <div class="d-grid">
        <button type="submit" class="btn btn-primary" style="background-color: #9f5f80; border: none;">Register</button>
      </div>
      <div class="login-link">
        Already have an account? <a href="login.php">Login here</a>
      </div>
    </form>
  </div>

  <!-- Footer -->
  <footer>
    <div class="container">
      &copy; 2025 BareBelle Skincare. All rights reserved.
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
