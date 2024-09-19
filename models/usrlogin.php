<?php


function token($length = 40, $expiry) {

    $expiry = '1729014121' ;
    // Set expiry_timestamp..
    $expiry_timestamp = time() + 1200;

    // Generate the token...
    $email = 'alif@ptyamamori.net'; 
    $string = "0123456789qwertzuioplkjhgfdsayxcvbnm";
    $string = str_shuffle($string);
    $string = substr($string, 0, 10);
    $characters = $email.$string ;
    //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $token = 30;
    $token = srand(floor(time() / $token));
    
    
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }

    /** Do a quick manipulation in the token table...
    * ...Connect to database table then execute following SQL statement..
    * mysqli_query($link, "INSERT INTO token_table (token, expiry_timestamp) VALUES($token, $expiry_timestamp)");
    */

    return array($token, $expiry ,$expiry_timestamp ,$string );

}

function oritoken(){


    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $token = srand(floor(time() / 30));
    $tokenize = $characters[rand(3, $charactersLength - 1)];
  //  $token = srand(floor(time() / $token));

    return array ($charactersLength , $tokenize );

}



list ( $token , $expiry , $expiry_timestamp , $string ) = token($length = 40, $expiry);

list ($charactersLength , $tokenize) = oritoken();
$convtime = 60 * 60 *24 ;
$selisih = ($expiry_timestamp - time()) / 1200 ;
// echo 'selamt'.time().'<br>';
// echo ''.$expiry_timestamp.'&nbsp;'.$token;
// echo 'sisa waktu'.$selisih.'['.$convtime.']'.$string;



function login($connect ,$data) {
	// Валидация данных
	//$phone = filter_var(trim($data['phone']),FILTER_SANITIZE_STRING);
	//$password = md5(filter_var(trim($data['password']), FILTER_SANITIZE_STRING));

    $email = $_POST['email'];
    $pass = md5(filter_var(trim($data['password']), FILTER_SANITIZE_STRING));
    //$pass = $_POST['password'];


	// if(mb_strlen($phone) < 1 || mb_strlen($password) < 1) {
	// 	http_response_code(422);
	// 	$res = [
	// 		'error' => [
	// 			'code' => 422,
	// 			'message' => "Validation error",
	// 			'errors' => (object)[
	// 				'error' => 'phone and password are required'
	// 			]
	// 		]
	// 	];
	// 	echo json_encode($res);
	// 	exit;
	// }

	
	$stmt = $connect->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ? ");
	$stmt->execute(["$email","$pass"]);
	$sel = $stmt->fetch(PDO::FETCH_ASSOC);
        

        
	if($stmt->rowCount() > 0) {
        
        

		http_response_code(200);
        
		$res = [
            'message' => 'Data valid',
			'data' => [
				'email' => $sel['user_email'],
                'id' => $sel['pegawai_id'],
                
                'valid_until' => number_format(($sel['expired_at']-time())/60,2).'jam'
                
                ]   
		];
		
        echo json_encode($res);
        

                    
                    
	} else {
		http_response_code(401);
		$res = [
			'error' => [
				'code' => 401,
				'message' => "Unauthorized",
				'errors' => [
					'email' => ['email or password incorrect']
				]
			]
		];
        

		echo json_encode($res);
		exit;
	}
}
