<?php

require_once 'Db.php';

class User extends Db
{
	
	private $dbconn;

	function __construct()
	{
		$this->dbconn = $this->connect();
	}


	public function register_user($username, $email, $password)
	{
		try{

			$sql = "INSERT INTO users (name, email, password_hash) VALUES (?, ?, ?) ";
			$stmt = $this->dbconn->prepare($sql);

			$hashed = password_hash($password, PASSWORD_DEFAULT);

			$stmt->execute([$username, $email, $hashed]);

			$userid = $this->dbconn->lastInsertId();
			return $userid;

		}catch(PDOException $e){
			 die($e->getMessage());
			return false;
		}

	}


	public function check_email($email)
	{

		try {

		$sql = "SELECT * FROM users WHERE email = ?";
		$stmt = $this->dbconn->prepare($sql);
		$stmt->execute([$email]);

		$total = $stmt->rowCount();
		return $total;
		
		} catch (PDOException $e) {
			// die($e->getMessage());
			return false;			
		}

	}


	public function login_user($email, $password)
	{

		try {

		$sql = "SELECT * FROM users WHERE email = ? ";
		$stmt = $this->dbconn->prepare($sql);
		$stmt->execute([$email]);

		$record = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($record) {
			$saved_hash = $record['password_hash'];
			$rsp = password_verify($password, $saved_hash);

			if ($rsp) {
				$_SESSION['is_logged_in'] = $record['user_id'] ;
				return true;
			} else {
				$_SESSION['error_msg'] = 'invalid password';
				return false;
			}

		} else{
			$_SESSION['error_msg'] = 'invalid username';
			return false;
			}
		}catch (PDOException $e) {
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


	public static function authenticate($pdo, $email, $password)
    {
        $sql = "SELECT *
                FROM users  
                WHERE email = :email";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->execute();
        $user_pass = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user_pass) {
       		$saved_hash = $user_pass['password_hash'];
			$res = password_verify($password, $saved_hash);

			if ($res){
			$_SESSION['is_logged_in'] = $user_pass['user_id'] ;
			return true;
			}  else {
				$_SESSION['error_msg'] = 'invalid password';
				return false;
			}
        } else{
			$_SESSION['error_msg'] = 'invalid username';
			return false;
			}
    
    }

	// a method that accepts user_id and returns users' details
	public function get_user_details($user_id)
	{

		try {

			$sql = "SELECT * FROM users WHERE user_id = ?";
			$stmt = $this->dbconn->prepare($sql);
			$stmt->execute([$user_id]);
			$user = $stmt->fetch();
			return $user;
			
		} catch (PDOException $e) {
			// die($e->getMessage());
			return false;
		}

	}

	public function uploadPic( 
			$file_error, 
            $filesize, 
            $filename, 
            $filetmp )
	{

		try {
			if ($file_error > 0) {
				$_SESSION['error_msg'] = 'error uploading file';
				return false;
			}
			if ($filesize > 2097152) {
				$_SESSION['error_msg'] = 'file too big';
				return false;
			}


			$ext_accepted = ["jpeg", "jpg", "png"];
			$fileinfo = explode(".", $filename);
			$user_ext = strtolower(end($fileinfo));

			if (!in_array($user_ext, $ext_accepted) ) {
            	$_SESSION['error_msg'] = 'file format not accepted, only (jpeg, jpg and png)';
				return false;
            }

            ////

        $uniq_filename = "blogit".'_'.time().'_'.uniqid().'.'.$user_ext;
        
        $file_destination = "../uploads/$uniq_filename";

        $response = move_uploaded_file($filetmp, $file_destination );
        return $uniq_filename;

		} catch (Throwable $e) {
			return false;
		}


	}

	public function update_profile($name, $bio, $user_id)
	{
		// echo  $name, $bio, $user_id ;
		// exit();
	
		$sql = "UPDATE users SET name = ?, bio = ? WHERE user_id = ?";
		 
		$stmt = $this->dbconn->prepare($sql);
		$res = $stmt->execute([$name, $bio, $user_id]);
		return $res;
	}
	


}