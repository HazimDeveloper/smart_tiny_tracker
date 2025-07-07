<?php
session_start();
include 'dbconnect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: addmoney.php?error=unauthorized");
    exit();
}

$user_id=$_SESSION['user_id'];

//validate input
$goal_id=$_POST['goal_id'] ?? null;
$amounttoadd=$_POST['txtamount'] ?? null;

if ($goal_id <= 0 || $amounttoadd <= 0) {
    header("Location: addmoney.php?goal_id=$goal_id&error=invalid");
    exit();
}

// sanitize input (cast to int/float)
$goal_id = (int)$goal_id;
$amounttoadd = (float)$amounttoadd;

//insert data
$query = "SELECT goal_initialamt, goal_curramt, goal_addamt  FROM goal WHERE goal_id = $goal_id AND user_id = $user_id";
$result = mysqli_query($link,$query) or die ("Query failed");

if (!$result || mysqli_num_rows($result) === 0) {
    header("Location: addmoney.php?goal_id=$goal_id&error=notfound");
    exit();
}

$row = mysqli_fetch_assoc($result);

//calculate new values
$newcurramt = $row['goal_curramt'] + $amounttoadd;
$newaddedamt = $amounttoadd;
$newbalance = $row['goal_initialamt'] - $newcurramt;

//update goal
$updateSql = "UPDATE goal
              SET goal_curramt = $newcurramt,
                  goal_addamt = $newaddedamt,
                  goal_balance = $newbalance
              WHERE goal_id=$goal_id AND user_id=$user_id";

mysqli_query($link, $updateSql);

//get updated balance
$balanceResult = mysqli_query($link, "SELECT goal_balance FROM goal WHERE goal_id = $goal_id AND user_id = $user_id");
$goalBalance = 0;
if ($balanceResult && $balanceRow = mysqli_fetch_assoc($balanceResult)) {
    $goalBalance = $balanceRow['goal_balance'];
}

mysqli_close($link);

//redirect back with success and balance
header("Location: addmoney.php?goal_id=$goal_id&success=1&balance=" . urlencode(($newbalance)));
exit();