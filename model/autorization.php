<?php
require('classreg.php');

class Autorization extends Registration
{
	public function testUser()
	{
		global $db;
		$query = $db->query("  
			SELECT email, password, done FROM users WHERE email = '$this->email'
			");
		foreach($query as $row){
			$hash = $row['password'];
			$done = $row['done'];
		}

		if((password_verify($this->password,$hash)) && ($done == 1)){
			return true;
		} else{
			return false;
		}
	}
	public function GoToken()
	{
		global $db;
		$header = [
			"alg" => "HS256",
			"typ" => "JWT"
		];

		$payload = [
			"name" => $this->email,
			"time" => time()
		];

		$payload1 = [
			"name" => $this->email,
			"time" => time()+1000
		];

		$jsonHeader = json_encode($header);

		$jsonpayload = json_encode($payload);
		$jsonpayload1 = json_encode($payload1);

		$sign = (hash_hmac('sha256',base64_encode($jsonHeader).base64_encode($jsonpayload), 'secret'));

		$sign1 = (hash_hmac('sha256',base64_encode($jsonHeader).base64_encode($jsonpayload1), 'secret'));

		$Accestoken = base64_encode($jsonHeader) .".". base64_encode($jsonpayload) .".". $sign;
		$Refreshtoken = base64_encode($jsonHeader) .".". base64_encode($jsonpayload1) .".". $sign1;

		$cookieAccesToken = setcookie('Accestoken',$Accestoken,time() + (15 * 60),"/");

		$cookieRefreshToken = setcookie('Refreshtoken',$Refreshtoken,time() + (30 * 24 * 60 * 60),"/");

		$prepare = $db->prepare("  
			UPDATE users SET accestoken = ?, refreshtoken = ? WHERE email = '$this->email'
			");
		$execute = $prepare->execute(array($Accestoken,$Refreshtoken));
	}
	public static function verifyToken()
	{
		global $db;
		$access = $_COOKIE['Accestoken'];
		$refresh = $_COOKIE['Refreshtoken'];

		if((isset($access)) && (isset($refresh))){

			$query = $db->query("  
				SELECT email FROM users WHERE accestoken = '$access' AND refreshtoken = '$refresh'
				");
			foreach($query as $test){
				$email = $test['email'];
			}
			if (isset($email)){
				$header = [
					"alg" => "HS256",
					"typ" => "JWT"
					];

				$payload = [
					"name" => $email,
					"time" => time()
					];

				$payload1 = [
					"name" => $email,
					"time" => time()+1000
					];

				$jsonHeader = json_encode($header);

				$jsonpayload = json_encode($payload);
				$jsonpayload1 = json_encode($payload1);

				$sign = (hash_hmac('sha256',base64_encode($jsonHeader).base64_encode($jsonpayload), 'secret'));

				$sign1 = (hash_hmac('sha256',base64_encode($jsonHeader).base64_encode($jsonpayload1), 'secret'));

				$Accestoken = base64_encode($jsonHeader) .".". base64_encode($jsonpayload) .".". $sign;
				$Refreshtoken = base64_encode($jsonHeader) .".". base64_encode($jsonpayload1) .".". $sign1;

				$cookieAccesToken = setcookie('Accestoken',$Accestoken,time() + (15 * 60),"/");

				$cookieRefreshToken = setcookie('Refreshtoken',$Refreshtoken,time() + (30 * 24 * 60 * 60),"/");

				$prepare = $db->prepare("  
					UPDATE users SET accestoken = ?, refreshtoken = ? WHERE email = '$email'
				");
				$execute = $prepare->execute(array($Accestoken,$Refreshtoken));

				return true;
			} else{
				return false;
			}
		}elseif(isset($refresh)){

			$query = $db->query("  
				SELECT email FROM users WHERE refreshtoken = '$refresh'
				");
			foreach($query as $test){
				$email = $test['email'];
			}
			if (isset($email)){
				$header = [
					"alg" => "HS256",
					"typ" => "JWT"
					];

				$payload = [
					"name" => $email,
					"time" => time()
					];

				$payload1 = [
					"name" => $email,
					"time" => time()+1000
					];

				$jsonHeader = json_encode($header);

				$jsonpayload = json_encode($payload);
				$jsonpayload1 = json_encode($payload1);

				$sign = (hash_hmac('sha256',base64_encode($jsonHeader).base64_encode($jsonpayload), 'secret'));

				$sign1 = (hash_hmac('sha256',base64_encode($jsonHeader).base64_encode($jsonpayload1), 'secret'));

				$Accestoken = base64_encode($jsonHeader) .".". base64_encode($jsonpayload) .".". $sign;
				$Refreshtoken = base64_encode($jsonHeader) .".". base64_encode($jsonpayload1) .".". $sign1;

				$cookieAccesToken = setcookie('Accestoken',$Accestoken,time() + (15 * 60),"/");

				$cookieRefreshToken = setcookie('Refreshtoken',$Refreshtoken,time() + (30 * 24 * 60 * 60),"/");

				$prepare = $db->prepare("  
					UPDATE users SET accestoken = ?, refreshtoken = ? WHERE email = '$email'
				");
				$execute = $prepare->execute(array($Accestoken,$Refreshtoken));
				return true;
			}else{
				return false;
			}
		}
		

	}
}
?>