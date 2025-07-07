<?php

include 'dbconnect.php';
session_start(); 							//session_start(); 							

$user = $_POST['admin']; 					// assign textbox to variable
$pass = $_POST['pass'];


if(isset($_POST["remember"])) {
	setcookie ("admin",$_POST["admin"],time()+ 3600);
	setcookie ("pass",$_POST["pass"],time()+ 3600);
	
} else {
	setcookie("admin","");
	setcookie("pass","");
}


$query = "SELECT * FROM admin where adminname='$user' AND admin_pass='$pass'"; 
$result = mysqli_query($link,$query) or die("Query failed");	// SQL statement for checking
    if(mysqli_num_rows($result) <= 0)   			// check either result found or not
	   {
	   header("location:adminLogin.php");			// redirect to another page (data not found!)
	   }
    else
	   {
		$info = mysqli_fetch_array($result); 	// returns a row from a recordset
	    $_SESSION['name']=$info['name'];	// assign field in username to session [user]
		$_SESSION['admin_id']=$info['admin_id'];	// assign field in username to session [user]
	
		header("location:adminHomepage.php");
	   }

mysqli_close($link);
?>




