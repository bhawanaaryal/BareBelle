<?php
session_start();
include 'db_connect.php'; // your database connection file

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

$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Handle place order
if (isset($_POST['place_order'])) {
    $payment_method = $_POST['payment_method'];

    if ($payment_method == 'cod') {
        // Insert into orders
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Pending')");
        $stmt->bind_param("id", $user_id, $total_amount);
        $stmt->execute();
        $order_id = $conn->insert_id;

        // Insert each item into order_items
        foreach ($cart_items as $item) {
            $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }

        // Clear cart
        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();

        header("Location: index.php?message=order_placed");
        exit();
    } elseif ($payment_method == 'khalti') {
        // Placeholder: redirect to Khalti payment page later
        header("Location: khalti_payment.php?amount=$total_amount");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;700&display=swap" rel="stylesheet">
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
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        h2 {
            color: #9f5f80;
            margin-bottom: 20px;
            font-weight: 700;
            text-align: center;
        }
        .order-summary {
            margin-bottom: 30px;
        }
        .order-summary div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            font-weight: 500;
        }
        .payment-options {
            margin-bottom: 20px;
        }
        .payment-options label {
            display: block;
            margin-bottom: 10px;
            font-size: 1rem;
            color: #555;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #9f5f80;
            color: #fff;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
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
    <h2>Order Summary</h2>

    <div class="order-summary">
        <?php if (!empty($cart_items)): ?>
            <?php foreach ($cart_items as $item): ?>
                <div>
                    <span><?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>)</span>
                    <span>Rs. <?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                </div>
            <?php endforeach; ?>
            <hr>
            <div>
                <strong>Total:</strong>
                <strong>Rs. <?php echo number_format($total_amount, 2); ?></strong>
            </div>
        <?php else: ?>
            <p>Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <?php if (!empty($cart_items)): ?>
        <form method="POST">
            <div class="payment-options">
                <label>
                    <input type="radio" name="payment_method" value="cod" checked> Cash on Delivery
                </label>
                <label>
                    <input type="radio" name="payment_method" value="khalti"> Pay with Khalti
                </label>
            </div>
            <button type="submit" name="place_order" class="btn">Place Order</button>
        </form>
    <?php endif; ?>
</div>

<footer>
    &copy; 2025 BareBelle. All rights reserved.
</footer>

</body>
</html>
