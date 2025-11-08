<?php
// Start session if needed
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Redirect to login page or show an error message
    header("Location: login.php");
    exit();
}
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $skin_issue = $_POST['skin_issue'];

    // Handle image upload
    $image = $_FILES['image']['name'];
    $temp_image = $_FILES['image']['tmp_name'];
    $upload_dir = "product_images/";

    // Make sure the folder exists
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $image_path = $upload_dir . basename($image);

    if (move_uploaded_file($temp_image, $image_path)) {
        // Insert into database
        $sql = "INSERT INTO products (name, description, price, quantity, category, skin_issue, image)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssdisss", $name, $description, $price, $quantity, $category, $skin_issue, $image_path);

        if ($stmt->execute()) {
            echo "<script>alert('Product added successfully!'); window.location.href='add_product.php';</script>";
        } else {
            echo "<script>alert('Failed to add product.');</script>";
        }

        $stmt->close();
    } else {
        echo "<script>alert('Image upload failed. Please try again.');</script>";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            min-height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 60px auto;
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #9f5f80;
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-custom {
            background-color: #9f5f80;
            color: white;
            font-weight: 500;
        }

        .btn-custom:hover {
            background-color: #7c3b5b;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">BareBelle Admin</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="adminNavbar">
      <ul class="navbar-nav align-items-center">
        <li class="nav-item"><a class="nav-link" href="add_product.php">Add Product</a></li>
        <li class="nav-item"><a class="nav-link" href="manage_products.php">Manage Products</a></li>
        <li class="nav-item"><a class="nav-link" href="view_order.php">Manage Orders</a></li>
        <li class="nav-item"><a class="nav-link" href="user_list.php">Manage Customers</a></li>

        <!-- Logout Button -->
        <li class="nav-item ms-3">
          <a class="btn" href="logout.php" style="background-color: #f8c8dc; color: black;">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>


    <!-- Add Product Form -->
    <div class="container form-container">
        <div class="form-title">Add New Product</div>

        <form action="add_product.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control" required></textarea>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Price (NPR)</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <option value="serum">Serum</option>
                    <option value="moisturizer">Moisturizer</option>
                    <option value="sunscreen">Sunscreen</option>
                    <option value="facewash">Facewash</option>
                    <option value="facemask">Facemask</option>
                    <option value="cleanser">Cleanser</option>
                    <option value="toner">Toner</option>
                    <option value="eyecream">Eye Cream/Serum</option>
                </select>
            </div>

                <div class="mb-3">
                <label class="form-label">Skin Issue</label>
                <select name="skin_issue" class="form-select" required>
                    <option value="">-- Select Issue --</option>
                    <option value="acne">Acne</option>
                    <option value="black heads">Black heads</option>
                    <option value="dark circles">Dark Circles</option>
                    <option value="rosacea">Rosacea</option>
                    <option value="normal">normal</option>
                </select>
                </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-custom px-5">Add Product</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include 'footer.php'; ?>
</body>
</html>
