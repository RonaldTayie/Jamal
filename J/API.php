<?php

include(dirname(__FILE__)."\\config\\API.php");

$server = new api();
$data = $_POST;
if($data != null){
	switch ($data['type']) {
		case 'project_add':
			#var_dump($_POST);
			var_dump($_FILES);
			break;
	}

}else{

}

if(isset($_GET)){
	
	#print(str_replace('"', '\"',$server->_load_project('all')));
	print_r($server->_load_project('all'));
}

?>