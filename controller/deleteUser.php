<?
require('../model/db.php');
require('../model/invite.php');

$delete = new Invie;
$delete->email = $_POST['email'];
$allDelete = $delete->deleteUser();

if($allDelete == true){
	echo 1;
} else{
	echo 0;
}
?>