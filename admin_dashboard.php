<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - BareBelle</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            min-height: 100vh;
        }

        .dashboard-container {
            padding: 60px 20px;
        }

        .dashboard-title {
            text-align: center;
            font-size: 2.2rem;
            font-weight: bold;
            color: #9f5f80;
            margin-bottom: 40px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: transform 0.2s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-title {
            color: #333;
            font-weight: 600;
        }

        .btn-custom {
            background-color: #9f5f80;
            color: white;
        }

        .btn-custom:hover {
            background-color: #7c3b5b;
        }
    </style>
</head>
<body>

    <div class="container dashboard-container">
        <div class="dashboard-title">Admin Dashboard</div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Add New Product</h5>
                    <p class="card-text">Add skincare products with images, quantity, price and category.</p>
                    <a href="add_product.php" class="btn btn-custom">Go</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Manage Products</h5>
                    <p class="card-text">Edit or delete existing products in your store inventory.</p>
                    <a href="manage_products.php" class="btn btn-custom">Manage</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">View Orders</h5>
                    <p class="card-text">Check customer orders and order status.</p>
                    <a href="view_order.php" class="btn btn-custom">View</a>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card p-4 text-center">
                    <h5 class="card-title">Customer List</h5>
                    <p class="card-text">View and manage registered customers.</p>
                    <a href="user_list.php" class="btn btn-custom">Open</a>
                </div>
            </div>



    <!-- Bootstrap Bundle JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
