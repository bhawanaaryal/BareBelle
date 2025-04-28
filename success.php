<?php
session_start();
include 'db_connect.php'; // Ensure to include the database connection

// Check if order details and user details are available in session
if (isset($_SESSION['order']) && isset($_SESSION['user_details']) && isset($_SESSION['order']['order_id'])) {
    $order = $_SESSION['order'];
    $user_details = $_SESSION['user_details'];
    $total_price = $order['total_amount'];

    // Fetch cart items from the session
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $cart_items = $_SESSION['cart'];  // Fetch from session
    } else {
        // If cart items are not available in session (cart was cleared), fetch from the database
        $user_id = $_SESSION['user_id'];  // Assuming user_id is stored in session
        $stmt = $conn->prepare("SELECT cart.*, products.name, products.price, products.image FROM cart 
            JOIN products ON cart.product_id = products.id WHERE cart.user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $cart_items = $result->fetch_all(MYSQLI_ASSOC);
    }
} else {
    // If session data is not available, redirect to the cart or homepage
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation | BareBelle</title>
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #9f5f80;
            font-size: 2rem;
            margin-bottom: 20px;
        }

        h2 {
            color: #9f5f80;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: center;
        }

        p {
            font-size: 1rem;
            color: #555;
            margin-bottom: 10px;
        }

        strong {
            font-weight: 600;
        }

        .order-details ul {
            list-style-type: none;
            padding-left: 0;
        }

        .order-details li {
            font-size: 1rem;
            margin-bottom: 5px;
            color: #555;
        }

        .actions {
            text-align: center;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 30px;
            background-color: #9f5f80;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
            font-weight: 600;
        }

        .btn:hover {
            background-color: #f8c8dc;
            color: #333;
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
    <div class="container">
        <h1>Thank you for your order!</h1>

        <h2>Order Report</h2>
        <p><strong>Name:</strong> <?php echo htmlspecialchars($user_details['name']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($user_details['email']); ?></p>
        <p><strong>Phone:</strong> <?php echo htmlspecialchars($user_details['phone']); ?></p>
        <p><strong>Address:</strong> <?php echo htmlspecialchars($user_details['address']); ?></p>

        <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
        <p><strong>Total Price:</strong> Rs. <?php echo number_format($total_price, 2); ?></p>

        <h3>Ordered Products:</h3>
        <ul>
            <?php
            // Display ordered products
            foreach ($cart_items as $item) {
                echo '<li>' . htmlspecialchars($item['name']) . ' (x' . $item['quantity'] . ') - Rs. ' . number_format($item['price'] * $item['quantity'], 2) . '</li>';
            }
            ?>
        </ul>

        <div class="actions">
            <a href="home.php" class="btn">Continue Shopping</a>
        </div>
    </div>

    <footer>
        &copy; 2025 BareBelle. All rights reserved.
    </footer>
</body>
</html>
