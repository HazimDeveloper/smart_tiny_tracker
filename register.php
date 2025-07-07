<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Smart Tiny Bank Tracker</title>

  <!-- Swiper (optional) -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="register.css" />
</head>
<body>

  <div class="main-container">
    <!-- Header Start -->
    <header class="header">
      <div class="logoContent">
        <a href="#" class="logo"><img src="logo.png" alt="Logo" /></a>
        <h1 class="logoName">Smart Tiny Bank Tracker</h1>
      </div>
      <nav class="navbar">
        <a href="homepage.php">Home</a>
      </nav>
      <div class="icon-search">
        <i class="fas fa-search" id="search"></i>
      </div>
      <div class="search">
        <input type="search" placeholder="Search..." aria-label="Search" />
      </div>
    </header>
    <!-- Header End -->

    <!-- Register form Start -->
    <div class="wrapper">
      <div class="form-box register">
        <h2>REGISTER</h2>
        <?php session_start(); ?>
        <form action="register_check.php" method="post">
          <div class="input-box">
            <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
            <input type="text" name="txtUserId" required aria-label="User ID">
            <label>User ID</label>
          </div>
          <div class="input-box">
            <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
            <input type="password" name="txtPass" required aria-label="Password">
            <label>Password</label>
          </div>
          <div class="input-box">
            <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
            <input type="email" name="txtEmail" required aria-label="Email">
            <label>Email</label>
          </div>

          <button type="submit" class="btn">Register</button>
          <div class="login-register">
            <p>Already have an account? <a href="login.php" class="login-link">Login Now</a></p>
          </div>
        </form>
      </div>
    </div>
    <!-- Register form End -->
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

  <script src="register1.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>