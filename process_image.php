<?php
if (isset($_GET['result'])) {
    $jsonString = urldecode($_GET['result']);
    $result = json_decode($jsonString, true);

    $imageURL = $result['result_image'] ?? null;
    $classes = $result['classes'] ?? [];
} else {
    echo "<p>No image uploaded.</p>";
    exit;
}

// Skin issue descriptions
$descriptions = [
    'acne' => "You may have acne — a common skin condition that causes pimples, blackheads, and whiteheads. 
               It's often due to excess oil, bacteria, or hormonal changes.",
    'black heads' => "You may have blackheads — small dark bumps that appear when hair follicles get clogged 
                      with oil and dead skin cells.",
    'dark circles' => "You may have dark circles — areas of darker skin under the eyes often caused by 
                       fatigue, genetics, or dehydration.",
    'rosacea' => "You may have rosacea — a chronic skin condition causing redness, visible blood vessels, 
                  and sometimes small red bumps on the face.",
    'normal' => "Your skin appears normal — balanced, not too oily or dry, and free from significant blemishes."
];

// Detect primary class
$primaryClass = !empty($classes) ? strtolower(trim($classes[0])) : 'normal';
$description = $descriptions[$primaryClass] ?? "No specific skin issue detected.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detection Results - BareBelle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #c3cfea, #f8c8dc);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .result-card {
            background: white;
            border-radius: 12px;
            padding: 40px 30px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.15);
            max-width: 700px;
            width: 100%;
            text-align: center;
        }
        img {
            max-width: 100%;
            border-radius: 10px;
            margin-top: 20px;
        }
        .btn-recommendations {
            background-color: #f086cbff;
            color: white;
            font-size: 1.3rem;
            font-weight: 700;
            padding: 14px 35px;
            margin-top: 20px;
            border-radius: 8px;
            display: inline-block;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-recommendations:hover {
            background-color: #d1a6eaff;
        }
        .btn-try-again {
            background-color: transparent;
            color: #555;
            border: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-top: 15px;
            text-decoration: underline;
            display: inline-block;
        }
        .btn-try-again:hover {
            color: #333;
        }
    </style>
</head>
<body>

<div class="result-card">
    <h2 class="mb-3" style="color:#9f5f80;">Skin Issue Detection Result</h2>

    <?php if (!empty($imageURL)): ?>
        <img src="<?= htmlspecialchars($imageURL) ?>" alt="Result Image">
    <?php else: ?>
        <p>No result image found.</p>
    <?php endif; ?>

    <h4 class="mt-4" style="color:#9f5f80;">Detected Issue: <?= ucfirst($primaryClass) ?></h4>
    <p><?= htmlspecialchars($description) ?></p>

    <?php if ($primaryClass && $primaryClass !== 'normal'): ?>
        <a href="products.php?skin_issue=<?= urlencode($primaryClass) ?>" class="btn-recommendations">
            Get Product Recommendations
        </a>
    <?php endif; ?>

    <br>
    <a href="diagnosis.php" class="btn-try-again">Try Another Image</a>
</div>

</body>
</html>
