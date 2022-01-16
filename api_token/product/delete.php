<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include_once '../config/database.php';
include_once '../objects/facility.php';

//get database connection
$database = new database();
$db = $database->getConnection();

$facility = new facility($db);

$data = json_decode(file_get_contents("php://input"));
$keys = array_keys(json_decode(file_get_contents("php://input"),true));

$delcheck=false;
$facility->token = $data->Token;

if(in_array("FacName",$keys) && in_array("TagName",$keys)==null){
    $delcheck = true;
    $facility->cs = 1;

    $facility->FacName = $data->FacName;
   
}
else if(in_array("FacName",$keys) && in_array("TagName",$keys)){
    $delcheck = true;
    $facility->cs = 2;

    $facility->TagName = $data->TagName;
    $facility->FacName = $data->FacName;
}
else 
    {
        http_response_code(204);
        echo json_encode(array("message" => "INVALID INPUT"));
    }

if($delcheck){
    if($facility->delete()){
        http_response_code(201);
        echo json_encode(array("message" => "Successfully Deleted!."));
    }else{
        http_response_code(503);
        echo json_encode(array("message"=> "Not deleted, Either token is wrong or invalid input!"));
    }
}else{
    http_response_code(503);
    echo json_encode(array("message"=> "Cannot delete due to invalid inputs"));
}


?>