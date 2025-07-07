<?php
include 'dbconnect.php';
session_start();

$goalId = $_GET['goal_id'] ?? null;
$goalName = "no goal selected"; // fallback

if ($goalId && isset($_SESSION['user_id'])) {
  $user_id = $_SESSION['user_id'];
  $goalId = (int)$goalId;

  $query = "SELECT goal_name FROM goal WHERE goal_id = $goalId AND user_id = $user_id";
  $result = mysqli_query($link, $query);

  if ($row = mysqli_fetch_assoc($result)) {
        $goalName = $row['goal_name'];
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
    <form id="useMoneyForm" action="usemoney_check.php" method="post">
    <input type="hidden" name="goal_id" value="<?= htmlspecialchars($_GET['goal_id'] ?? '') ?>">
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
          <input type="number" name= "amount" placeholder="RM 200" required />
        </div>

        <button type="submit" class="submit-btn">SUBMIT</button>
      </form>
    </div>
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
  <script src="usemoney.js"></script>
</body>
</html>