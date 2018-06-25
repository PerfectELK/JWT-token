<?
require ('../model/db.php');
require ('../model/classreg.php');

$restorepass = new Registration;
$restorepass->password = $_POST['pass'];
$linkres = $_POST['linkres'];
$hash = $restorepass->hashpass();

$restart = $restorepass->resetpass($linkres,$hash);

if($restart){
	echo 1;
}else{
	echo 0;
}
?>