<?php
session_start();
require("model/db.php");
require('model/autorization.php');

$confirm = Autorization::verifyToken();
if($confirm == true){
  header('Location: /personalroom');
}



require("view/header.php");

if($_GET['id'] == ""){
  require("view/content.php");
}elseif($_GET['id'] == "reg") {
  require("view/registration.php");
}elseif($_GET['id'] == "forgetpass"){
  require("view/restore.php");
}
require("view/footer.php");
?>

    
    
    