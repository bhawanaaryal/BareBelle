<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'glowcare');
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Handle AJAX Requests
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
    $order_id = $_POST['order_id'];

    if ($_POST['action'] == 'mark_completed') {
        $stmt = $conn->prepare("UPDATE orders SET status = 'completed' WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        echo $stmt->execute() ? 'success' : 'error';
        $stmt->close();

    } elseif ($_POST['action'] == 'cancel_order') {
        $stmt = $conn->prepare("UPDATE orders SET status = 'cancelled' WHERE id = ?");
        $stmt->bind_param("i", $order_id);
        echo $stmt->execute() ? 'success' : 'error';
        $stmt->close();

    } elseif ($_POST['action'] == 'delete_order') {
        // Delete only if order is completed or cancelled
        $stmt_check = $conn->prepare("SELECT status FROM orders WHERE id = ?");
        $stmt_check->bind_param("i", $order_id);
        $stmt_check->execute();
        $res = $stmt_check->get_result()->fetch_assoc();
        $stmt_check->close();

        if (in_array($res['status'], ['completed','cancelled'])) {
            // Delete order items first
            $stmt_items = $conn->prepare("DELETE FROM order_items WHERE order_id = ?");
            $stmt_items->bind_param("i", $order_id);
            $stmt_items->execute();
            $stmt_items->close();

            // Delete order
            $stmt_order = $conn->prepare("DELETE FROM orders WHERE id = ?");
            $stmt_order->bind_param("i", $order_id);
            echo $stmt_order->execute() ? 'success' : 'error';
            $stmt_order->close();
        } else {
            echo 'not_allowed';
        }
    }
    exit();
}

// Fetch orders with customer names
$sql = "SELECT o.id AS order_id, o.order_date, u.name AS customer_name, o.total_amount, o.status
        FROM orders o
        JOIN users u ON o.user_id = u.id
        ORDER BY o.order_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Orders List - BareBelle</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Quicksand', sans-serif;
    background: linear-gradient(135deg, #c3cfea, #f8c8dc);
    padding: 100px 20px 60px; /* added top padding for fixed navbar */
    min-height: 100vh;
}
.title { text-align:center; font-size:2rem; font-weight:bold; color:#9f5f80; margin-bottom:30px; }
.table td, .table th { vertical-align: middle; }
.btn-complete { background-color:#6bcf63;color:white; }
.btn-cancel { background-color:#ff6b6b;color:white; }
.btn-delete { background-color:#555;color:white; }
.btn-complete:hover { background-color:#5abb55; }
.btn-cancel:hover { background-color:#e65b5b; }
.btn-delete:hover { background-color:#333; }
.hiddenRow { padding:0; }
.product-list li { margin-bottom:5px; }

/* Status colors */
.badge.pending { background-color:#ff9800; color:#fff; }    /* Orange */
.badge.completed { background-color:#4caf50; color:#fff; }  /* Green */
.badge.cancelled { background-color:#f44336; color:#fff; }  /* Red */
.badge.paid { background-color:#2196f3; color:#fff; }       /* Blue */
</style>
</head>
<body>

<?php include 'adminnav.php'; ?>

<div class="container">
  <div class="title">Customer Orders</div>
  <div class="table-responsive">
    <table class="table table-bordered table-striped bg-white shadow text-center align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>Customer</th>
          <th>Date</th>
          <th>Total</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while($order = $result->fetch_assoc()): ?>
          <tr data-bs-toggle="collapse" data-bs-target="#products-<?php echo $order['order_id']; ?>" class="accordion-toggle">
            <td><?php echo $order['order_id']; ?></td>
            <td><?php echo htmlspecialchars($order['customer_name']); ?></td>
            <td><?php echo date("d M Y, h:i A", strtotime($order['order_date'])); ?></td>
            <td>Rs. <?php echo number_format($order['total_amount'],2); ?></td>
            <td><span class="badge <?php echo strtolower($order['status']); ?>"><?php echo ucfirst($order['status']); ?></span></td>
            <td>
              <?php if (in_array($order['status'], ['pending','paid'])): ?>
                <button class="btn btn-sm btn-complete" data-order-id="<?php echo $order['order_id']; ?>">Mark as Completed</button>
                <button class="btn btn-sm btn-cancel" data-order-id="<?php echo $order['order_id']; ?>">Cancel</button>
              <?php else: ?>
                <button class="btn btn-sm btn-delete" data-order-id="<?php echo $order['order_id']; ?>">Delete</button>
              <?php endif; ?>
            </td>
          </tr>

          <!-- Collapsible Products -->
          <tr>
            <td colspan="6" class="hiddenRow p-0">
              <div class="collapse" id="products-<?php echo $order['order_id']; ?>">
                <div class="p-3 bg-light text-start">
                  <strong>Products:</strong>
                  <ul class="product-list">
                    <?php
                    $prodStmt = $conn->prepare("
                      SELECT p.name, oi.quantity, oi.price 
                      FROM order_items oi
                      JOIN products p ON oi.product_id = p.id
                      WHERE oi.order_id = ?
                    ");
                    $prodStmt->bind_param("i", $order['order_id']);
                    $prodStmt->execute();
                    $prodResult = $prodStmt->get_result();
                    while($product = $prodResult->fetch_assoc()):
                    ?>
                      <li><?php echo htmlspecialchars($product['name']); ?> (Qty: <?php echo $product['quantity']; ?>) - Rs. <?php echo number_format($product['price'],2); ?></li>
                    <?php endwhile; $prodStmt->close(); ?>
                  </ul>
                </div>
              </div>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="6">No orders found.</td></tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function ajaxAction(orderId, action) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST','',true);
  xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
  xhr.onload = function(){
    if(xhr.status==200){
      if(xhr.responseText=='success'){
        alert('Action completed successfully!');
        location.reload();
      } else if(xhr.responseText=='not_allowed'){
        alert('Cannot delete pending or paid orders!');
      } else {
        alert('Action failed!');
      }
    }
  };
  xhr.send('action='+action+'&order_id='+orderId);
}

// Buttons
document.querySelectorAll('.btn-complete').forEach(btn => {
  btn.addEventListener('click',()=>ajaxAction(btn.dataset.orderId,'mark_completed'));
});
document.querySelectorAll('.btn-cancel').forEach(btn => {
  btn.addEventListener('click',()=>ajaxAction(btn.dataset.orderId,'cancel_order'));
});
document.querySelectorAll('.btn-delete').forEach(btn => {
  btn.addEventListener('click',()=>ajaxAction(btn.dataset.orderId,'delete_order'));
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php $conn->close(); ?>
