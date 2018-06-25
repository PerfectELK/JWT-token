<?php
$cookieAccesToken = setcookie('Accestoken','Accestoken',time()-10,"/");
$cookieRefreshToken = setcookie('Refreshtoken','Refreshtoken',time()-10,"/");

sleep(1);
header("Location: /")
?>