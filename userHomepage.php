<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Smart Tiny Bank Tracker</title>

  <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
  <link rel="stylesheet" href="userHomepage.css" />
</head>

<?php 
session_start(); 
include 'dbconnect.php';

$reviews = [];

// First, check if review_name column exists, if not add it
$check_column = mysqli_query($link, "SHOW COLUMNS FROM review LIKE 'review_name'");
if (mysqli_num_rows($check_column) == 0) {
    // Add the missing column
    mysqli_query($link, "ALTER TABLE review ADD COLUMN review_name VARCHAR(100) DEFAULT 'Anonymous'");
}

// Now safely get reviews
$result = mysqli_query($link, "SELECT review_comment, review_name FROM review ORDER BY review_id DESC LIMIT 5");

if($result)
{
  while($row = mysqli_fetch_assoc($result))
  {
    $reviews[] = $row;
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
      <a href="#home">Home</a>
      <a href="#newgoal">New Goal</a>
      <a href="#review">Review</a>
      <a href="#contact">Contact</a>
    </nav>

    <div class="icon-and-login">
      <i class="fas fa-search" id="search"></i>
      <button id="logoutChoiceBtn" class="btnLogout-popup">Logout</button>
    </div>

    <div class="search">
      <input type="search" placeholder="Search..." />
    </div>
  </header>

  <section class="home" id="home">
    <div class="heading">
      <h2>YOUR GOALS</h2>
    </div>

    <div class="swiper home-row">
      <div class="swiper-wrapper">

        <?php
        include 'dbconnect.php';

        if (isset($_SESSION['user_id'])) {
            $user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);

            //get goals from database for current user
            $sql = "SELECT * FROM goal WHERE user_id = '$user_id'";
            $result = mysqli_query($link, $sql);

            if ($result && mysqli_num_rows($result) > 0):
              while ($row = mysqli_fetch_assoc($result)):
                // optional to change status color
                $status = strtolower($row['goal_status'] ?? 'active');

                if($status == 'succeed') {
                  $statusClass = 'succeed';
                }
                elseif($status == 'failed') {
                  $statusClass = 'failed';
                }
                else {
                  $statusClass = 'hurry';
                }
            ?>

            <div class="swiper-slide box">
              <div class="goal-card" data-goal-id="<?= $row['goal_id'] ?>">
                <h3><?= htmlspecialchars($row['goal_name']) ?></h3>
                <p class="amount"><?php echo number_format($row['goal_initialamt'] ?? 0); ?></p>
                <p class="date"><?php echo date("d F Y", strtotime($row['goal_due'])); ?></p>
                <p class="status <?= $statusClass ?>"><?php echo strtoupper($status); ?> !!</p>
                <!-- tempat categories (need to loop) -->

                <div class="buttons">
                  <button class="track">Track</button>
                  <button class="delete">Delete</button>
                </div>
              </div>
            </div>

            <?php 
              endwhile;
            else:
            ?>
              <div class="swiper-slide box">
                <div class="goal-card">
                  <h3>No Goals Yet</h3>
                  <p>Create your first goal below!</p>
                </div>
              </div>
            <?php
            endif;
        } else {
            echo "<div style='text-align: center; padding: 50px;'>";
            echo "<h3>Please log in to view your goals</h3>";
            echo "<a href='login.php'>Login Here</a>";
            echo "</div>";
        }
        mysqli_close($link);
        ?>

      </div>
    </div>
  </section>

  <!-- New Goal Section -->
<section class="newgoal" id="newgoal">
  <div class="heading">
    <h2>ADD A NEW GOAL</h2>
  </div>
  <form class="newgoal-form" action="newgoal_check.php" method="post">
    <div class="form-group">
      <label for="goal">Goal Name</label>
      <input type="text" name="txtGoalName" id="goal" placeholder="e.g. Buy a Laptop" required />
    </div>

    <div class="form-group">
      <label for="amount">Target Amount</label>
      <input type="number" name="txtTargetAmt" id="amount" placeholder="e.g. 3000" required />
    </div>

    <div class="form-group">
      <label for="date">Target Date</label>
      <input type="date" name="txtTargetDate" id="date" required />
    </div>

    <button type="submit" class="submit-goal">Add Goal</button>
  </form>
</section>

<!-- Review Section -->
<section class="review" id="review">
  <div class="heading">
    <h2>WRITE YOUR REVIEW</h2>
  </div>
  <div class="review-grid">
    <div class="user-testimonials">
      <?php if(!empty($reviews)): ?>
        <?php foreach ($reviews as $rev): ?>
          <div class ="testimonial">
            <p>"<?php echo htmlspecialchars($rev['review_comment']); ?>"</p>
            <h4>— <?php echo htmlspecialchars($rev['review_name'] ?? 'Anonymous'); ?></h4>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div class="testimonial">
          <p>"Great app for tracking savings!"</p>
          <h4>— Sample User</h4>
        </div>
      <?php endif; ?>
    </div>
    <div class="review-form-container">
      <form class="review-form" action="newreview_check.php" method="post">
        <div class="form-group">
          <label for="name">Your Name</label>
          <input type="text" name="txtrevname" id="name" placeholder="Enter your name" required />
        </div>

        <div class="form-group">
          <label for="comment">Your Review</label>
          <textarea id="comment" name="txtrevcomm" rows="5" placeholder="Write your feedback..." required></textarea>
        </div>

        <div class="form-group">
          <label>Rating</label>
          <div class="star-rating">
  <input type="radio" id="star5" name="rating" value="5"><label for="star5">★</label>
  <input type="radio" id="star4" name="rating" value="4"><label for="star4">★</label>
  <input type="radio" id="star3" name="rating" value="3"><label for="star3">★</label>
  <input type="radio" id="star2" name="rating" value="2"><label for="star2">★</label>
  <input type="radio" id="star1" name="rating" value="1"><label for="star1">★</label>
</div>
<p id="ratingValue" style="font-size: 1.5rem; margin-top: 0.5rem;"></p>

        </div>

        <button type="submit" class="submit-review">Submit Review</button>
      </form>
    </div>
  </div>
</section>

<!-- Track Action Modal -->
<div class="track-modal" id="trackModal">
  <div class="modal-content">
    <span class="close-modal" onclick="closeModal()">&times;</span>
    <h2>What would you like to do?</h2>
    <div class="modal-buttons">
  <button id="addMoneyBtn">Add Money</button>
  <button id="useMoneyBtn">Use Money</button>
</div>
  </div>
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
      <a href="#home">Home</a>
      <a href="#newgoal">New Goal</a>
      <a href="#review">Review</a>
      <a href="#contact">Contact</a>
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
  <script src="userHomepage1.js"></script>
</body>
</html>