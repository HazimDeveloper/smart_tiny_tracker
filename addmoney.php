<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker</title>

  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="addmoney.css" />
</head>

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
  
  <!-- Main content -->
  <main class="add-money-container">
    <form action="addmoney_check.php?goal_id=<?= htmlspecialchars($_GET['goal_id']) ?>" method="post">
    <h1 class="goal-title"><?= htmlspecialchars($goalName) ?></h1>

    <?php if (isset($_GET['error']) && $_GET['error'] === 'notfound'): ?>
      <p style="color: red;">Goal not found or you do not have access.</p>
    <?php elseif (isset($_GET['success']) && $_GET['success'] === '1'): ?>
      <p style="color: green;">Amount successfully added!</p>
    <?php endif; ?>  

    <section class="add-form-box">
      <h2 class="form-title">ADD YOUR MONEY</h2>

      <input type="hidden" name="goal_id" value="<?= htmlspecialchars($_GET['goal_id']) ?>" />
      <label for="amount">ENTER AMOUNT</label>
      <input type="number" name="txtamount" id="amount" placeholder="RM 200" />

      <button type="submit">SUBMIT</button>

      <div id="resultBox" class="result-box">
        <h3>YOU'RE HALF WAY TO GO !!!</h3>
        <div class="summary-box">
          <?php if (isset($_GET['success']) && $_GET['success'] == '1' && isset($_GET['balance'])): ?>
          <p>Remaining Balance: <strong>RM <?= number_format((float)$_GET['balance'], 2) ?></strong></p>
          <?php endif; ?>
        </div>
      </div>
    </section>
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
      <a href="userHomepage.html">Home</a>
      <a href="extend.html">Extend Goal</a>
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
  <script src="addmoney.js"></script>
</body>
</html>