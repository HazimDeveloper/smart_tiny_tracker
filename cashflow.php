<?php
session_start();
include 'dbconnect.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$goal_id = isset($_GET['goal_id']) ? (int)$_GET['goal_id'] : null;
$used = isset($_GET['used']) ? floatval($_GET['used']) : null;
$balance = isset($_GET['balance']) ? floatval($_GET['balance']) : null;

// Default category totals
$categoryTotals = [
    'Foods' => 0,
    'Entertainment' => 0,
    'Transportation' => 0,
    'Bill & Utilities' => 0,
    'Others' => 0
];

// Get cashflow by category
$sql = "SELECT category, SUM(amount) as total 
        FROM cashflow 
        WHERE user_id = $user_id" . ($goal_id ? " AND goal_id = $goal_id" : "") . " 
        GROUP BY category";

$result = mysqli_query($link, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cat = $row['category'];
        $total = (float)$row['total'];
        if (isset($categoryTotals[$cat])) {
            $categoryTotals[$cat] = $total;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker</title>
  <link rel="stylesheet" href="cashflow.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
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

<main class="cashflow-container">
  <h1 class="title">DAILY CASH FLOW</h1>

  <?php if ($used !== null && $balance !== null): ?>
  <div class="notification" style="padding: 10px; background-color: #e0ffe0; border: 1px solid #00aa00; margin-bottom: 15px;">
    <p><strong>Transaction Recorded!</strong></p>
    <p>You spent RM <?= number_format($used, 2) ?> on this goal.</p>
    <p>Remaining goal balance: RM <?= number_format($balance, 2) ?></p>
  </div>
  <?php endif; ?>

  <div class="cashflow-content">
    <div class="chart-box">
      <canvas id="cashflowChart"></canvas>
    </div>
    <div class="legend-box">
      <ul id="legendList">
        <?php
        $colors = [
            'Foods' => 'orange',
            'Entertainment' => 'violet',
            'Transportation' => 'red',
            'Bill & Utilities' => 'blue',
            'Others' => 'green'
        ];
        foreach ($categoryTotals as $cat => $amt):
            $color = $colors[$cat];
        ?>
        <li>
          <span class="dot" style="background-color: <?= $color ?>"></span>
          <?= $cat ?><br/>RM <?= number_format($amt, 2) ?>
        </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </div>
</main>

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

<script>
  const cashflowData = [<?= implode(',', array_map('floatval', array_values($categoryTotals))) ?>];
  const categoryLabels = ['<?= implode("','", array_keys($categoryTotals)) ?>'];
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="cashflow.js"></script>

</body>
</html>
