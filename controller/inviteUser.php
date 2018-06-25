<?
require('../model/db.php');
require('../model/invite.php');

require ('../model/phpmailer/PHPMailerAutoload.php');

$reg = new Invie;

$reg->email = $_POST['email'];
$reg->phone = $_POST['phone'];
$reg->password = $_POST['pass'];
$userCreate = $_POST['userCreate'];

if ($reg->phone == '' || !$reg->phone){
	$reg->phone = 0;
}
if ($reg->email == '' || !$reg->email){
	$reg->email = 0;
}
$hash = $reg->hashpass();
$link = $reg::generateLink(30);

$registration = $reg->adduser($hash,$link,$userCreate);
if ($registration){
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
$mail->addAddress("$reg->email");     // Кому будет уходить письмо 
//$mail->addAddress('ellen@example.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');
//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Подтверждение регистрации JWT';
$mail->Body    =  $reg->email . ' Вы зарегистрировались на сайте JWT '. "<br>" .' Для завершения регистрации перейдите по этой ссылке '."<a href=\"http://jwt/confirmemail/?id=$link\">"."http://jwt/confirmemail/?id=".$link."</a>";
$mail->AltBody = '';
$mail->send();
?>
