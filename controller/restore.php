<?
require ('../model/db.php');
require ('../model/classreg.php');
require ('../model/phpmailer/PHPMailerAutoload.php');

$restore = new Registration;
$restore->email = $_POST['email'];
$link = $restore::generateLink(31);

$restorego = $restore->sendlinkres($link);

if ($restorego){
	echo 1;
} else{
	echo 0;
}

$mail = new PHPMailer;
$mail->CharSet = 'utf-8';

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mail.ru';  																							// Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = '***'; // Ваш логин от почты с которой будут отправляться письма
$mail->Password = '***'; // Ваш пароль от почты с которой будут отправляться письма
$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 465; // TCP port to connect to / этот порт может отличаться у других провайдеров

$mail->setFrom('***'); // от кого будет уходить письмо?
$mail->addAddress("$restore->email");     // Кому будет уходить письмо 
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Восстановление пароля JWT';
$mail->Body    =  $restore->email . ' Вы забыли пароль '. "<br>" .' Для восстановления пароля перейдите по этой ссылке '."<a href=\"http://jwt/restorepass/?id=$link\">"."http://jwt/restorepass/?id=".$link."</a>";
$mail->AltBody = '';
$mail->send();
?>