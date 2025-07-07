<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker</title>

  <!-- Swiper (optional) -->
  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="login.css" />
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

    <!-- Login form Start-->
    <div class="wrapper">
      <div class="form-box login">
        <h2>LOGIN</h2>
        
        <!-- Error Messages -->
        <?php if (isset($_GET['error'])): ?>
          <div style="background: #ffe6e6; color: #d32f2f; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <?php if ($_GET['error'] == 'invalid'): ?>
              <strong>❌ Login Failed!</strong><br>
              Invalid username or password. Please try again.
            <?php elseif ($_GET['error'] == 'unauthorized'): ?>
              <strong>⚠️ Access Denied!</strong><br>
              Please log in to continue.
            <?php else: ?>
              <strong>❌ Error!</strong><br>
              Something went wrong. Please try again.
            <?php endif; ?>
          </div>
        <?php endif; ?>
        
        <!-- Success Messages -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 'registered'): ?>
          <div style="background: #e8f5e8; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px; text-align: center;">
            <strong>✅ Registration Successful!</strong><br>
            You can now log in with your credentials.
          </div>
        <?php endif; ?>
        
        <form name="login" method="post" action="login_check.php">
          <div class="input-box">
            <span class="icon"><ion-icon name="person-circle-outline"></ion-icon></span>
            <input type="text" name="user" id="user" required aria-label="User ID" value="<?php if(isset($_COOKIE["user"])) { echo htmlspecialchars($_COOKIE["user"]); } ?>">
            <label>User ID</label>
          </div>
          <div class="input-box">
            <span class="icon"><ion-icon name="lock-closed-outline"></ion-icon></span>
            <input type="password" name="pass" id="pass" required aria-label="Password" value="<?php if(isset($_COOKIE["pass"])) { echo htmlspecialchars($_COOKIE["pass"]); } ?>">
            <label>Password</label>
          </div>

          <div style="display: flex; align-items: center; margin: 15px 0;">
            <input type="checkbox" name="remember" id="remember" style="margin-right: 8px;">
            <label for="remember" style="color: #04182d; font-size: 1rem; cursor: pointer;">Remember me</label>
          </div>

          <div class="forgotPass">
            <a href="forgotPass.php">Forgot Password?</a>
          </div>

          <button type="submit" class="btn">Login</button>
          <div class="login-register">
            <p>Don't have an account? <a href="register.php" class="register-link">Register</a></p>
          </div>
        </form>
        
      </div>
    </div>
    <!-- Login form End -->
  </div> <!-- End of .main-container -->

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

  <script src="login.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>