<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            min-height: 100vh;
        }

        .form-container {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
            max-width: 700px;
            margin: 60px auto;
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: #9f5f80;
            text-align: center;
            margin-bottom: 25px;
        }

        .btn-custom {
            background-color: #9f5f80;
            color: white;
            font-weight: 500;
        }

        .btn-custom:hover {
            background-color: #7c3b5b;
        }
    </style>
</head>
<body>

    <!-- Add Product Form -->
    <div class="container form-container">
        <div class="form-title">Add New Product</div>

        <form action="add_product_backend.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Product Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" rows="3" class="form-control" required></textarea>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Price (NPR)</label>
                    <input type="number" name="price" class="form-control" step="0.01" required>
                </div>

                <div class="mb-3 col-md-6">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Category</label>
                <select name="category" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    <option value="serum">Serum</option>
                    <option value="moisturizer">Moisturizer</option>
                    <option value="sunscreen">Sunscreen</option>
                    <option value="facewash">Facewash</option>
                    <option value="facemask">Facemask</option>
                    <option value="cleanser">Cleanser</option>
                    <option value="toner">Toner</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Product Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-custom px-5">Add Product</button>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
