<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Credentials: true');
header('Content-type: json/application');

require "../../config/connect.php";
require "../../models/usrlogin.php";



$method = $_SERVER['REQUEST_METHOD'];

//  $q = $_GET['q'];
//  $params = explode('/', $q);

// $api = $params[0];
 $type = $params[1];
 $id = $params[2];
// $code = $params[2];

if($method === 'POST') {
	
		login($connect, $_POST ) ;

       $data = file_get_contents('php://input'); 
       
			$data = json_encode($data, true); 
			
	

}
