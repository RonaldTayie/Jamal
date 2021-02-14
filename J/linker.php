<?php
require(dirname(__FILE__)."/config/controllers.php");

$server = new controller();

//$_POST related functions and controls
$data = $_POST;
if(isset($_COOKIE)){
	if(isset($_COOKIE['_front'])){
		$_SESSION['sess'] = strrev($_COOKIE['_front']);
	}
}

//test space

if(isset($data) & $data !=null){

	if(isset($_SESSION) & $_SESSION !=null){

		if(!empty($_SESSION['sess'])){
			$SESS = $_SESSION['sess'];
			$User = $server->Session($SESS);
			$_SESSION['sess'] = $User[0];
		}

	}else{
		$User = "";
	}

	$type = $data['type'];

	switch ($type) {
		case 'login':
			$User = $server->login([$data['Username'],$data['pwd']]);
			
			//setting cookie
			$week = new DateTime("+1 week");
			if(isset($data['remember_me']) & $User !== null){
				setcookie('_key',strrev($User[0]['sess']),$week->getTimestamp(),"/",null,null,true);
				#setcookie('_key',strrev($User[0]['sess']),$week->getTimestamp(),"/");
			}

            if($User != null & sizeof($User)>1){
                $View = $server->View('dashboard');
				setcookie('_front',strrev($User[0]['sess']),$week->getTimestamp(),"/",null,null,false);
            }else{
            	redirect();
            }
			break;

		//Items Management
		case 'add_item':
			//upload image first
			$image = Media($type,$_FILES);
			if ($image!== null) {
				$_POST['image'] = $image;
				$addition = $server->add_item($_POST);
				print_r($addition);
			}
			break;
		///Project management
		case 'project_add':
			//upload the image
			$image = Media($type,$_FILES);

			if(isset($image)){
				$_POST['image'] = $image;
				$result = $server->_add_project($_POST);
				print_r($result);
			}
			break;
		case 'add-tag':
			$tag_add = $server->add_tag($_POST);
			print_r($tag_add);
			break;
		case 'search':
			print_r($_POST);
			break;
		default:
			# code...
			break;
	}
	unset($_POST);
}else{
	if(isset($_SESSION) & $_SESSION !=null){
		$SESS = $_SESSION['sess'];
		$User = $server->Session($SESS);
		$_SESSION['sess'] = $User[0];

	}else{
		$User = "";
	}
}
//Control and load Views and locations throught the $_GET

if(isset($_GET) & $_GET !=null){
	if(isset($_SESSION) & $_SESSION !=null){
		$url = explode("/", $_GET['url']);
		//Check for logout action
		if($url[0]=='logout'){
			session_unset($_SESSION['sess']);
			$_SESSION = null;

			//delete or destroy the cookie 
			unset($_COOKIE['_key']);
			unset($_COOKIE['_front']);

			session_destroy();

			$protocol ="HTTP";
			$HTTP_HOST = $_SERVER['HTTP_HOST'];
			$site = "Jamal/J";

			$link = $protocol."://".$HTTP_HOST."/".$site;
			$_SESSION['msg'] = "Requested Page not found. Reverted to default Page";

			header("Location: $link");
		}
		//Explode buy a ?

		//Check sizeof the explode and use the first index o call the view name and the rest of the indecies as the params

		if(sizeof($url)<2){
			if($_GET['url']=="dashboard"||$_GET['url']=="home"||$_GET['url']=='index'){
				$page = "dashboard";
			}
			else{
				$page = $_GET['url'];
			}

			//Break Request params to allow for model usage
			$_explode = explode("_", $_GET['url']);

			if(sizeof($_explode)<2){
				$View = $server->View($_explode[0]);
			}else{
				$View = $server->View($_explode[0]);
				$_SESSION['View_command'] = array('View_name'=>$_explode[0],'command'=>$_explode[1]);
			}
		}else{
			$protocol ="HTTP";
			$HTTP_HOST = $_SERVER['HTTP_HOST'];
			$site = "Jamal/J";

			$link = $protocol."://".$HTTP_HOST."/".$site;
			$_SESSION['msg'] = "Requested Page not found. Reverted to base page...";
			header("Location: $link/$url[0]");
		}

	}else{
		$View = "Failed";
	}
}else{
	if(isset($_SESSION) & $_SESSION!=null){
		$View = $server->View('index');
	}else{
		//Cookie consumption to support session
		if(isset($_COOKIE)){
			if(isset($_COOKIE['_key'])){
				#print_r("Found");
				$__key = $_COOKIE['_key'];
				$User = $server->Session(strrev($__key));
				$_SESSION['sess'] = $User[0];
				#print_r($User);
			}
		}else{
			$protocol ="HTTP";
			$HTTP_HOST = $_SERVER['HTTP_HOST'];
			$site = "Jamal/J";

			$link = $protocol."://".$HTTP_HOST."/".$site;
			$_SESSION['msg'] = "Requested Page not found. Reverted to base page...";
			header("Location: $link/$url[0]");
		}
	}
}

function Media($category,$array){
	//Steps
	/*
		1). check for upload error
		2). check if the file requires and application or not
		3). get the sub-location for upload from the system configuration file
		4). create the upload location
		5). create a unique name for the file by concatinating the originatl name with the new name.
		5). upload the file while retaining the file name to return the caller to be uploaded to the database
	*/
	if(!empty($category) & $array != null){
		$data = $array['my_file'];
		//check for upload errors
		if($data['error']==0){
			$_name = $data['name'];
			$_size = $data['size'];
			$_tmp_name = $data['tmp_name'];

			//instance of the main class
			$_main = new controller();
			$_file = $_main->file()['_file_upload'];
			$_type = _upload_location(explode("/",strtolower($data['type'])),$_file);

			//Prepare the file name
			$_new_name = _upload_name($_name,$_type);

			if($_new_name != null){
				//upload the file to the Directory produced
				if(move_uploaded_file($_tmp_name, $_new_name)){
					return $_new_name;
				}
			}
		}else{
			return "";
		}
	}else{}
}

//prepare the _sub_location

function _upload_location($_file_type,$_init_data){
	$_type = $_file_type[0];
	$_data = $_file_type[1];
	if($_file_type != null & $_init_data !==null){

		if($_type=="application"){
			$_sub_location = $_init_data['valid_file_types'][$_type][$_data];
		}else{

			$_permitted_file_ext_list = explode("/",$_init_data['valid_file_types'][$_type]);
			if(in_array($_data, $_permitted_file_ext_list)){

				$_sub_location = $_type;

			}else{
				$_sub_location = "unknown";
			}

		}

		if($_sub_location !==null||$_sub_location!=="unknown"){
			//get the master folder

			$_location = $_init_data['_location']."/".$_sub_location;

			return $_location;
		}else{
			return null;
		}

	}else{
		return null;
	}

}

//generate the upload file _name
function _upload_name($_original_file_name,$_sub_location){
	if($_original_file_name !== null & $_sub_location != null){
		//explode the file name to saperate the name from the ext

		$_name = explode(".", $_original_file_name);
		$file_ext =  $_name[sizeof($_name)-1];
		//remove the period from the name and replace with a character
		$_uniq_name = implode( "@",explode(".",uniqid($_name[0],true)));
		return $_sub_location."/".$_uniq_name.".".strtolower($file_ext);
	}else{}
}

if($User == null){
	redirect();
}

function redirect(){
	$protocol ="HTTP";
	$HTTP_HOST = $_SERVER['HTTP_HOST'];
	$site = "Jamal/J";

	$link = $protocol."://".$HTTP_HOST."/".$site;
	$_SESSION['msg'] = "Requested Page not found. Reverted to base page...";
	header("Location: $link/$url[0]");
}

?>
