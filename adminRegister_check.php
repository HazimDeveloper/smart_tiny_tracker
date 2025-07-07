<?php
include 'dbconnect.php';
session_start();

// assign textbox to variable
$adminID=$_POST['txtAdminID'];
$password=$_POST['txtPass'];
$email=$_POST['txtEmail'];

// insert data
$query = "INSERT INTO admin (adminname, admin_pass, admin_email) VALUES ('$adminID', '$password', '$email')"; 
$result = mysqli_query ($link,$query) or die ("Query failed");

// checking either sucess or not
if ($result)
{
    header("location:adminLogin.php");
    //alert("Congratulations! You've successfully registered!");
}
/* else
    die("Query failed: " . mysqli_error($link)); */
mysqli_close($link);
?>