<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
  echo "Please login first.";
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];

  // Get product details
  $stmt = $conn->prepare("SELECT id, price FROM products WHERE name = ?");
  $stmt->bind_param("s", $name);
  $stmt->execute();
  $result = $stmt->get_result();
  
  if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    $user_id = $_SESSION['user_id'];
    $product_id = $product['id'];
    $price = $product['price'];

    // Insert into cart table (create if not exists!)
    $insert = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity, price) VALUES (?, ?, 1, ?)");
    $insert->bind_param("iid", $user_id, $product_id, $price);
    $insert->execute();

    echo "Product added to cart!";
  } else {
    echo "Product not found.";
  }
}
?>
