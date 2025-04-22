<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glowcare"; // still using glowcare unless you've changed the DB name too

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$category = isset($_GET['category']) ? $_GET['category'] : '';
$products = [];

if (!empty($category)) {
  $stmt = $conn->prepare("SELECT name, image, price FROM products WHERE category = ?");
  $stmt->bind_param("s", $category);
  $stmt->execute();
  $result = $stmt->get_result();

  while ($row = $result->fetch_assoc()) {
    $products[] = $row;
  }

  $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo ucfirst($category); ?> | BareBelle</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"/>
  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #fff0f3, #e4d3dc);
      padding-top: 90px;
    }

    h2 {
      text-align: center;
      color: #9f5f80;
      margin-bottom: 40px;
      font-weight: 600;
    }

    .product-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
    }

    .product-card {
      background-color: #ffffff;
      border-radius: 15px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      overflow: hidden;
      text-align: center;
      padding: 20px;
      transition: transform 0.3s ease;
    }

    .product-card:hover {
      transform: translateY(-8px);
    }

    .product-card img {
      height: 220px;
      width: 100%;
      object-fit: cover;
      border-radius: 12px;
    }

    .product-card h5 {
      margin-top: 15px;
      color: #333;
      font-weight: 600;
    }

    .product-card .price {
      color: #9f5f80;
      font-size: 1.1rem;
      margin-bottom: 10px;
    }

    .icons {
      display: flex;
      justify-content: center;
      gap: 15px;
    }

    .icons i {
      cursor: pointer;
      font-size: 1.2rem;
      color: #9f5f80;
      transition: color 0.3s;
    }

    .icons i:hover {
      color: #703f5d;
    }
  </style>
</head>
<body>

  <div class="container">
    <h2><?php echo ucfirst($category); ?></h2>
    <div class="product-grid">
      <?php if (count($products) > 0): ?>
        <?php foreach ($products as $product): ?>
          <div class="product-card">
            <img src="product_images/<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" />
            <h5><?php echo $product['name']; ?></h5>
            <p class="price">Rs. <?php echo $product['price']; ?></p>
            <div class="icons">
              <i class="bi bi-cart-plus-fill" title="Add to Cart"></i>
              <i class="bi bi-heart-fill" title="Add to Wishlist"></i>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;">No products found in this category.</p>
      <?php endif; ?>
    </div>
  </div>

</body>
</html>
