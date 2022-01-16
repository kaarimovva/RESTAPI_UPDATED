<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new database();
$db = $database->getConnection();


$user = new user($db);

$pwd=isset($_GET['password'])? $_GET['password'] : "";
$ident=isset($_GET['id'])? $_GET['id'] : "";

//checking
$user->id=$ident;
$id_exists=$user->id_exists();


//jwt files which generate Token

include_once '../config/core.php';
include_once '../libs/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;


//creating token

if($id_exists &&
 password_verify($pwd,$user->password)){

    $token=array("iat" => $issued_at,
    "exp" => $expiration_time,
    "iss" => $issuer,
    "data"=>array(
        "id"=>$user->id,
        "name"=>$user->name)
);

http_response_code(200);

$jwt=JWT::encode($token,$key,"HS256");
echo json_encode(
    array("message"=>"CONGRATS ;), you did it!","jwt"=>base64_encode($jwt)));

}else{
    http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed.Sorry :("));

}

?>