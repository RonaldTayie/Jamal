<?php
require("config.php");

class controller extends config{
	//get all the data from the init file
	public function file(){
		$file = dirname(__FILE__)."\init.json";
		if(file_exists($file)  & file_get_contents($file) != null){
			return json_decode(file_get_contents($file),true);
		}else{
		}
	}

	public function login($data){
		if($data != null){
			return self::loginHandler($data);
		}
	}

	public function session($sessionValue){
		if ($sessionValue != null & strlen($sessionValue) > 11) {
			return self::sessionHandler($sessionValue);
		}else{}
	}

	public function _add_user($array){
		return self::SignupHandler($array);
	}

	//View handling

	private function getView($View){
		if(isset($View)){
			$View = strtolower($View);
			$Views = explode("/",self::file()['Views']['Views']);
			$dir = "Views/";
			$ext = ".php";
			for($i = 0;$i < sizeof($Views);$i++){
				if($View == $Views[$i]){
					$SetView = $dir.$Views[$i].$ext;
					break;
				}else{
					$SetView = $dir.'Error'.$ext;
				}
			}
			return $SetView;
		}
	}

	//View controls and rendering
	public function View($View){
		$Home_Views = ['dashboard','home','index'];
		if(in_array(strtolower($View), $Home_Views)){
			return self::getView('dashboard');
		}else{
			return self::getView($View);
		}
	}

	//////////////////////////////////////
	/////////////////////////////////
		////////////////////////////////

		#project management
		# C R U D Project data

		public function _load_project($p){
			//get connection
			$conn = self::Connect();
			$stmt = mysqli_stmt_init($conn);
			if($p =='all'){
				$SQL = "SELECT * FROM `projects`;";
				$q = $conn->query($SQL);
				if($q){
					if($q->num_rows > 0){
						while ($r = $q->fetch_assoc()) {
							$d[]= $r;
						}
						return json_encode($d);
					}
				}else{
					return null;
				}
			}else if(strlen($p)>6){
				$SQL = "SELECT * FROM `projects` WHERE `PID` = ? ;";
				if(!mysqli_stmt_prepare($stmt,$SQL)){
					return null;
				}else{
					mysqli_stmt_bind_param($stmt,"s",$p);
					mysqli_execute($stmt);
					$q = mysqli_stmt_get_result($stmt);
					if($q){
						if($q->num_rows>0){
							while ($r = $q->fetch_assoc()) {
								$d[] = $r;
								$d['tags'] = self::get_project_tags($r['PID']);
							}
							// Get and list All
							return json_encode($d);
						}
					}else{
						return null;
					}
				}
			}
		}
		public function project_scope_search($p){
			//Search paramaters and data
			$param = $p['paramater'];
			$data = "%".$p['data']."%";

			//get the connection
			$conn = self::Connect();

			//SQL statement
			$SQL = "SELECT * FROM `projects` WHERE ? LIKE ?";

			//Stmt
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt,$SQL)){

			}else{
				mysqli_stmt_bind_param($stmt,"ss",$param,$data);
				mysqli_execute($stmt);
				//
				$q = mysqli_stmt_get_result($stmt);

				while($r = $q->fetch_assoc()){
					$d [] = $r;
				}
				if($d != null){
					return json_decode($d);
				}

			}

		}

		//Add new project

		public function _add_project($d){
			//get connection
			$conn = self::Connect();

			//Create project ID
			$PID = strrev(uniqid(''));
			
			$name = $d['name'];
			$desc = $d['description'];
			$cost = $d['cost'];
			$dims = $d['dimensions'];
			$image = $d['image'];
			$tags_components  = $d['tags'];
			$components = $d['components'];
			
			$SQL = "INSERT INTO `projects` (`PID`, `name`, `description`, `components`, `images`, `cost`) VALUES (?, ?, ?, ?, ?, ?);";
			
			//initialize STMT
			$stmt = mysqli_stmt_init($conn);
			
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Failed";
			}else{
				mysqli_stmt_bind_param($stmt,"ssssss",$PID,$name,$desc,$components,$image,$cost);
				mysqli_execute($stmt);
				$q = mysqli_stmt_get_result($stmt);
				$t = explode('/',$tags_components);
				print_r($t);
				self::set_project_tags($PID,$t);
				return $q;
			}


		}

		///Add new tag

		public function add_tag($d){
			//get connection
			$conn = self::Connect();

			//creat tag ID
			$TID = uniqid('');
			$name = $d['name'];

			$stmt = mysqli_stmt_init($conn);
			
			$SQL = "INSERT INTO `tags` (`TID`, `tag`) VALUES (?,?);";
			
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return "Addition failed";
			}else{
				mysqli_stmt_bind_param($stmt,"ss",$TID,$name);
				mysqli_execute($stmt);
				$q = mysqli_stmt_get_result($stmt);
				return $q;
			}
		}

		public function get_tags(){
			$conn = self::Connect();
			
			$SQL = "SELECT * FROM `tags`;";
			
			$q = $conn->query($SQL);
			$Tags = [];
			if($q){
				if($q->num_rows>0){
					while ($r = $q->fetch_assoc()) {
						array_push($Tags,$r);
					}
					return json_encode($Tags);
				}
			}
		}

		// SET project Tags
		private function set_project_tags($PID,$tags){
			$conn = self::Connect();
			$stmt = mysqli_stmt_init($conn);
			$SQL = "INSERT INTO `project-tags` (`PID`,`TID`) VALUE (?,?);";
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return ":Failed";
			}else{
				foreach($tags as $tag){
					mysqli_stmt_bind_param($stmt,"ss",$PID,$tag);
					mysqli_execute($stmt);
				}
				return mysqli_stmt_get_result($stmt);
			}
		}
		// Get project TAGS
		public function get_tag_name($TID){
			$conn = self::Connect();
			$stmt = mysqli_stmt_init($conn);
			$SQL = "SELECT * FROM `tags` WHERE `TID`= ? ;";
			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return ":Failed";
			}else{
				mysqli_stmt_bind_param($stmt,"s",$TID);
				mysqli_execute($stmt);
				$q = mysqli_stmt_get_result($stmt);
				while($t = $q->fetch_assoc()){
					return $t['tag'];
				}
			}

		}
		// Get All the Tags for a specific Project
		public function get_project_tags($pid){
			$conn = self::Connect();
			$stmt = mysqli_stmt_init($conn);

			$project_tags = [];

			$SQL = "SELECT * FROM `project-tags` WHERE `PID`=? ;";
			$tags = [];

			if(!mysqli_stmt_prepare($stmt,$SQL)){
				return ":Failed";
			}else{
				mysqli_stmt_bind_param($stmt,"s",$pid);
				$q = mysqli_execute($stmt);
				$q = mysqli_stmt_get_result($stmt);
				while($t = $q->fetch_assoc()){
					array_push($tags,self::get_tag_name($t['TID']));
				}
				return $tags!=null?$tags:null;
			}
			
		}

		public function get_components(){
			$conn = self::Connect();
			$SQL = "SELECT * FROM `components`;";
			$q = $conn->query($SQL);

			if($q){
				if($q->num_rows>0){
					while ($r = $q->fetch_assoc()) {
						$d[] = $r;
					}
					return json_encode($d);
				}
			}
		}

	/////////////////////////////////
	/////////////////////////////////
	////////////////////////////////

	#Item / Component management
	# C R U D Item / Component data

	public function add_item($d){
		//get connection
		$conn = self::Connect();
		$stmt = mysqli_stmt_init($conn);

		$CID = md5(uniqid(""));

		$name = $d['name'];
		$dim = $d['dimensions'];
		$desc = $d['Description'];
		$img = $d['image'];

		$SQL = "INSERT INTO `components` (`CID`, `name`, `dimensions`, `description`, `images`) VALUES (?, ?, ?, ?, ?);";

		if(!mysqli_stmt_prepare($stmt,$SQL)){
			return ":Failed";
		}else{
			mysqli_stmt_bind_param($stmt,"sssss",$CID,$name,$dim,$desc,$img);
			mysqli_execute($stmt);
			return mysqli_stmt_get_result($stmt);
		}
	}

	public function load_items(){
		$conn = self::Connect();
		$SQL = "SELECT * FROM `components`;";
		$q = $conn->query($SQL);
		if($q->num_rows>0){
			while ($r = $q->fetch_assoc()) {
				$d [] = $r;
			}
			return $d;
		}
	}

}	

?>
