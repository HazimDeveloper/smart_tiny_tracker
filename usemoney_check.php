<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?error=unauthorized");
    exit();
}

$user_id = $_SESSION['user_id'];

// Validate input
$goal_id = $_POST['goal_id'] ?? null;
$category = $_POST['category'] ?? null;
$amount = $_POST['amount'] ?? null;

if ($goal_id <= 0 || $amount <= 0 || !$category) {
    header("Location: usemoney.php?goal_id={$goal_id}&error=invalid");
    exit();
}

// Sanitize input
$goal_id = (int)$goal_id;
$amount = (float)$amount;
$category = mysqli_real_escape_string($link, $category);

// Get current amount from the goal
$query = "SELECT goal_initialamt, goal_curramt, goal_balance FROM goal WHERE goal_id = $goal_id AND user_id = $user_id";
$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: usemoney.php?goal_id={$goal_id}&error=notfound");
    exit();
}

$row = mysqli_fetch_assoc($result);
$initial_amount = (float)$row['goal_initialamt'];
$current_amount = (float)$row['goal_curramt'];

// Calculate new amounts (subtract spent amount from current amount)
$new_current_amount = $current_amount - $amount;
$new_balance = $initial_amount - $new_current_amount;

// Insert transaction into cashflow table
$insert_cashflow = "INSERT INTO cashflow (user_id, goal_id, category, amount) 
                    VALUES ('$user_id', '$goal_id', '$category', '$amount')";
$cashflow_result = mysqli_query($link, $insert_cashflow);

if (!$cashflow_result) {
    die("Failed to insert into cashflow: " . mysqli_error($link));
}

// Update goal amounts
$update_goal = "UPDATE goal 
                SET goal_curramt = '$new_current_amount',
                    goal_balance = '$new_balance'
                WHERE goal_id = '$goal_id' AND user_id = '$user_id'";

$update_result = mysqli_query($link, $update_goal);

if (!$update_result) {
    die("Failed to update goal: " . mysqli_error($link));
}

mysqli_close($link);

// Redirect to cashflow.php with success data
header("Location: cashflow.php?goal_id=" . urlencode($goal_id) . 
       "&used=" . urlencode($amount) . 
       "&balance=" . urlencode($new_current_amount) . 
       "&category=" . urlencode($category));
exit();
?>