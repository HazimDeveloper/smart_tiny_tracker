<?php

include 'dbconnect.php';
session_start(); 							//session_start(); 							

$user = $_POST['user']; 					// assign textbox to variable
$pass = $_POST['pass'];


if(isset($_POST["remember"])) {
	setcookie ("user",$_POST["user"],time()+ 3600);
	setcookie ("pass",$_POST["pass"],time()+ 3600);
	
} else {
	setcookie("user","");
	setcookie("pass","");
}


$query_user = "SELECT * FROM users where username='$user' AND user_pass='$pass'"; 
$result_user = mysqli_query($link,$query_user) or die("Query failed");	// SQL statement for checking
    if(mysqli_num_rows($result_user) <= 0)   			// check either result found or not
	   {
	   header("location:login.php");			// redirect to another page (data not found!)
	   }
    else
	   {
		$info = mysqli_fetch_array($result_user); 	// returns a row from a recordset
	    $_SESSION['email']=$info['email'];	// assign field in username to session [user]
		$_SESSION['user_id']=$info['user_id'];	// assign field in username to session [user]
	
		header("location:userHomepage.php");
	   }

mysqli_close($link);
?>




