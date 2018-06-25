<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Восстановление пароля</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	    <table style="margin: 0 auto;border-collapse: separate; text-align: center;">
	        <tr>
				<td><input type="email" id="emailforget" name="email" placeholder="E-mail" required><div class="checkdiv"><i id="emailtest" class="fas fa-times emailchek"></i></div></td>
			</tr>
			<tr>
				<td><button class="btn btn-primary"  id="forget" name="login" disabled="true">Восстановить пароль</button></td>
			</tr>
		</table>
		<script>
			var emailforget = document.getElementById('emailforget');
			emailforget.onkeyup = function(event){
			$.ajax({
			url: 'controller/confirmemail.php',
			type: 'POST',
			dataType: 'html',
			data: {email: emailforget.value},
			success: function success(data){
				var emailforget = document.getElementById('emailforget');
				
				var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,4}\.)?[a-z]{2,4}$/i;
				if(data == 1){
					console.log(data);
					$('.emailchek').css('color','#07FF00FF');
					$('.emailchek').addClass('fa-check');
					$('.emailchek').removeClass('fa-times');
					$('#forget').prop("disabled", false);
					
					
				} else if(data == 0){
					console.log(data);
					$('.emailchek').css('color','#FF1300FF');
					$('.emailchek').removeClass('fa-check');
					$('.emailchek').addClass('fa-times');
					$('#forget').prop("disabled", true);

					
				}
        	}
		});	
 	}
 			var buttonforget = document.getElementById('forget');
 			buttonforget.onclick = function(){
 				$.ajax({
			url: 'controller/restore.php',
			type: 'POST',
			dataType: 'html',
			data: {email: $('#emailforget').val()},
			success: function success(data){
				if(data == 1){
					console.log(data);
					$(".sentemail").css('color', '#1CF20CFF');
					$(".sentemail").html("Сообщение отправлено на вашу почту");
					$(".sentemail").delay(1000).hide('1200');
					$('#emailforget').val('');
				} else{
					$(".sentemail").css('color', '#FF1200FF');
					$(".sentemail").html("Произошла ошибка");
					$(".sentemail").delay(1000).hide('1200');
					$('#emailforget').val('');
				}
			}

		});
 			};
		</script>
      </div>
      <div class="modal-footer">
      	<p class="sentemail"></p>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
      </div>
    </div>
  </div>
</div>
<form action="/personalroom/confirm.php" method="POST">
<table class="table_login">
		<tr>
			<th>Войти в учетную запись</th>
		</tr>
		<tr>
			<td>
				
			</td>
		</tr>
		<tr>
			<td><input type="email" id="emailLogin" name="email" placeholder="E-mail" required><div class="checkdiv"></div></td>
		</tr>
		<tr>
			<td><input type="password" id="passLogin" name="password" placeholder="Пароль" required><div class="checkdiv"></div></td>
		</tr>
		<tr>
			<td><button class="btn btn-primary"  id="login" name="login">Войти</button></td>
		</tr>
		<tr>
			<td><a href="?id=reg">Еще не зарегистрированы?</a></td>
		</tr>
		<tr>
			<td><a href="#exampleModal" data-toggle="modal" data-target="#exampleModal">Забыли пароль.</a></td>
		</tr>
		<tr>
			<td style="color:#F6080CFF;font-size: 30px;"><? echo $_SESSION['error'];?></td>
		</tr>
	</table>
</form>
<? unset($_SESSION['error']);?>