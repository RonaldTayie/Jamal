<?php
require('j/config/controllers.php');
$server = new controller();
$url = $_GET;
//Prepare and load views
if(isset($_GET) & $_GET !==null){
	if(isset($_GET['url'])){
		$url = explode("/", $_GET['url']);
		$view = View($_GET['url']);
	}else{
		$view = View('index');
	}
}else{
	$view = "index";
}

//View handling
function getView($View){
	if(isset($View)){
		$View = strtolower($View);
		$views = array('views'=>"index/contact-us/projects/project-details",'file_ext'=>".php");
		$Views = explode("/",$views['views']);
		$dir = "views/";
		$ext = ".php";
		for($i = 0;$i < sizeof($Views);$i++){
			if($View == $Views[$i]){
				$SetView = $dir.$Views[$i].$ext;
				break;
			}else{
				$SetView = $dir.'404'.$ext;
			}
		}
		return $SetView;
	}
}
//View controls and rendering
function View($View){
	$Home_Views = ['index','home','index'];
	if(in_array(strtolower($View), $Home_Views)){
		return getView('index');
	}else{
		return getView($View);
	}
}
?>