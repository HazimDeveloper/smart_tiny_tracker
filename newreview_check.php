<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

//assign textbox to variable
$addrevcomm = mysqli_real_escape_string($link, $_POST['txtrevcomm']);
$addrevname = mysqli_real_escape_string($link, $_POST['txtrevname']);
$user_id = mysqli_real_escape_string($link, $_SESSION['user_id']);

// Check if review_name column exists, if not add it
$check_column = mysqli_query($link, "SHOW COLUMNS FROM review LIKE 'review_name'");
if (mysqli_num_rows($check_column) == 0) {
    // Add the missing column
    mysqli_query($link, "ALTER TABLE review ADD COLUMN review_name VARCHAR(100) DEFAULT 'Anonymous'");
}

//insert data
$query = "INSERT INTO review (review_comment, review_name, user_id) VALUES ('$addrevcomm', '$addrevname', '$user_id')";
$result = mysqli_query($link, $query) or die ("Query failed: " . mysqli_error($link));

mysqli_close($link);

//check either success or not
if($result)
{
    header("location:userHomepage.php#review?submitted=1");
    exit();
}
else
{
    echo "Error submitting review";
}
?>