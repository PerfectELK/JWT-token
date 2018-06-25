<?php
session_start();
require('../model/db.php');
require('../model/autorization.php');

$test = new Autorization;
$test->email = $_POST['email'];
$test->password = $_POST['password'];

$readytest = $test->testUser();


if ($readytest){
	$test->GoToken();
	header("location: /personalroom");
}else{
	$_SESSION['error'] = "неверный логин или пароль";
	header('Location: /');
}
	require('../view/footer.php');
?>