<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch orders for this customer
$orderStmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY order_date DESC");
if (!$orderStmt) die("Prepare failed: " . $conn->error);
$orderStmt->bind_param("i", $user_id);
$orderStmt->execute();
$ordersResult = $orderStmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>My Orders - BareBelle</title>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">

<style>
body {
    font-family: 'Quicksand', sans-serif;
    background: linear-gradient(135deg, #c3cfea, #f8c8dc);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

main { flex: 1; padding: 100px 20px 40px; }

.table-container {
    max-width: 1000px;
    margin: auto;
    background: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

h2 { color: #9f5f80; margin-bottom: 20px; text-align: center; }

/* Status colors */
.status-pending { color: #ff9800; font-weight: 600; }      /* COD pending */
.status-paid { color: #4caf50; font-weight: 600; }         /* Khalti paid */
.status-completed { color: #2196f3; font-weight: 600; }    /* Delivered / completed */
.status-cancelled { color: #f44336; font-weight: 600; }

.product-list { margin-top: 10px; font-size: 0.95rem; }
.product-list li { margin-bottom: 5px; }
</style>
</head>
<body>

<?php include 'navbar.php'; ?>

<main>
<div class="table-container">
    <h2>My Order History</h2>

    <?php if ($ordersResult->num_rows > 0): ?>
        <?php while($order = $ordersResult->fetch_assoc()): ?>
            <div class="card mb-3 p-3">
                <h5>Order ID: <?php echo $order['id']; ?></h5>
                <p>
                    <strong>Date:</strong> <?php echo date("d M Y, h:i A", strtotime($order['order_date'])); ?> |
                    <strong>Total:</strong> Rs. <?php echo number_format($order['total_amount'], 2); ?> |
                    <strong>Status:</strong> 
                    <span class="status-<?php echo strtolower($order['status']); ?>">
                        <?php 
                        // Capitalize for display
                        echo ucfirst($order['status']); 
                        ?>
                    </span>
                </p>

                <ul class="product-list">
                    <?php
                    // Fetch products for this order
                    $productStmt = $conn->prepare("
                        SELECT p.name, oi.quantity, oi.price
                        FROM order_items oi
                        JOIN products p ON oi.product_id = p.id
                        WHERE oi.order_id = ?
                    ");
                    $productStmt->bind_param("i", $order['id']);
                    $productStmt->execute();
                    $productsResult = $productStmt->get_result();

                    while($product = $productsResult->fetch_assoc()):
                    ?>
                        <li><?php echo htmlspecialchars($product['name']); ?> 
                            (Qty: <?php echo $product['quantity']; ?>) - Rs. <?php echo number_format($product['price'], 2); ?>
                        </li>
                    <?php endwhile; ?>
                    <?php $productStmt->close(); ?>
                </ul>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center; color:#555;">You have no orders yet. <a href="productscategories.php">Shop now!</a></p>
    <?php endif; ?>
</div>
</main>

<?php include 'footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
