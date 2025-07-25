<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker</title>

  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="adminHomepage.css" />
</head>
<body>

  <header class="header">
    <div class="logoContent">
      <a href="#" class="logo"><img src="logo.png" alt="Logo" /></a>
      <h1 class="logoName">Smart Tiny Bank Tracker</h1>
    </div>

    <nav class="navbar">
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
  <div class="background">
    <div class="top-buttons">
      <button class="btn">Dashboard</button>
      <button class="btn notification">
        Notification <span class="badge">2</span>
      </button>
      <button class="btn">Review</button>
    </div>
    <div class="welcome">
      <h1>WELCOME BACK</h1>
      <h1>ADMIN SYAHILAH!</h1>
    </div>
  </div>
  
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

  <script src="adminHomepage.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>