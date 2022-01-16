<?php

// headers
header("Access-Control-Allow-Origin: http://localhost/rest-api-authentication-example/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../objects/user.php';


//accessing database connection
$database = new database();
$db = $database->getConnection();

//new user object
$user = new user($db);

//geting POSTed data
$data = json_decode(file_get_contents("php://input"));

//setting user properties which will be sotre in database
$user->id = $data->id;
$user->name = $data->name;
$user->password = $data->password;


//creating user
if(
    !empty($user->id) &&
    !empty($user->name) &&
    !empty($user->password) &&
    $user->create()
){

    // response code
    http_response_code(200);
 
    // if  user was created
    echo json_encode(array("message" => "User was created."));
}else{
        http_response_code(400);
 
    // if unable to create user
    echo json_encode(array("message" => "Unable to create user.Either User already exist or info is not completed!"));
}

?>