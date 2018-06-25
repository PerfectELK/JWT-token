<?php
class Registration
{
	public $email;
	public $phone;
	public $password;

	public function hashpass()
	{
		$hashpass = password_hash($this->password, PASSWORD_DEFAULT);
		return $hashpass;
	}
	public static function generateLink($length)
	{
  		$chars = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
  		$numChars = strlen($chars);
  		$string = '';
  		for ($i = 0; $i < $length; $i++) {
    		$string .= substr($chars,random_int(1, $numChars) - 1, 1);
  		}
  		return $string;
	}

	public function reguser($hash,$link)
	{
		global $db;
		$prepare = $db->prepare("  
			INSERT INTO users (email,phone,role,password,link,done,accestoken,refreshtoken) VALUES (?,?,?,?,?,?,?,?)
			");
		$execute = $prepare->execute(array($this->email,$this->phone,'admin',$hash, $link, 0,0,0));
		return $execute;
	}
	public function confirmemail($id)
	{
		global $db;
		$confirm = $db->exec("  
			UPDATE users SET done = 1, link = 0 WHERE link = '$id'
		");
		return $confirm;
	}
	public function sendlinkres($link)
	{
		global $db;
		$send = $db->exec("  
			UPDATE users SET linkres = '$link' WHERE email = '$this->email'
		");
		return $send;
	}
	public function resetpass($linkres,$hash)
	{
		global $db;
		$reset = $db->exec("  
			UPDATE users SET password = '$hash' WHERE linkres = '$linkres'
			");
		$db->exec("  
			UPDATE users SET linkres = '0' WHERE linkres = '$linkres'
			");
		return $reset;
	}
	public static function selectAllUsers()
	{
		global $db;
		$select = $db->query("  
			SELECT * FROM users 
			");
		return $select;
	}
}

?>