<?php
include 'dbconnect.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);
$goalId = $_GET['goal_id'] ?? null;
$goalName = "Select a Goal"; // fallback
$showGoalSelector = false;

// If no goal_id provided or goal_id is empty, show goal selector
if (!$goalId || $goalId == '') {
    $showGoalSelector = true;
} else {
    // Try to get the specific goal
    $goalId = (int)$goalId;
    $query = "SELECT goal_name, goal_initialamt, goal_curramt, goal_balance FROM goal WHERE goal_id = $goalId AND user_id = '$user_id'";
    $result = mysqli_query($link, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $goalName = $row['goal_name'];
    } else {
        // Goal not found, show selector
        $showGoalSelector = true;
        $goalId = null;
    }
}

// Get all user goals for the selector
$userGoals = [];
$goalsQuery = "SELECT goal_id, goal_name, goal_initialamt, goal_curramt, goal_balance FROM goal WHERE user_id = '$user_id' ORDER BY goal_name";
$goalsResult = mysqli_query($link, $goalsQuery);
if ($goalsResult) {
    while ($goalRow = mysqli_fetch_assoc($goalsResult)) {
        $userGoals[] = $goalRow;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker</title>

  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="usemoney.css" />
</head>

<body>

  <header class="header">
    <div class="logoContent">
      <a href="#" class="logo"><img src="logo.png" alt="Logo" /></a>
      <h1 class="logoName">Smart Tiny Bank Tracker</h1>
    </div>

    <nav class="navbar">
      <a href="userHomepage.php">Home</a>
      <a href="extend.php">Extend Goal</a>
    </nav>

    <div class="icon-and-login">
      <i class="fas fa-search" id="search"></i>
      <button id="logoutChoiceBtn" class="btnLogout-popup">Logout</button>
    </div>

    <div class="search">
      <input type="search" placeholder="Search..." />
    </div>
  </header>
  
  <main class="use-container">
    
    <?php if ($showGoalSelector): ?>
    <!-- Goal Selection Section -->
    <h1 class="goal-title">SELECT A GOAL</h1>
    
    <?php if (empty($userGoals)): ?>
        <div class="form-box">
            <h2>NO GOALS FOUND</h2>
            <p style="font-size: 2rem; color: #04182d; text-align: center; margin: 2rem 0;">
                You don't have any goals yet. Please create a goal first.
            </p>
            <div style="text-align: center;">
                <a href="userHomepage.php#newgoal" style="background: #04182d; color: white; padding: 1rem 2rem; text-decoration: none; border-radius: 10px; font-size: 1.8rem;">
                    Create Your First Goal
                </a>
            </div>
        </div>
    <?php else: ?>
        <div class="form-box">
            <h2>CHOOSE A GOAL TO RECORD SPENDING</h2>
            <div style="display: grid; gap: 2rem; margin-top: 3rem;">
                <?php foreach ($userGoals as $goal): ?>
                <div class="goal-option" style="border: 2px solid #04182d; border-radius: 15px; padding: 2rem; cursor: pointer; transition: all 0.3s;" 
                     onclick="selectGoal(<?= $goal['goal_id'] ?>)">
                    <h3 style="color: #04182d; font-size: 2.5rem; margin-bottom: 1rem;"><?= htmlspecialchars($goal['goal_name']) ?></h3>
                    <p style="font-size: 2rem; color: #04182d;">
                        <strong>Target:</strong> RM <?= number_format($goal['goal_initialamt'], 2) ?><br>
                        <strong>Available:</strong> RM <?= number_format($goal['goal_curramt'], 2) ?><br>
                        <strong>Remaining:</strong> RM <?= number_format($goal['goal_balance'], 2) ?>
                    </p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    
    <?php else: ?>
    <!-- Use Money Form Section -->
    <form action="usemoney_check.php" method="post">
        <input type="hidden" name="goal_id" value="<?= htmlspecialchars($goalId) ?>">
        <h1 class="goal-title"><?= htmlspecialchars($goalName) ?></h1>
        
        <div class="form-box">
            <h2>RECORD YOUR TRANSACTION</h2>

            <div class="category">
                <label><strong>Choose Category</strong></label>
                <div class="radio-options">
                    <label><input type="radio" name="category" value="Foods" required /> Foods</label>
                    <label><input type="radio" name="category" value="Entertainment" /> Entertainment</label>
                    <label><input type="radio" name="category" value="Transportation" /> Transportation</label>
                    <label><input type="radio" name="category" value="Bill & Utilities" /> Bill & Utilities</label>
                    <label><input type="radio" name="category" value="Others" /> Others</label>
                </div>
            </div>

            <div class="amount">
                <label><strong>Enter Amount</strong></label>
                <input type="number" name="amount" placeholder="RM 200" step="0.01" min="0.01" required />
            </div>

            <button type="submit" class="submit-btn">SUBMIT</button>
        </div>
    </form>
    <?php endif; ?>
  </main>

  <!-- Footer Start -->
  <footer class="footer" id="contact">
  <div class="footer-main">
    <div class="footer-column">
      <h3>Smart Tiny Bank Tracker</h3>
      <p>Simplify your financial journey with ease and clarity.</p>
    </div>
    <div class="footer-column">
      <h3>Quick Links</h3>
      <a href="userHomepage.php">Home</a>
      <a href="extend.php">Extend Goal</a>
    </div>
    <div class="footer-column">
      <h3>Get in Touch</h3>
      <p>Email: support@smartbank.com</p>
      <p>Phone: +6012-3456789</p>
      <p>Address: Kuala Lumpur, Malaysia</p>
    </div>
    <div class="footer-column">
      <h3>Follow Us</h3>
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <p>&copy; 2025 Smart Tiny Bank Tracker. All Rights Reserved.</p>
  </div>
</footer>

  <!-- Footer End -->
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  
  <script>
  const searchIcon = document.getElementById('search');
  const searchBox = document.querySelector('.search');

  searchIcon.addEventListener('click', () => {
    searchBox.classList.toggle('active');
  });

  document.getElementById('logoutChoiceBtn').addEventListener('click', function() {
      window.location.href = 'logout.php';
  });

  function selectGoal(goalId) {
      window.location.href = 'usemoney.php?goal_id=' + goalId;
  }

  // Add hover effects to goal options
  document.querySelectorAll('.goal-option').forEach(option => {
      option.addEventListener('mouseenter', function() {
          this.style.backgroundColor = '#f0f8ff';
          this.style.transform = 'scale(1.02)';
      });
      
      option.addEventListener('mouseleave', function() {
          this.style.backgroundColor = 'transparent';
          this.style.transform = 'scale(1)';
      });
  });

  // Form validation
  document.addEventListener('DOMContentLoaded', function() {
      const form = document.querySelector('form');
      
      if (form) {
          form.addEventListener('submit', function(e) {
              const category = document.querySelector('input[name="category"]:checked');
              const amount = document.querySelector('input[name="amount"]').value;
              
              if (!category) {
                  e.preventDefault();
                  alert('Please select a category.');
                  return;
              }
              
              if (!amount || amount <= 0) {
                  e.preventDefault();
                  alert('Please enter a valid amount.');
                  return;
              }
          });
      }
  });
  </script>
</body>
</html>