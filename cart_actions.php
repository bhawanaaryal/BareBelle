<?php
session_start();
include 'connect.php'; // your DB connection file

// check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "not_logged_in";
    exit;
}

// get user ID
$user_id = $_SESSION['user_id'];

// get action
$action = $_GET['action'] ?? '';

// get product id
$product_id = intval($_POST['product_id'] ?? 0);

// simple validation
if ($product_id <= 0) {
    echo "invalid_product";
    exit;
}

if ($action == 'add') {
    // Add to cart
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
    if (mysqli_num_rows($check) > 0) {
        echo "already_in_cart";
    } else {
        mysqli_query($conn, "INSERT INTO cart (user_id, product_id, quantity) VALUES ('$user_id', '$product_id', 1)");
        echo "added";
    }
} 
elseif ($action == 'remove') {
    // Remove from cart
    mysqli_query($conn, "DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id'");
    echo "removed";
} 
elseif ($action == 'update') {
    // Update quantity
    $qty = intval($_POST['quantity'] ?? 1);
    if ($qty < 1) $qty = 1;
    mysqli_query($conn, "UPDATE cart SET quantity='$qty' WHERE user_id='$user_id' AND product_id='$product_id'");
    echo "updated";
} 
else {
    echo "invalid_action";
}
?>
