<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>About Us | BareBelle Skincare</title>

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet"/>

  <!-- Custom CSS -->
  <link rel="stylesheet" href="style.css" />
</head>
<body>

<?php include 'navbar.php'; ?>

  <section class="about-section py-5 mt-5">
  <div class="container">
    <!-- Heading -->
    <div class="row">
      <div class="col-12">
        <h2 class="who-we-are-heading text-end mb-5">Who We Are</h2>
      </div>
    </div>

    <!-- Image and Text Side by Side -->
    <div class="row align-items-center">
      <!-- Image -->
      <div class="col-md-6 mb-4">
        <img src="pics/download.jpeg" class="img-fluid rounded shadow about-image" alt="About BareBelle" />
      </div>

      <!-- Text -->
      <div class="col-md-6">
        <p>
          At <strong>BareBelle Skincare</strong>, we are passionate about helping you feel confident in your skin.
          Our brand was founded with one mission – to create clean, effective, and affordable skincare that celebrates natural beauty.
          Every product is made with love, tested for purity, and backed by real science.
        </p>
        <p>
          We believe skincare is self-care. That’s why we blend nature’s finest ingredients with dermatological expertise
          to deliver gentle yet powerful results. Whether you're struggling with acne, dryness, sensitivity, or just want to glow – we’ve got you covered.
        </p>
      </div>
    </div>
  </div>
</section>


<section>
      <div class="brand-promise mt-5 rounded shadow-sm">
        <!-- Brand Promise heading -->
<h2 class="brand-promise-heading text-center">Our Brand Promise</h2>

        <div class="row mt-4">
          <div class="col-md-6 col-lg-3 mb-4">
            <div class="promise-box shadow-sm">
              <h5>Cruelty-Free & Vegan</h5>
              <p>No animal testing, ever. 100% plant-powered formulas.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-4">
            <div class="promise-box shadow-sm">
              <h5>Clean & Non-Toxic</h5>
              <p>Formulated without harmful chemicals or harsh ingredients.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-4">
            <div class="promise-box shadow-sm">
              <h5>Results-Driven</h5>
              <p>Dermatologist-tested formulas that actually work.</p>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-4">
            <div class="promise-box shadow-sm">
              <h5>Confidence Through Skincare</h5>
              <p>We empower your natural glow—because skincare is self-care.</p>
            </div>
          </div>
        </div>
      </div>
      
  </section>

  <!-- Footer -->
  <footer class="bg-light py-3">
    <div class="container text-center">
      &copy; 2025 BareBelle Skincare. All rights reserved.
    </div>
  </footer>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>