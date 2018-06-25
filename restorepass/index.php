<?php
require ('../model/db.php');
require ('../model/classreg.php');

$link = $_GET[id];
$confirm = $db->query("  
	SELECT * FROM users WHERE linkres = '$link'
	");
foreach($confirm as $row){
	$check = $row['linkres'];
}
if($check != NULL){
?>
<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     <link rel="shortcut icon" href="/img/share.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" integrity="sha384-+d0P83n9kaQMCwj8F4RJB66tzIwOKmrdb46+porD/OvrJ+37WqIM7UoBtwHO6Nlg" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <script src="../js/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
    <script src="../js/jquery.maskedinput.min.js"></script>
    <title>JWT</title>
  </head>
  <body>
<table class="table_login">
		<tr>
			<th>Изменить пароль</th>
		</tr>
		<tr>
			<td>
				
			</td>
		</tr>
		<tr>
			<td><input type="password" id="pass" name="password" placeholder="Пароль" required><div class="checkdiv"><i id="passtest" class="fas fa-times passwalid"></i></div></td>
		</tr>
		<tr>
			<td><input type="password" id="pass1" name="password1" placeholder="Повторите пароль" required><div class="checkdiv"><i id="passtest1" class="fas fa-times passident"></i></div></td>
		</tr>
		<tr>
			<td><button class="btn btn-primary"  id="restart" name="restart">Изменить</button></td>
		</tr>
</table>
<div class="succesreset">
	
</div>
<script>
	var pass = document.getElementById('pass');
pass.onkeyup = function(){
	if (pass.value.length < 7){
		$('.passwalid').css('color','#FF1300FF');
		$('.passwalid').removeClass('fa-check');
 		$('.passwalid').addClass('fa-times');
	} else{
		$('.passwalid').css('color','#07FF00FF');
		$('.passwalid').addClass('fa-check');
 		$('.passwalid').removeClass('fa-times');
	}
}
var pass1 = document.getElementById('pass1');
pass1.onkeyup = function(){
	if (pass.value != pass1.value || pass1.value.length < 7){
		$('.passident').css('color','#FF1300FF');
		$('.passident').removeClass('fa-check');
 		$('.passident').addClass('fa-times');
	} else {
		$('.passident').css('color','#07FF00FF');
		$('.passident').addClass('fa-check');
 		$('.passident').removeClass('fa-times');
	}
}

function testButton(){
	
	if (($('#passtest').hasClass('fa-times')) || ($('#passtest1').hasClass('fa-times')) ){
	var restart = document.getElementById('reg');
	$('#restart').prop("disabled", true);
} else {
	$('#restart').prop("disabled", false);
}
}
setInterval(testButton, 400);


$('#restart').click(function(){
	$.ajax({
			url: '../controller/restorepass.php',
			type: 'POST',
			dataType: 'html',
			data: { pass:   $('#pass').val(),
					linkres: "<?php echo $link; ?>"

			},
			success: function goReg(data){
				if(data == 1){
					$('.succesreset').css('color','#000');
					$('.succesreset').show('slow');
					$('.succesreset').text('Пароль успешно изменен');
					$('.succesreset').delay(3000).hide(1000);
					setTimeout('document.location.href="/"',5000);
				}else{
					$('.succesreset').css('color','#FF1300FF');
					$('.succesreset').show('slow');
					$('.succesreset').text('Произошла ошибка, приносим свои извинения');
					$('.succesreset').delay(3000).hide(1000);
				}
			}
});
});
</script>
<?
} else{
	header('location: /');

}
?>