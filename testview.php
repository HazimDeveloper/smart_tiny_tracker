<?php
include 'dbconnect.php';


// insert data
$query = "SELECT * FROM users"; 
$result = mysqli_query ($link,$query) or die ("Query failed");
?>
<table>
<?php 
//data looping
foreach($result as $row){ ?>
  <tr>
    <td><?php echo $row['email'];?></td>
</tr>
</table>
<?php
mysqli_close($link);
}
?>