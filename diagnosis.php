<?php
// ==================== BACKEND: HANDLE FILE UPLOAD AND AI INTEGRATION ====================

// FastAPI endpoint
$AI_API = 'http://127.0.0.1:8000/detect/';
$UPLOAD_DIR = __DIR__ . '/uploads/';

// Ensure upload directory exists
if (!file_exists($UPLOAD_DIR)) {
    mkdir($UPLOAD_DIR, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['skinImage'])) {
    $file = $_FILES['skinImage'];
    $fileName = basename($file['name']);
    $filePath = $UPLOAD_DIR . $fileName;

    // Move uploaded file to local uploads directory
    if (move_uploaded_file($file['tmp_name'], $filePath)) {
        // Prepare file to send to FastAPI
        $cfile = new CURLFile($filePath, mime_content_type($filePath), $fileName);
        $postData = ['file' => $cfile];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $AI_API);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);
        $curlError = curl_error($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($curlError) {
            echo "<p style='color:red;text-align:center;margin-top:80px;'>Error connecting to AI server: $curlError</p>";
            exit;
        }

        if ($httpCode != 200) {
            echo "<p style='color:red;text-align:center;margin-top:80px;'>AI server returned HTTP $httpCode. Response: <pre>$response</pre></p>";
            exit;
        }

        // Decode API JSON response
        $result = json_decode($response, true);
        if (!$result) {
            echo "<p style='color:red;text-align:center;margin-top:80px;'>Invalid response from AI server.</p>";
            exit;
        }

        // Redirect to process_image.php with result data
        header("Location: process_image.php?result=" . urlencode(json_encode($result)));
        exit();
    } else {
        echo "<p style='color:red;text-align:center;margin-top:80px;'>File upload failed. Please check folder permissions.</p>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BareBelle Diagnosis</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #c3cfea, #f8c8dc);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background-color: #c3cfea;
    }

    .navbar-brand {
      font-weight: 700;
      color: #9f5f80;
    }

    .nav-link {
      font-weight: 500;
      color: #333;
    }

    .nav-link:hover {
      color: #f8c8dc;
    }

    .container-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 15px;
    }

    .diagnosis-container {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 5px 20px rgba(0,0,0,0.1);
      padding: 40px 30px;
      max-width: 900px;
      width: 100%;
    }

    .option-card {
      background: #ffffff;
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      transition: transform 0.2s ease-in-out;
      padding: 25px;
      height: 100%;
    }

    .option-card:hover {
      transform: translateY(-5px);
    }

    .btn-custom {
      background-color: #f8c8dc;
      border: none;
      color: #333;
      font-weight: 600;
    }

    .btn-custom:hover {
      background-color: #f4a7c5;
      color: white;
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

<!-- Navbar -->
<nav class="navbar navbar-expand-lg shadow fixed-top">
  <div class="container">
    <a class="navbar-brand" href="home.php">BareBelle</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="productscategories.php">Products</a></li>
        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
        <li class="nav-item ms-3">
          <a class="btn btn-custom" href="logout.php">Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Diagnosis Section -->
<div class="container-section">
  <div class="diagnosis-container">
    <h2 class="text-center mb-4" style="color: #9f5f80;">Skin Diagnosis</h2>
    <p class="text-center text-muted mb-5">Choose one option below to proceed with your skin analysis.</p>
    
    <div class="row g-4">
      <!-- Image Upload -->
      <div class="col-md-6">
        <div class="option-card">
          <h5 class="mb-3"><i class="bi bi-camera"></i> Upload Your Skin Image</h5>
          <form action="diagnosis.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="skinImage" class="form-label">Choose an image</label>
              <input type="file" class="form-control" id="skinImage" name="skinImage" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-custom w-100">Analyze Image</button>
          </form>
        </div>
      </div>

      <!-- Questionnaire -->
      <div class="col-md-6">
        <div class="option-card">
          <h5 class="mb-3"><i class="bi bi-list-check"></i> Answer a Quick Questionnaire</h5>
          <p class="text-muted">Not comfortable uploading a photo? Answer 10 quick questions to help us understand your skin better.</p>
          <a href="questionnaire.php" class="btn btn-custom w-100">Start Questionnaire</a>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Footer -->
<footer>
  <div class="container">
    &copy; 2025 BareBelle Skincare. All rights reserved.
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
