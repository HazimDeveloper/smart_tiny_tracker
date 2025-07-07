<?php
session_start();
include 'dbconnect.php';

// Redirect if user not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);
$goal_id = isset($_GET['goal_id']) ? (int)$_GET['goal_id'] : null;
$used = isset($_GET['used']) ? floatval($_GET['used']) : null;
$balance = isset($_GET['balance']) ? floatval($_GET['balance']) : null;
$recent_category = isset($_GET['category']) ? $_GET['category'] : null;

// Get goal name if goal_id is provided
$goal_name = "All Goals";
if ($goal_id) {
    $goal_query = "SELECT goal_name FROM goal WHERE goal_id = $goal_id AND user_id = '$user_id'";
    $goal_result = mysqli_query($link, $goal_query);
    if ($goal_result && $goal_row = mysqli_fetch_assoc($goal_result)) {
        $goal_name = $goal_row['goal_name'];
    }
}

// Default category totals
$categoryTotals = [
    'Foods' => 0,
    'Entertainment' => 0,
    'Transportation' => 0,
    'Bill & Utilities' => 0,
    'Others' => 0
];

// Check if cashflow table exists, if not create it
$check_table = mysqli_query($link, "SHOW TABLES LIKE 'cashflow'");
if (mysqli_num_rows($check_table) == 0) {
    $create_table = "CREATE TABLE `cashflow` (
        `cashflow_id` int(11) NOT NULL AUTO_INCREMENT,
        `user_id` varchar(100) NOT NULL,
        `goal_id` int(11) NOT NULL,
        `category` varchar(50) NOT NULL,
        `amount` decimal(10,2) NOT NULL,
        `date_created` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`cashflow_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";
    mysqli_query($link, $create_table);
}

// Get cashflow by category with proper SQL escaping
$sql = "SELECT category, SUM(amount) as total 
        FROM cashflow 
        WHERE user_id = '$user_id'";

if ($goal_id) {
    $sql .= " AND goal_id = $goal_id";
}

$sql .= " GROUP BY category";

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

mysqli_close($link);
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
  <h1 class="title">DAILY CASH FLOW - <?= htmlspecialchars($goal_name) ?></h1>

  <?php if ($used !== null && $balance !== null): ?>
  <div class="notification">
    <p><strong>Transaction Recorded Successfully!</strong></p>
    <p>You spent <strong>RM <?= number_format($used, 2) ?></strong> on <strong><?= htmlspecialchars($recent_category) ?></strong></p>
    <p>Remaining goal balance: <strong>RM <?= number_format($balance, 2) ?></strong></p>
  </div>
  <?php endif; ?>

  <div class="cashflow-content">
    <div class="chart-box">
      <canvas id="cashflowChart" width="400" height="400"></canvas>
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
  // PHP data passed to JavaScript
  const cashflowData = [<?= implode(',', array_map('floatval', array_values($categoryTotals))) ?>];
  const categoryLabels = ['<?= implode("','", array_keys($categoryTotals)) ?>'];
  
  console.log('Cashflow Data:', cashflowData);
  console.log('Category Labels:', categoryLabels);
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="cashflow.js"></script>

</body>
</html>