<?php
// process_questionnaire.php

function post($k) {
    return isset($_POST[$k]) ? trim($_POST[$k]) : null;
}

// Read answers
$q1 = post('q1');
$q2 = post('q2');
$q3 = post('q3');
$q4 = post('q4');
$q5 = post('q5');
$q6 = post('q6');
$q7 = post('q7');
$q8 = post('q8');
$q9 = post('q9');
$q10 = post('q10');

// Initialize scores
$scores = [
    'acne' => 0,
    'dark_circles' => 0,
    'blackheads' => 0,
    'rosacea' => 0,
    'normal' => 0
];

// Apply rules
if ($q1 === 'rarely') $scores['normal'] += 1;
elseif ($q1 === 'sometimes' || $q1 === 'frequently') $scores['acne'] += 1;

if ($q2 === 'yes') $scores['blackheads'] += 1;
if ($q3 === 'yes') $scores['rosacea'] += 1;
if ($q4 === 'yes') $scores['dark_circles'] += 1;
if ($q5 === 'yes') $scores['dark_circles'] += 1;
if ($q6 === 'very_sensitive') $scores['rosacea'] += 1;
if ($q7 === 'yes') $scores['acne'] += 1;
if ($q8 === 'yes') $scores['acne'] += 1;
if ($q9 === 'yes') $scores['rosacea'] += 1;

// Total votes for normalization
$total_votes = 9;
$confidences = [];
foreach ($scores as $class => $score) {
    $confidences[$class] = ($score / $total_votes) * 100.0;
}

// Adjust for "better" trend
if ($q10 === 'better') {
    foreach ($confidences as $class => $val) {
        $confidences[$class] = max(0, $val * 0.9);
    }
}

// Labels
$labels = [
    'acne' => 'Acne',
    'dark_circles' => 'Dark Circles',
    'blackheads' => 'Blackheads',
    'rosacea' => 'Rosacea',
    'normal' => 'Normal'
];

// Filter scores for secondary display (votes >= 1)
$filtered_scores = [];
foreach ($scores as $class => $score) {
    if ($score >= 1 && $class !== 'normal') $filtered_scores[$class] = $score;
}

// Determine total non-normal votes
$total_non_normal_votes = array_sum($filtered_scores);

// Determine top concern safely
if ($total_non_normal_votes > 0) {
    arsort($filtered_scores);
    $top_class = key($filtered_scores);
} else {
    $top_class = 'normal';
}

// Determine secondary skin issues (votes >=1, exclude primary)
$secondary_classes = [];
if ($top_class !== 'normal') {
    foreach ($filtered_scores as $class => $score) {
        if ($class !== $top_class && $score >= 1) {
            $secondary_classes[] = $class;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>BareBelle - Analysis Result</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
<style>
body {
    font-family: 'Quicksand', sans-serif;
    background: linear-gradient(135deg, #c3cfea, #f8c8dc);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding-top: 80px;
}
.card {
    background-color: #fff;
    border-radius: 15px;
    box-shadow: 0 12px 35px rgba(0,0,0,0.25);
    padding: 40px 30px;
    max-width: 700px;
    margin: auto;
    text-align: center;
}
h3 { 
    color: #9f5f80; /* same as Primary Concern */
    font-weight: 700;
    margin-bottom: 20px;
}
h4 { 
    color: #9f5f80; 
    font-weight: 700; 
}
.secondary-issues { 
    font-size: 0.9rem; 
    color: #555; 
    margin-top: 5px; 
}

/* Get Product Recommendations button */
.btn-recommendations {
    background-color: #f15a6c;
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
    background-color: #e0485b;
}

/* Back to questionnaire link */
.back-link {
    display: block;
    margin-top: 15px;
    font-size: 0.85rem;
    color: #6f2b4a;
    text-decoration: underline;
}
.back-link:hover {
    color: #f4a7c5;
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
<div class="card">
    <h3>Analysis Result</h3>

    <!-- Primary Concern -->
    <div>
        <h4>Primary Concern: <?php echo htmlspecialchars($labels[$top_class]); ?></h4>
    </div>

    <!-- Secondary Skin Issues -->
    <?php if (!empty($secondary_classes)): ?>
        <div class="secondary-issues">
            Skin Issues: <?php echo implode(', ', array_map(function($c) use($labels){ return $labels[$c]; }, $secondary_classes)); ?>
        </div>
    <?php endif; ?>

    <!-- Get Product Recommendations Button -->
    <div class="mt-4">
        <a href="products.php?skin_issue=<?php echo urlencode($top_class); ?>" 
           class="btn-recommendations">Get Product Recommendations</a>
    </div>

    <!-- Back to Questionnaire Link -->
    <a href="questionnaire.php" class="back-link">Back to Questionnaire</a>

</div>

<footer>© 2025 BareBelle Skincare</footer>
</body>
</html>
