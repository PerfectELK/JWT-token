<?php
require ('../model/db.php');
require ('../model/classreg.php');

$id = $_GET[id];
$confirm = new Registration;

$ready = $confirm->confirmemail($id);

if($ready != NULL){
	echo "<div style=\"position:absolute;top:50%;left:50%;color:#000;font-size:25px;width:1000px;transform:translate(-50%,-50%) \">Регистрация подтверждена, сейчас вы будете перенаправлены на главную страницу</div>";
}else{
	echo "<div style=\"position:absolute;top:50%;left:50%;color:#FF1300FF;font-size:25px;width:1000px;transform:translate(-50%,-50%) \">Неверная ссылка, сейчас вы будете перенаправлены на главную страницу</div>";
}
?>
<script>
	setTimeout('document.location.href="/"',2500);
</script>

