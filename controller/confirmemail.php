<?php
include('../model/db.php');
$email = $_POST['email'];
$test = $db->query("  
	SELECT email FROM users WHERE email = '$email'
	");
foreach ($test as $row){
	$succestest = $row[email];
}
if ($succestest){
	echo 1;
} else{
	echo 0;
}
?>