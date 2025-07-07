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
  <link rel="stylesheet" href="extend.css" />
</head>
<body>

  <header class="header">
    <div class="logoContent">
      <a href="#" class="logo"><img src="logo.png" alt="Logo" /></a>
      <h1 class="logoName">Smart Tiny Bank Tracker</h1>
    </div>

    <nav class="navbar">
      <a href="userHomepage.php">Home</a>
    </nav>

    <div class="icon-and-login">
      <i class="fas fa-search" id="search"></i>
      <button id="logoutChoiceBtn" class="btnLogout-popup">Logout</button>
    </div>

    <div class="search">
      <input type="search" placeholder="Search..." />
    </div>
  </header>
<div class="background">

    <form action="extend_check.php" method="post">
    <h1 class="title"><?= htmlspecialchars($goalName) ?></h1>
    <input type="hidden" name="goal_id" value="<?= htmlspecialchars($_GET['goal_id']) ?>" /> 

    <div class="extend-box">
      <h2>EXTEND YOUR GOAL<br></h2>

      <label for="goalAmount">GOAL AMOUNT</label>
      <div class="amount-group">
        <input type="text" name="amount" id="goalAmount" value="RM" />
      </div>

      <label for="goalDate">GOAL DUE DATE</label>
      <input type="date" name="date" id="goalDate" value="2026-01-12" />

      <button class="submit-btn" onclick="submitExtend()">SUBMIT ▶️</button>
    </div>

    <div class="tagline">We consent, you enjoy !!</div>

  </div>
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
  <script src="extend.js"></script>
</body>
</html>