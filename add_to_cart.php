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

// Assuming user login is required
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

if ($product_id > 0) {
  // Check if product already exists in cart
  $check = $conn->prepare("SELECT id FROM cart WHERE user_id = ? AND product_id = ?");
  $check->bind_param("ii", $user_id, $product_id);
  $check->execute();
  $check->store_result();

  if ($check->num_rows > 0) {
    // If already exists, increase quantity by 1
    $update = $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    $update->bind_param("ii", $user_id, $product_id);
    $update->execute();
  } else {
    // Else, insert new record
    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->close();
  }

  $check->close();
}

// After adding to cart, redirect back
header("Location: {$_SERVER['HTTP_REFERER']}");
exit();
?>
