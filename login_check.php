<?php
include 'dbconnect.php';
session_start();

$user = mysqli_real_escape_string($link, $_POST['user']); 
$pass = mysqli_real_escape_string($link, $_POST['pass']);

if(isset($_POST["remember"])) {
    setcookie ("user",$_POST["user"],time()+ 3600);
    setcookie ("pass",$_POST["pass"],time()+ 3600);
} else {
    setcookie("user","");
    setcookie("pass","");
}

// First, check what columns exist in the users table
$columns_check = mysqli_query($link, "DESCRIBE users");
$existing_columns = [];
while ($col = mysqli_fetch_assoc($columns_check)) {
    $existing_columns[] = $col['Field'];
}

// Determine the correct username column name
$username_column = 'user_id'; // default fallback
if (in_array('username', $existing_columns)) {
    $username_column = 'username';
} elseif (in_array('user_id', $existing_columns)) {
    $username_column = 'user_id';
} elseif (in_array('email', $existing_columns)) {
    $username_column = 'email';
}

// Determine the correct password column name  
$password_column = 'user_pass'; // default fallback
if (in_array('user_pass', $existing_columns)) {
    $password_column = 'user_pass';
} elseif (in_array('password', $existing_columns)) {
    $password_column = 'password';
}

// Build the query with the correct column names
$query_user = "SELECT * FROM users WHERE $username_column='$user' AND $password_column='$pass'"; 
$result_user = mysqli_query($link, $query_user);

if (!$result_user) {
    // If query fails, try to fix the table structure
    die("Login failed. Please run database_fix.php first to fix table structure.");
}

if(mysqli_num_rows($result_user) <= 0) {
    // No matching user found - redirect back to login
    header("location:login.php?error=invalid");
    exit();
} else {
    // User found - set session and redirect
    $info = mysqli_fetch_array($result_user);
    
    // Set session variables using available columns
    if (isset($info['email'])) {
        $_SESSION['email'] = $info['email'];
    }
    
    // Set user_id from the correct column
    if (isset($info['user_id'])) {
        $_SESSION['user_id'] = $info['user_id'];
    } elseif (isset($info[$username_column])) {
        $_SESSION['user_id'] = $info[$username_column];
    }
    
    header("location:userHomepage.php");
    exit();
}

?>