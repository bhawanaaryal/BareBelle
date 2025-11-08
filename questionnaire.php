<?php
session_start();
?>

<?php // questionnaire.php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BareBelle Questionnaire</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Quicksand', sans-serif;
      background: linear-gradient(135deg, #c3cfea, #f8c8dc);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .container-section {
      flex: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 15px;
    }

    .questionnaire-container {
      background-color: #fff;
      border-radius: 12px;
      box-shadow: 0 12px 35px rgba(0,0,0,0.25);
      padding: 40px 30px;
      max-width: 900px;
      width: 100%;
    }

    .question-box {
      background: #ffffff;
      border-radius: 10px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
      padding: 20px;
      margin-bottom: 20px;
    }

    .question-label {
      font-weight: 600;
      color: #9f5f80;
      margin-bottom: 10px;
      display: block;
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

<?php include 'navbar.php'; ?>

 <!-- Questionnaire Section -->
 <div class="container-section">
   <div class="questionnaire-container">
     <h2 class="text-center mb-4" style="color: #9f5f80;">Skin Questionnaire</h2>
     <p class="text-center text-muted mb-5">Answer these quick questions to help us analyze your skin condition.</p>

     <form id="questionnaireForm" action="process_questionnaire.php" method="POST">
       <!-- Q1 -->
       <div class="question-box">
         <label class="question-label">1. How often do you experience acne breakouts?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q1" value="rarely"> Rarely</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q1" value="sometimes"> Sometimes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q1" value="frequently"> Frequently</div>
       </div>

       <!-- Q2 (changed to blackheads) -->
       <div class="question-box">
         <label class="question-label">2. Do you often notice blackheads (small dark bumps) on your nose or chin?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q2" value="yes"> Yes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q2" value="no"> No</div>
       </div>

       <!-- Q3 -->
       <div class="question-box">
         <label class="question-label">3. Do you notice persistent redness on your cheeks, nose, or forehead?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q3" value="yes"> Yes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q3" value="no"> No</div>
       </div>

       <!-- Q4 -->
       <div class="question-box">
         <label class="question-label">4. Do you have dark patches (hyperpigmentation) on your face?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q4" value="yes"> Yes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q4" value="no"> No</div>
       </div>

       <!-- Q5 -->
       <div class="question-box">
         <label class="question-label">5. Do you often have dark circles under your eyes?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q5" value="yes"> Yes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q5" value="no"> No</div>
       </div>

       <!-- Q6 -->
       <div class="question-box">
         <label class="question-label">6. How sensitive is your skin to sunlight?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q6" value="not_sensitive"> Not sensitive</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q6" value="slightly_sensitive"> Slightly sensitive</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q6" value="very_sensitive"> Very sensitive</div>
       </div>

       <!-- Q7 -->
       <div class="question-box">
         <label class="question-label">7. Do you feel your skin gets oily quickly?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q7" value="yes"> Yes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q7" value="no"> No</div>
       </div>

       <!-- Q8 -->
       <div class="question-box">
         <label class="question-label">8. Have you noticed small bumps or pimples that worsen with certain foods or stress?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q8" value="yes"> Yes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q8" value="no"> No</div>
       </div>

       <!-- Q9 -->
       <div class="question-box">
         <label class="question-label">9. Do you often experience itching, burning, or stinging sensations on your skin?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q9" value="yes"> Yes</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q9" value="no"> No</div>
       </div>

       <!-- Q10 -->
       <div class="question-box">
         <label class="question-label">10. Have your symptoms been getting better, worse, or staying the same recently?</label>
         <div class="form-check"><input class="form-check-input" type="radio" name="q10" value="better"> Getting better</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q10" value="same"> Staying the same</div>
         <div class="form-check"><input class="form-check-input" type="radio" name="q10" value="worse"> Getting worse</div>
       </div>

       <button type="submit" class="btn btn-custom w-100 mt-3">Submit Questionnaire</button>
     </form>
   </div>
 </div>

 <!-- Footer -->
 <footer>
   <div class="container">
     &copy; 2025 BareBelle Skincare. All rights reserved.
   </div>
 </footer>

 <!-- Bootstrap JS -->
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 <!-- Validation Script -->
 <script>
   document.getElementById("questionnaireForm").addEventListener("submit", function(event) {
     let totalQuestions = 10;
     for (let i = 1; i <= totalQuestions; i++) {
       let radios = document.getElementsByName("q" + i);
       let answered = Array.from(radios).some(r => r.checked);
       if (!answered) {
         alert("Please answer all questions before submitting.");
         event.preventDefault(); // stop form submission
         return false;
       }
     }
   });
 </script>

</body>
</html>
