<?php

require_once 'Db.php';

class Admin extends Db
{
	
	private $dbconn;

	function __construct()
	{
		$this->dbconn = $this->connect();
	}


	// a method that accepts user_id and returns users' details
	public function get_admin_details($user_id)
	{

		try {

		$sql = "SELECT * FROM admin 
				WHERE admin_id = ?";
		$stmt = $this->dbconn->prepare($sql);
		$stmt->execute([$user_id]);;
			$user = $stmt->fetch();
			return $user;
			
		} catch (PDOException $e) {
			// die($e->getMessage());
			return false;
		}
	}

	public function login_admin($username, $password)
	{

		try {

		$sql = "SELECT * FROM admin 
				WHERE admin_name = ?";
		$stmt = $this->dbconn->prepare($sql);
		$stmt->execute([$username]);

		$record = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($record) {
			$saved_hash = $record['admin_password'];
			$rsp = password_verify($password, $saved_hash);

			if ($rsp) {
				$_SESSION['admin_online'] = $record['admin_id'] ;
				return true;
			} else {
				$_SESSION['error_msg'] = 'invalid password';
				return false;
			}
		} else{
			$_SESSION['error_msg'] = 'invalid username';
			return false;
			}
		} catch (PDOException $e) {
			// die($e->getMessage());
			return false;		
		}
	}

	//method to logout user
	public function logout()
	{
		session_unset();
		session_destroy();
		//session_regenerate_id(true);
	}


}
