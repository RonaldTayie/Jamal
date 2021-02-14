<?php

class config {

	protected function Connect(){
		$file = dirname(__FILE__)."/init.json";
		if(file_exists($file) & file_get_contents($file) !== null){
			$decode = json_decode(file_get_contents($file),true);
			$server = $decode['server'];
			if($server != null){
				$host = $server['host'];
				$username = $server['username'];
				$password  = $server['password'];
				$database = $server['database'];

				$conn = new mysqli($host,$username,$password,$database);
				if(!$conn){
					return die($conn->error_reporting())."Connection failed";
				}else{
					return $conn;
				}
			}
		}else{}
	}

	//Session Handler to return user details Everytime a user switchs or reloads a page or requests a diffrent page
	protected function sessionHandler($sessID){
		if($sessID != ""){
			//Get database connection
			$conn = self::Connect();
			//Get into the database table loop and hash though all the emails and find a match and get its details
			$SQL = "SELECT * FROM `users`;";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				session_destroy();
				return 0;
			}else{
				mysqli_execute($stmt);
				$query= mysqli_stmt_get_result($stmt);
				if($query){
					if($query->num_rows > 0){
						while($row = mysqli_fetch_assoc($query)){
							$user = $row;

							if(self::Hasher('sess',$user['EmailAddress'])==$sessID){
								return [$sessID,$user];
								break;
							}
						}
					}
				}else{
				}
			}
		}else{
		}
	}

	//Hashing handler function
	protected function Hasher($use,$text){
		if(isset($use)){
			switch ($use) {
				case 'pwd':
					//reverse the hash
					$hash = strrev(hash('whirlpool',$text));
					return $hash;
					break;
				case 'sess':
					//Hash the reverse of the string
					$hash = md5(strrev($text));
					return $hash;
					break;
				case "upload":
					$hash = uniqid(md5(date("HMsDnyyy")),true);
					break;
				case "issue":
					$hash = uniqid(md5(date("HMsDnyyyy"))."_issue",false);
					break;
				default:
					# code...
					break;
			}
			return $hash;
		}
	}
	
	//Handle Regular user login
	protected function loginHandler($array){

		if(isset($array) & $array !=null){

			//Get the connection
			$conn = self::Connect();

			$UsernameEmail = $array[0];
			$pwd = self::Hasher('pwd',$array[1]);

			for ($i=0; $i < strlen($UsernameEmail) ; $i++) {
				if($UsernameEmail[$i]=='@'){
					$type = "EmailAddress";
					break;
				}else{
					$type = "Username";
				}
			}

			$SQL = "SELECT * FROM `users` WHERE `$type` = ? AND `Password`= ? ;";

			$stmt = mysqli_stmt_init($conn);
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Preparation failed";
			}else{
				mysqli_stmt_bind_param($stmt,"ss",$UsernameEmail,$pwd);
				mysqli_execute($stmt);
				$query = mysqli_stmt_get_result($stmt);

				$counter = mysqli_num_rows($query);
				if($counter>0 & $counter<2){
					while($row = mysqli_fetch_assoc($query)){
						$user = $row;
					}
					$_SESSION['sess'] = self::Hasher('sess',$user['EmailAddress']);

					return [$_SESSION,$user];
				}else{
					return "Failed";
				}
			}
		}else{
			return "ret:Loginfailed";
		}
	}

}

?>
