<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products - GlowCare</title>
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

        .btn-edit {
            background-color: #f8c8dc;
            color: #333;
        }

        .btn-delete {
            background-color: #ff6b6b;
            color: white;
        }

        .btn-edit:hover {
            background-color: #e4acc2;
        }

        .btn-delete:hover {
            background-color: #e95b5b;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="title">Manage Products</div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle bg-white shadow">
            <thead class="table-light">
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th style="width: 160px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Sample Row: Replace with dynamic PHP rows later -->
                <tr>
                    <td><img src="images/sample1.jpg" alt="Product"></td>
                    <td>Hydrating Face Serum</td>
                    <td>Serum</td>
                    <td>25</td>
                    <td>Rs. 850</td>
                    <td>
                        <a href="edit_product.php?id=1" class="btn btn-sm btn-edit">Edit</a>
                        <a href="delete_product.php?id=1" class="btn btn-sm btn-delete">Delete</a>
                    </td>
                </tr>
                <tr>
                    <td><img src="images/sample2.jpg" alt="Product"></td>
                    <td>Glow Moisturizer</td>
                    <td>Moisturizer</td>
                    <td>40</td>
                    <td>Rs. 950</td>
                    <td>
                        <a href="edit_product.php?id=2" class="btn btn-sm btn-edit">Edit</a>
                        <a href="delete_product.php?id=2" class="btn btn-sm btn-delete">Delete</a>
                    </td>
                </tr>
                <!-- Add more rows dynamically later -->
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
