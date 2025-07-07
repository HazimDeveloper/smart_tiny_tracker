<?php
include 'dbconnect.php';

// If form submitted, insert review into DB
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($link, $_POST['txtrevname']);
    $comment = mysqli_real_escape_string($link, $_POST['txtrevcomm']);

    $query = "INSERT INTO review (review_name, review_comment) VALUES ('$name', '$comment')";
    if (mysqli_query($link, $query)) {
        echo "<p>Review added successfully!</p>";
    } else {
        echo "Error inserting review: " . mysqli_error($link);
    }
}

// Fetch all reviews
$result = mysqli_query($link, "SELECT review_name, review_comment FROM review ORDER BY review_id DESC");
$reviews = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $reviews[] = $row;
    }
} else {
    echo "Error fetching reviews: " . mysqli_error($link);
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head><title>Test Review</title></head>
<body>

<h2>Write a Review</h2>
<form method="post" action="">
  <label>Your Name:<br>
    <input type="text" name="txtrevname" required>
  </label><br><br>

  <label>Your Review:<br>
    <textarea name="txtrevcomm" rows="4" required></textarea>
  </label><br><br>

  <button type="submit">Submit Review</button>
</form>

<hr>

<h2>All Reviews</h2>
<?php if (!empty($reviews)): ?>
  <?php foreach ($reviews as $rev): ?>
    <div style="margin-bottom:1em;">
      <strong><?php echo htmlspecialchars($rev['review_name']); ?></strong><br>
      <em><?php echo htmlspecialchars($rev['review_comment']); ?></em>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>No reviews found.</p>
<?php endif; ?>

</body>
</html>
