<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: addmoney.php?error=unauthorized");
    exit();
}

// Debug: See what's received
echo '<pre>';
print_r($_POST);
echo '</pre>';

$user_id = $_SESSION['user_id'];

// Validate input
$goal_id = $_POST['goal_id'] ?? null;
$category = $_POST['category'] ?? null;
$amount = $_POST['amount'] ?? null;

if ($goal_id <= 0 || $amount <= 0 || !$category) {
    header("Location: usemoney.php?goal_id={$goal_id}&error=invalid");
    exit();
}

// Get current amount from the goal
$query = "SELECT goal_initialamt, goal_curramt FROM goal WHERE goal_id = $goal_id AND user_id = $user_id";
$result = mysqli_query($link, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: usemoney.php?goal_id={$goal_id}&error=notfound");
    exit();
}

$row = mysqli_fetch_assoc($result);
$current = (float)$row['goal_curramt'];
$newcurrent = $current - $amount;
$goal_balance = $row['goal_initialamt'] - $newcurrent;

// Insert transaction into `cashflow` table
$queryCF = "INSERT INTO cashflow (user_id, goal_id, category, amount) 
            VALUES ('$user_id', '$goal_id', '$category', '$amount')";
$resultCF = mysqli_query($link, $queryCF);

if (!$resultCF) {
    die("Failed to insert into cashflow: " . mysqli_error($link));
}

// Update goal amounts
$updateGoal = "UPDATE goal
               SET goal_curramt = $newcurrent,
                   goal_balance = $goal_balance
               WHERE goal_id = $goal_id AND user_id = $user_id";

$resultUpdate = mysqli_query($link, $updateGoal);

if (!$resultUpdate) {
    die("Failed to update goal: " . mysqli_error($link));
}

// Optional: Get updated balance again (if needed)
$balanceResult = mysqli_query($link, "SELECT goal_balance FROM goal WHERE goal_id = $goal_id AND user_id = $user_id");
$goalBalance = 0;
if ($balanceResult && $balanceRow = mysqli_fetch_assoc($balanceResult)) {
    $goalBalance = $balanceRow['goal_balance'];
}

mysqli_close($link);

// Redirect to `cashflow.php` with success data
header("Location: cashflow.php?goal_id=" . urlencode($goal_id) . 
       "&used=" . urlencode($amount) . 
       "&balance=" . urlencode($newcurrent));
exit();
?>
