<?php
// Connect to database
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php"); 
    exit();
}
$conn = new mysqli('localhost', 'root', '', 'glowcare');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Save edited products if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_all'])) {
    foreach ($_POST['name'] as $id => $name) {
        $name = $conn->real_escape_string($name);
        $category = $conn->real_escape_string($_POST['category'][$id]);
        $quantity = intval($_POST['quantity'][$id]);
        $price = floatval($_POST['price'][$id]);

        $update_sql = "UPDATE products SET 
            name = '$name', 
            category = '$category', 
            quantity = $quantity, 
            price = $price 
            WHERE id = $id";

        $conn->query($update_sql);
    }
    header("Location: manage_products.php"); // Refresh page after saving
    exit();
}

// Fetch products
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products - BareBelle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">



    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            padding: 60px 20px;
            min-height: 100vh;
        }
        .title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            color: #9f5f80;
            margin-bottom: 30px;
        }
        .table img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 10px;
        }
        .table td, .table th {
            vertical-align: middle;
        }
        .btn-save {
            background-color: #9f5f80;
            color: white;
        }
        .btn-save:hover {
            background-color: #854c6e;
        }
        .btn-delete {
            background-color: #ff6b6b;
            color: white;
        }
        .btn-delete:hover {
            background-color: #e95b5b;
        }
    </style>
</head>
<body>

    <?php include 'navbar.php'; ?>


<div class="container">
    <div class="title">Manage Products</div>

    <form method="POST" action="manage_products.php">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle bg-white shadow">
                <thead class="table-light">
                    <tr>
                        <th>Image</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Quantity</th>
                        <th>Price (Rs.)</th>
                        <th style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($row['image']); ?>" alt="Product Image">
                                </td>
                                <td>
                                    <input type="text" name="name[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['name']); ?>" class="form-control" required>
                                </td>
                                <td>
                                    <input type="text" name="category[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['category']); ?>" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" name="quantity[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['quantity']); ?>" class="form-control" required>
                                </td>
                                <td>
                                    <input type="number" step="0.01" name="price[<?php echo $row['id']; ?>]" value="<?php echo htmlspecialchars($row['price']); ?>" class="form-control" required>
                                </td>
                                <td>
                                    <a href="delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-delete" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No products found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <button type="submit" name="save_all" class="btn btn-save">Save Changes</button>
        </div>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
