<?php
include 'dbconnect.php';

// assign textbox to variable
$add_user_id=$_POST['txtUserId'];
$add_password=$_POST['txtPass'];
$add_email=$_POST['txtEmail'];

// insert data
$query = "INSERT INTO users (username,user_pass,user_email) VALUES ('$add_user_id','$add_password','$add_email')"; 
$result = mysqli_query ($link,$query) or die ("Query failed");

// checking either sucess or not
if ($result)
    header("location:login.php");
    //echo "ADD SUCCESSFULLY! <a href='login.php'> back to Login Page </a>";
/* else
    echo "Problem occured!"; */
mysqli_close($link);
?>