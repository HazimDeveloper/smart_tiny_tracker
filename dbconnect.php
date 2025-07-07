<?php 

// connection to mySQL
$host= "localhost";         // must be localhost
$username= "root";          // default username
$password= "";              // default is empty
$dbname = "tracker_db";     // db name

// create connection
$link = mysqli_connect($host,$username,$password,$dbname);   

// check connection: procedural
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());   // terminate link & display error messages
}
//echo "Database connected sucessfully";
// assuming $link is your mysqli connection

$current_db_result = mysqli_query($link, "SELECT DATABASE()");

$current_db = mysqli_fetch_row($current_db_result)[0];

//echo "Currently connected to database: " . $current_db;
?>
