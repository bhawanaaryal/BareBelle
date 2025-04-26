<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "barbie";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get cart items for current user
$user_id = $_SESSION['user_id'];
$cart_items = [];
$total = 0;

$sql = "SELECT c.id as cart_id, p.id as product_id, p.name, p.image, p.price, c.quantity 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $cart_items[] = $row;
    $total += $row['price'] * $row['quantity'];
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Your existing head content -->
</head>
<body>
  <!-- Your existing navbar -->

  <div class="container mt-4">
    <div id="cartContainer">
      <h2 class="cart-title"><i class="bi bi-bag-heart-fill"></i> Your Shopping Cart</h2>

      <?php if (count($cart_items) > 0): ?>
        <?php foreach ($cart_items as $item): ?>
          <div class="cart-card d-flex align-items-center">
            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="cart-img me-4">
            <div class="flex-grow-1">
              <h5 class="mb-1"><?php echo $item['name']; ?></h5>
              <p class="mb-1">Price: Rs. <?php echo $item['price']; ?></p>
              <div class="d-flex align-items-center gap-2">
                <label for="qty<?php echo $item['product_id']; ?>" class="mb-0">Qty:</label>
                <input type="number" id="qty<?php echo $item['product_id']; ?>" 
                       class="quantity-input" value="<?php echo $item['quantity']; ?>" min="1"
                       data-cart-id="<?php echo $item['cart_id']; ?>"
                       data-product-id="<?php echo $item['product_id']; ?>">
              </div>
            </div>
            <div class="text-end">
              <p class="fw-bold mb-2">Subtotal: Rs. <?php echo $item['price'] * $item['quantity']; ?></p>
              <button class="remove-btn" title="Remove" 
                      data-cart-id="<?php echo $item['cart_id']; ?>">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        <?php endforeach; ?>

        <div class="total-section">
          Total: Rs. <?php echo $total; ?>
          <br>
          <button class="checkout-btn mt-3">Proceed to Checkout</button>
        </div>
      <?php else: ?>
        <div id="emptyCart" class="empty-cart">
          <h3>Your cart is empty.</h3>
          <a href="products.html" class="btn">Shop Products</a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Your existing modals and footer -->

  <!-- Add this JavaScript for cart operations -->
  <script>
  document.addEventListener('DOMContentLoaded', function() {
      // Quantity change handler
      document.querySelectorAll('.quantity-input').forEach(input => {
          input.addEventListener('change', function() {
              const cartId = this.dataset.cartId;
              const productId = this.dataset.productId;
              const newQuantity = this.value;
              
              updateCartItem(cartId, productId, newQuantity);
          });
      });
      
      // Remove item handler
      document.querySelectorAll('.remove-btn').forEach(button => {
          button.addEventListener('click', function() {
              const cartId = this.dataset.cartId;
              removeCartItem(cartId);
          });
      });
  });
  
  function updateCartItem(cartId, productId, quantity) {
      fetch('update_cart.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `action=update&cart_id=${cartId}&product_id=${productId}&quantity=${quantity}`
      })
      .then(response => response.json())
      .then(data => {
          if (data.status === 'success') {
              location.reload(); // Refresh to show updated cart
          } else {
              alert('Error updating cart: ' + (data.message || 'Unknown error'));
          }
      });
  }
  
  function removeCartItem(cartId) {
      if (confirm('Are you sure you want to remove this item from your cart?')) {
          fetch('update_cart.php', {
              method: 'POST',
              headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: `action=remove&cart_id=${cartId}`
          })
          .then(response => response.json())
          .then(data => {
              if (data.status === 'success') {
                  location.reload(); // Refresh to show updated cart
              } else {
                  alert('Error removing item: ' + (data.message || 'Unknown error'));
              }
          });
      }
  }
  </script>
</body>
</html>