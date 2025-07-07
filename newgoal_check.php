<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

//assign textbox to variable
$addname =$_POST['txtGoalName'];
$addamount=$_POST['txtTargetAmt'];
$addtxtdate=$_POST['txtTargetDate'];
$user_id=$_SESSION['user_id'];

//insert data
$query = "INSERT INTO goal (goal_name,goal_initialamt,goal_due,user_id) VALUES ('$addname','$addamount','$addtxtdate','$user_id')";
$result = mysqli_query($link,$query) or die ("Query failed");

//check either success or not
if($result)
    header("location:userHomepage.php");

mysqli_close($link);
?>