<?php
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/core.php';
include_once 'libs/php-jwt-master/src/BeforeValidException.php';
include_once 'libs/php-jwt-master/src/ExpiredException.php';
include_once 'libs/php-jwt-master/src/SignatureInvalidException.php';
include_once 'libs/php-jwt-master/src/JWT.php';
require 'vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class token_validate{

//$data = json_decode(file_get_contents("php://input"));


//$jwt=isset($data->jwt) ? $data->jwt : "";

function valid($jwt){
$jwt = base64_decode($jwt);
$key="test";

if($jwt){
   try{
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    http_response_code(200);
    echo json_encode(array(
        "message" => "Access done :).",
        "data" => $decoded->data

    ));
    return true;
   }
catch(Exception $e){
    http_response_code(401);
    echo json_encode(array(
        "message" => "Access not possible :(.",
        "error" => $e->getMessage()
    ));
    return false;
}
}else{
    http_response_code(401);
    echo json_encode(array("message"=>"Acces denied :("));
return false;
}
}}

?>