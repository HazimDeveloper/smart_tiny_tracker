<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker</title>

  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="admindashboard.css" />
</head>
<body>

  <header class="header">
    <div class="logoContent">
      <a href="#" class="logo"><img src="logo.png" alt="Logo" /></a>
      <h1 class="logoName">Smart Tiny Bank Tracker</h1>
    </div>

    <nav class="navbar">
        <a href="adminHomepage.php">Home</a>
      <a href="admindashboard.php">Dashboard</a>
      <a href="adminReview.php">Review</a>
    </nav>

    <div class="icon-and-login">
      <i class="fas fa-search" id="search"></i>
      <button id="logoutChoiceBtn" class="btnLogout-popup">Logout</button>
    </div>

    <div class="search">
      <input type="search" placeholder="Search..." />
    </div>
  </header>

  <!-- start Dashboard Body -->
<div class="dashboard-body">

  <!-- Table Section -->
  <div class="admin-box">
    <h2>LIST OF ADMIN</h2>
    <table>
      <thead>
        <tr>
          <th>NAME</th>
          <th>ROLE</th>
          <th>ADMIN ID</th>
          <th>ACTIVATION</th>
        </tr>
      </thead>
      <tbody id="adminTableBody">
        <!-- pakai js -->
      </tbody>
    </table>
  </div>

  <!-- Task Progress  -->
  <div class="task-box">
    <div class="task-header">
      <h3>TASK COMPLETE</h3>
      <hr />
    </div>
    <div class="donut-chart">
      <div class="centered-text">67%</div>
    </div>
    <p class="target-text">Do we achieve our target?</p>
  </div>

  <!-- Review Today -->
  <div class="review-box">
    <div class="review-icon">💬</div>
    <div class="review-info">
      <p>TODAY'S REVIEW:</p>
      <h3>10</h3>
      <p>TOTAL REVIEWS:</p>
      <h4>15000</h4>
    </div>
  </div>

  <!-- Visit Today -->
  <div class="visit-box">
    <div class="visit-icon">👥</div>
    <div class="visit-info">
      <p>TODAY'S VISTOR:</p>
      <h3>475</h3>
      <p>NEW USER:</p>
      <h4>50</h4>
      <p>EXISTING USER:</p>
      <h4>226005638</h4>
    </div>
  </div>

</div>
<!-- end Dashboard Body -->

  <!-- Footer Start -->
  <footer class="footer">
    <div class="footer-bottom">
      <div class="social-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-twitter"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
      </div>
      <p><br>&copy; 2025 Smart Tiny Bank Tracker. All Rights Reserved.</p>
    </div>
  </footer>
  <!-- Footer End -->

  <script src="admindashboard.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>