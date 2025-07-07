<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

//assign textbox to variable
$addrevcomm=mysqli_real_escape_string($link, $_POST['txtrevcomm']);
$addrevname=mysqli_real_escape_string($link, $_POST['txtrevname']);
$user_id = $_SESSION['user_id'];

//insert data
$query = "INSERT INTO review (review_comment,review_name,user_id) VALUES ('$addrevcomm','$addrevname','$user_id')";
$result = mysqli_query($link,$query) or die ("Query failed");

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