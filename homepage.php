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
  <link rel="stylesheet" href="homepage.css" />
</head>
<body>

  <!-- Header Start -->
  <header class="header">
    <div class="logoContent">
      <a href="#" class="logo"><img src="logo.png" alt="Logo" /></a>
      <h1 class="logoName">Smart Tiny Bank Tracker</h1>
    </div>

    <nav class="navbar">
      <a href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#services">Our Services</a>
      <a href="#review">Review</a>
      <a href="#contact">Contact</a>
    </nav>

    <div class="icon-and-login">
      <i class="fas fa-search" id="search"></i>
      <button id="loginChoiceBtn" class="btnLogin-popup">Login</button>
    </div>

    <div class="search">
      <input type="search" placeholder="Search..." />
    </div>
  </header>
  <!-- Header End -->

  <!-- Home Section Start -->
  <section class="home" id="home">
    <div class="homeContent">
      <div class="blur-box">
        <h2>WELCOME</h2>
        <p>"Save smart, live better — start with Smart Tiny Bank Tracker!"</p>
      </div>
    </div>
  </section>
  <!-- Home Section End -->

  <!-- About Section Start-->
<section class="about" id="about">
  <div class="heading">
    <h2>About Us</h2>
  </div>

  <div class="swiper about-row">
    <div class="swiper-wrapper">
      <div class="swiper-slide box">
        <img src="g1.png" alt="Group 1">
        <div class="about-content">
          <h3>MISSION</h3>
          <p><br>Our company mission is to help users, especially students and young adults, to manage their finances efficiently by using simple, smart and accessible digital tools.</p>
        </div>
      </div>
      <div class="swiper-slide box">
        <img src="g2.png" alt="Group 2">
        <div class="about-content">
          <h3>VISION</h3>
          <p><br>Our vision to be leading the trusted digital financial platform by providing innovative and smart solutions for managing user's money effortlessly.<br><br></p>
        </div>
      </div>
      <div class="swiper-slide box">
        <img src="g3.png" alt="Group 3">
        <div class="about-content">
          <h3>PROJECT OBJECTIVE</h3>
          <p><br>To design a user-friendly and flexible system that ensures users feel comfortable and restrained while managing their finances<br><br></p>
        </div>
      </div>
      <div class="swiper-slide box">
        <img src="g4.png" alt="Group 4">
        <div class="about-content">
          <h3>PROJECT OBJECTIVE</h3>
          <p><br>To develop a system that enables users to set personal saving goals and monitor their daily financial activities easily.<br><br></p>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
  </div>

  <div class="heading">
    <h2>Meet The Team</h2>
  </div>
  <div class="swiper about-row">
    <div class="swiper-wrapper">
      <div class="swiper-slide box">
        <img src="najihah.png" alt="Najihah">
        <div class="about-content">
          <h3>PROJECT MANAGER</h3>
          <p><br>Nur Najihah binti Yusri<br>Matrix: 2023619314<br>Email: najihah@example.com</p>
        </div>
      </div>
      <div class="swiper-slide box">
        <img src="nuha.png" alt="Nuha">
        <div class="about-content">
          <h3>WEB DESIGNER</h3>
          <p><br>Nurul Nuha Asyikin binti Mohd Fauzi<br>Matrix: 2023623926<br>Email: nuha@example.com</p>
        </div>
      </div>
      <div class="swiper-slide box">
        <img src="ammna.png" alt="Ammna">
        <div class="about-content">
          <h3>PROGRAMMER 1</h3>
          <p><br>Nur Ammna binti Abd Rahim<br>Matrix: 2023657482<br>Email: ammna@example.com</p>
        </div>
      </div>
      <div class="swiper-slide box">
        <img src="syahilah.png" alt="Syahilah">
        <div class="about-content">
          <h3>PROGRAMMER 2</h3>
          <p><br>Noor Syahilah Amirah binti Massuri<br>Matrix: 2023624432<br>Email: syahilah@example.com</p>
        </div>
      </div>
    </div>
    <div class="swiper-pagination"></div>
  </div>
</section>
<!-- About Section End-->

<!-- Our Services Section Start -->
<section class="services" id="services">
  <div class="heading">
    <h1>Our Services</h1>
  </div>
  <div class="swiper services-row">
    <div class="swiper-wrapper">
      <div class="swiper-slide box">
        <div class="img">
          <img src="account.png" alt="Account Service">
        </div>
        <div class="content">
          <h3>Account Management</h3>
          <p>Our system allows users to create a new account or log in into their account. Users need to enter their user ID and password to log in into their account, and enter their user ID, password, and email address to register a new account</p>
        </div>
      </div>
      <div class="swiper-slide box">
        <div class="img">
          <img src="goals.png" alt="Goals Service">
        </div>
        <div class="content">
          <h3>Financial Goals</h3>
          <p>Users can have their own goal setting such as setting a certain amount of money for a trip or paying off debt in their saving goals. Moreover, they are allowed to have multiple goals in one account.</p>
        </div>
      </div>
      <div class="swiper-slide box">
        <div class="img">
          <img src="report.png" alt="Report Service">
        </div>
        <div class="content">
          <h3>Daily Reports</h3>
          <p>Our system will provide a financial summary for the users after they have input their financial activities. It will also notify users when their goals have reached the due date and tell them whether they successfully achieve or failed to achieve it. </p>
        </div>
      </div>
    </div>

    <!-- Swiper Controls -->
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>
</section>
<!-- Our Services Section End -->

<!-- newsletter section start here  -->

    <section class="newsletter">
        <form action="">
            <h3>Subscribe Us For Latest Update Notifications</h3>
            <input type="email" name="" placeholder="enter your email" id="" class="box">
            <input type="button" value="subscribe" class="box2">
        </form>
    </section>
    <!-- newsletter section ends here  -->

    <!-- review section start here  -->
    <section class="review" id="review">
        <div class="heading">
            <h2>Reviews</h2>
        </div>
        <div class=" swiper review-row">
            <div class="swiper-wrapper">
                <div class="swiper-slide box">
                    <div class="client-review">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident, perferendis architecto
                            quasi eveniet aliquam sed?</p>
                    </div>
                    <div class="client-info">
                        <div class="img">
                            <img src="user.png" alt="">
                        </div>
                        <div class="clientDetailed">
                            <h3>Hardy Devid</h3>
                            <p>UI / UX designer</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide box">
                    <div class="client-review">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident, perferendis architecto
                            quasi eveniet aliquam sed?</p>
                    </div>
                    <div class="client-info">
                        <div class="img">
                            <img src="user.png" alt="">
                        </div>
                        <div class="clientDetailed">
                            <h3>Hardy Devid</h3>
                            <p>UI / UX designer</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide box">
                    <div class="client-review">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident, perferendis architecto
                            quasi eveniet aliquam sed?</p>
                    </div>
                    <div class="client-info">
                        <div class="img">
                            <img src="user.png" alt="">
                        </div>
                        <div class="clientDetailed">
                            <h3>Hardy Devid</h3>
                            <p>UI / UX designer</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide box">
                    <div class="client-review">
                        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Provident, perferendis architecto
                            quasi eveniet aliquam sed?</p>
                    </div>
                    <div class="client-info">
                        <div class="img">
                            <img src="user.png" alt="">
                        </div>
                        <div class="clientDetailed">
                            <h3>Hardy Devid</h3>
                            <p>UI / UX designer</p>
                        </div>
                    </div>
                </div>
                <div class="swiper-pagination"></div>

            </div>
        </div>
    </section>
    <!-- review section ends here  -->
     
    <!-- Footer Start -->
  <footer class="footer" id="contact">
  <div class="footer-main">
    <div class="footer-column">
      <h3>Smart Tiny Bank Tracker</h3>
      <p>Simplify your financial journey with ease and clarity.</p>
    </div>
    <div class="footer-column">
      <h3>Quick Links</h3>
      <a href="#home">Home</a>
      <a href="#about">About</a>
      <a href="#services">Our Services</a>
      <a href="#review">Review</a>
      <a href="#">Contact</a>
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

  <!-- Scripts -->
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script src="homepage1.js"></script>

</body>
</html>