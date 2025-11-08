<?php
// confirm.php
session_start();
include 'db_connect.php'; // Make sure this connects to your database

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items
$stmt = $conn->prepare("SELECT cart.*, products.name, products.price, products.image FROM cart 
    JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);

// Calculate total amount
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Fetch user details from the 'users' table
$stmt = $conn->prepare("SELECT name, email, phone, address FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user_details = $user_result->fetch_assoc();

// Handle confirmation button click
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!empty($cart_items)) {
    // Insert into orders
    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Paid')");
    $stmt->bind_param("id", $user_id, $total_amount);
    $stmt->execute();
    $order_id = $conn->insert_id;

    // ✅ Save cart items in session BEFORE clearing
    $_SESSION['cart'] = $cart_items;

    // Insert each item into order_items and update product quantities
    foreach ($cart_items as $item) {
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
        $stmt->execute();

        $update_product_query = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_product_query);
        $update_stmt->bind_param("ii", $item['quantity'], $item['product_id']);
        $update_stmt->execute();
    }

    // ✅ Now safely delete cart from DB only (not session)
    $delete_cart_query = "DELETE FROM cart WHERE user_id = ?";
    $delete_cart_stmt = $conn->prepare($delete_cart_query);
    $delete_cart_stmt->bind_param("i", $user_id);
    $delete_cart_stmt->execute();

    // ❌ DO NOT unset $_SESSION['cart']



        // Clear cart from database (optional but good practice)
        $delete_cart_query = "DELETE FROM cart WHERE user_id = ?";
        $delete_cart_stmt = $conn->prepare($delete_cart_query);
        $delete_cart_stmt->bind_param("i", $user_id);
        $delete_cart_stmt->execute();

        // Store order and user details in session
        $_SESSION['order'] = [
            'order_id' => $order_id,
            'payment_method' => 'Khalti', // Example payment method, can be dynamic
            'total_amount' => $total_amount
        ];

        $_SESSION['user_details'] = $user_details; // Store user details in session

        // Redirect to success page
        header("Location: success.php?message=payment_confirmed");
        exit();
    } else {
        // If cart is empty, redirect back
        header("Location: cart.php?error=empty_cart");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment | BareBelle</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: #212529;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .confirmation-container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .confirmation-icon {
            color: #88476e;
            font-size: 48px;
            margin-bottom: 20px;
        }

        h1 {
            margin-bottom: 20px;
            color: #343a40;
            font-weight: 600;
        }

        p {
            margin-bottom: 30px;
            color: #6c757d;
            line-height: 1.6;
        }

        .confirm-button {
            background-color: #88476e;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 12px 30px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .confirm-button:hover {
            background-color: #6d3859;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(136, 71, 110, 0.3);
        }

        .logo {
            margin-bottom: 30px;
            font-size: 24px;
            font-weight: bold;
            color: #88476e;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <div class="logo">BareBelle</div>
        <div class="confirmation-icon">
            <i class="fas fa-credit-card"></i>
        </div>
        <h1>Confirm Your Payment</h1>
        <p>Please review your order details and confirm your payment to complete your purchase. By clicking the button below, you agree to our terms and conditions.</p>
        <form method="POST" action="">
            <button type="submit" class="confirm-button">
                <i class="fas fa-check"></i> Confirm Payment
            </button>
        </form>
    </div>
</body>
</html>
