<?php
require('../model/db.php');
require('../model/invite.php');


$access = $_COOKIE['Accestoken'];
$refresh = $_COOKIE['Refreshtoken'];
if(!isset($access)){
	Autorization::verifyToken();
	header('Location: /');
}
require('../view/header.php');
$forScript = $db->query("  
	SELECT * FROM users WHERE accestoken = '$access' AND refreshtoken = '$refresh'
		");
foreach ($forScript as $value) {
	$email = $value['email'];
}

$query = $db->query("  
	SELECT id,email, phone, role FROM users WHERE accestoken = '$access' AND refreshtoken = '$refresh'
		");
?>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content invite">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Добавить пользователя</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body ">
	    <table class="table">
			<tr>
				<td></td>
			</tr>
			<tr>
				<td><input type="email" id="email" name="email" placeholder="E-mail" required><div class="checkdiv"><i id="emailtest" class="fas fa-times emailchek"></i></div></td>
			</tr>
			<tr>
				<td><input type="text" id="phone" name="phonenumber" placeholder="Мобильный телефон" required><div class="checkdiv"><i id="phonetest" class="fas fa-times phonechek"></i></div></td>
			</tr>
			<tr>
				<td><input type="password" id="pass" name="password" placeholder="Пароль" required><div class="checkdiv"><i id="passtest" class="fas fa-times passwalid"></i></div></td>
			</tr>
			<tr>
				<td><input type="password" id="pass1" name="password1" placeholder="Повторите пароль" required><div class="checkdiv"><i id="passtest1" class="fas fa-times passident"></i></div></td>
			</tr>
			<tr>
				<td><button class="btn btn-primary"  id="reg" name="reg">Зарегистрировать</button></td>
			</tr>
			<tr>
			<div class="success" id="success">
			</div>	
			</tr>
		</table>
	
<script>
	window.onload = function(){
	var email = document.getElementById('email');
	email.onkeyup = function(event){
		$.ajax({
			url: '/controller/confirmemail.php',
			type: 'POST',
			dataType: 'html',
			data: {email: email.value},
			success: function success(data){
				var email = document.getElementById('email');
				
				var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
				if(data == 1 || email.value.length == 0 || !pattern.test(email.value)){
					$('.emailchek').css('color','#FF1300FF');
					$('.emailchek').removeClass('fa-check');
					$('.emailchek').addClass('fa-times');

				} else if(data == 0){
					$('.emailchek').css('color','#07FF00FF');
					$('.emailchek').addClass('fa-check');
					$('.emailchek').removeClass('fa-times');
					
				}
        }
	});	
 }



 $("#phone").mask("8(999) 999-99 99");

var phone = document.getElementById('phone');
phone.onkeyup = function(){
 	for(var i = 0; i < phone.value.length; i++){
 		if (phone.value[i] == "_"){
 			$('.phonechek').css('color','#FF1300FF');
 			$('.phonechek').removeClass('fa-check');
 			$('.phonechek').addClass('fa-times');
 		} else{
 			$('.phonechek').css('color','#07FF00FF');
 			$('.phonechek').addClass('fa-check');
 			$('.phonechek').removeClass('fa-times');
 		}
 	}
 }

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
	
	if (($('#emailtest').hasClass('fa-times')) || ($('#phonetest').hasClass('fa-times')) || ($('#passtest').hasClass('fa-times')) || ($('#passtest1').hasClass('fa-times')) ){
	var reg = document.getElementById('reg');
	$('#reg').prop("disabled", true);
} else {
	$('#reg').prop("disabled", false);
}
}
setInterval(testButton, 400);

$('#reg').click(function (){
	$.ajax({
			url: '/controller/inviteUser.php',
			type: 'POST',
			dataType: 'html',
			data: {email:  $('#email').val(),
			       phone:  $('#phone').val(),
			       pass:   $('#pass').val(),
			       userCreate: "<? echo $email;?>"

			},
			success: function goReg(data){
				if(data == 1){
				console.log(data);
				$('.success').css('color','#000');
				$('.success').show('slow');
				$('.success').text('Успешно');
				$('.success').delay(3000).hide(1000);
				setTimeout('document.location.href="/"',5000);
			} else{
				console.log(data);
				$('.success').css('color','#FF1300FF');
				$('.success').show('slow');
				$('.success').text('Ошибка');
				$('.success').delay(3000).hide(1000);
			}
		}
	});
});

}
</script>
      </div>
      <div class="modal-footer">
      	<p class="sentemail"></p>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Удалить</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div>
			Пользователь:<br>
			<?php $inviteUser = Invie::selectUserYouAdd($email);?>
			<select class="deleteUser">
				<? foreach($inviteUser as $userInvite):?>
				<option><?echo $userInvite['email']?></option>
				<? endforeach?>
	    	</select>
		</div>
		<div>
			<button class="btn btn-danger" id="delete">Удалить</button>
		</div>
		<div class="suc">
			
		</div>
		<script>
			$('#delete').click(function (){
	$.ajax({
			url: '/controller/deleteUser.php',
			type: 'POST',
			dataType: 'html',
			data: {email:  $('.deleteUser').val()	   
			},
			success: function goReg(data){
				if(data == 1){
				console.log(data);
				$('.suc').css('color','#000');
				$('.suc').show('slow');
				$('.suc').text('Успешно');
				$('.suc').delay(3000).hide(1000);
				setTimeout('document.location.href="/"',5000);
			} else{
				console.log(data);
				$('.suc').css('color','#FF1300FF');
				$('.suc').show('slow');
				$('.suc').text('Ошибка');
				$('.suc').delay(3000).hide(1000);
			}
		}
	});
});
		</script>
      </div>
      <div class="modal-footer">
      	<p class="sentemail"></p>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Пользователи</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<?$allUsers = Registration::selectAllUsers();?>
		<table>
			<tr>
				<th>ID</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Role</th>
			</tr>
			<?foreach ($allUsers as $property): ?>
			<tr>
				<td><? echo $property['id'];?></td>
				<td><? echo $property['email'];?></td>
				<td><? echo $property['phone'];?></td>
				<td><? echo $property['role'];?></td>
			</tr>
			<? endforeach?>
		</table>
		</div>
      	<div class="modal-footer">
      	<p class="sentemail"></p>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>

<div class="container">
	<div class="row">
		<div class="col-12">
			<a href="exit.php" class="exit">Выход</a>
		</div>
	</div>
</div>
<div class="container md-4">
	<div class="row">
		<div class="col-12">
			<h1 style="margin-left: 25%;">
				Управление пользователями
			</h1>
		</div>
	</div>
	<div class="row userinfo">
		<div class="col-md-6">
			<h4>Информация о вас:</h4>
			<? foreach($query as $row):
			   $rights = $row['role'];
			?>

			<div class="row">
				<div class="col-md-12">
					<div><div class="info">ID: </div><div class="info"> <? echo $row['id'];?></div></div>
					<div><div class="info">Email: </div><div class="info"> <? echo $row['email'];?></div></div>
					<div><div class="info">Phone: </div><div class="info"> <? echo $row['phone'];?></div></div>
					<div><div class="info">Role: </div><div class="info"> <? echo $row['role'];?></div></div>	
				</div>
			</div>
		</div>
		<?php if($rights == "admin"){ ?>
		<div class="col-md-6">
			<h4>Вы добавили пользоватлей</h4>
			<?php $YouinviteUser = Invie::selectUserYouAdd($email);?>
			<? foreach($YouinviteUser as $YouuserInvite):?>
				<a href="#"><?echo $userInvite['email']?></a>
			<? endforeach?>
		</div>
		<?}?>
			<? 
			endforeach?>
	</div>
</div>	
<? if($rights == "admin"){
?>	
<div class="container">
	<div class="row">
		<div class="col-md-2.5">
			<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
				Добавить пользователя
			</button>
		</div>
		<div class="col-md-3">
			<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal1">
				Удалить пользователя
			</button>
		</div>	
	</div>
	<div class="row mt-2">
		<div class="col-md-2.5">
			<button class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2">
				Показать всех пользователей
			</button>
		</div>
	</div>
</div>		
<?
}
require('../view/footer.php');
?>