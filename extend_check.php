<?php 
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

$user_id=$_SESSION['user_id'];

//validate input
$goal_id=$_POST['goal_id'] ?? null;

// sanitize input (cast to int/float)
$goal_id = (int)$goal_id;

?>