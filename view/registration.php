<table class="table_login">
		<tr>
			<th>Регистрация:</th>
		</tr>
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
			<td><button class="btn btn-primary"  id="reg" name="reg">Зарегистрироваться</button></td>
		</tr>
	</table>
<div class="successReg" id="successReg">
</div>

<script>
	window.onload = function(){
	var email = document.getElementById('email');
	email.onkeyup = function(event){
		$.ajax({
			url: 'controller/confirmemail.php',
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
			url: 'controller/registration.php',
			type: 'POST',
			dataType: 'html',
			data: {email:  $('#email').val(),
			       phone:  $('#phone').val(),
			       pass:   $('#pass').val()

			},
			success: function goReg(data){
				if(data == 1){
				console.log(data);
				$('.successReg').css('color','#000');
				$('.successReg').show('slow');
				$('.successReg').text('Вы успешно зарегистрировались, пожалуйста, подтвердите свой почтовый ящик, перейдя по ссылке в сообщении');
				$('.successReg').delay(3000).hide(1000);
				setTimeout('document.location.href="/"',5000);
			} else{
				console.log(data);
				$('.successReg').css('color','#FF1300FF');
				$('.successReg').show('slow');
				$('.successReg').text('Произошла ошибка при регистрации, повторите попытку позже, приносим извинения за доставленные неудобства');
				$('.successReg').delay(3000).hide(1000);
			}
		}
	})
});




}
</script>