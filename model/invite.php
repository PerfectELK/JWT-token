<?
require('autorization.php');

class Invie extends Autorization
{
	public function adduser($hash,$link,$userCreate)
	{
		global $db;
		$prepare = $db->prepare("  
			INSERT INTO users (email,phone,role,password,link,done,accestoken,refreshtoken) VALUES (?,?,?,?,?,?,?,?)
			");
		$execute = $prepare->execute(array($this->email,$this->phone,'user',$hash, $link, 0,0,0));

		$prepareinviteuser = $db->prepare("  
			INSERT INTO inviteuser (email,invited) VALUES (?,?)
			");
		$executeinviteuser = $prepareinviteuser->execute(array($this->email,$userCreate));
		return $execute;
	}
	public static function selectUserYouAdd($userCreate)
	{
		global $db;
		$inviteuser = $db->query("  
		SELECT email FROM inviteuser WHERE 	invited = '$userCreate'
			");
		return $inviteuser;
	}
	public function deleteUser()
	{
		global $db;
		$delete = $db->exec("  
		DELETE FROM inviteuser WHERE email = '$this->email'
			");
		$delete1 = $db->exec("  
		DELETE FROM users WHERE email = '$this->email'
			");
		if ($delete && $delete1){
			return true;
		} else{
			return false;
		}
	}
}

?>