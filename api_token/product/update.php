<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT
");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  

include_once '../config/database.php';
include_once '../objects/facility.php';


$database = new database();
$db = $database->getConnection();
$upcheck = false;
$facility = new facility($db);

$data = json_decode(file_get_contents("php://input"));
$keys = array_keys(json_decode(file_get_contents("php://input"),true));
$facility->token = $data->Token;

if(in_array("FacName",$keys)&& in_array("TagName",$keys)==null){
    if(in_array("New_FacName",$keys)){
        $upcheck = true;
        $facility->cs = 1;
        
        $facility->FacName = $data->FacName;
        $facility->New_FacName = $data->New_FacName;
    }else 
    {
        http_response_code(204);
        echo json_encode(array("message" => "New_FacName not providied"));
    }
}
if(in_array("TagName",$keys)){
    
    if(in_array("New_TagName",$keys) && in_array("FacName",$keys)){
        $upcheck = true;
        $facility->cs = 2;
        $facility->FacName=$data->FacName;
        $facility->TagName = $data->TagName;
        $facility->New_TagName = $data->New_TagName;
    }else
    {
        http_response_code(204);
        echo json_encode(array("message" => "New_TagName/FacName not providied"));
    }
}
if(in_array("New_FacName",$keys)&&in_array("New_TagName",$keys)){
    if(in_array("FacName",$keys)&&in_array("TagName",$keys)){
        $upcheck=true;
        $facility->cs = 3;

        
        $facility->FacName = $data->FacName;    
        $facility->New_FacName = $data->New_FacName;
        $facility->TagName = $data->TagName;
        $facility->New_TagName = $data->New_TagName;
    }else{
        http_response_code(204);
        echo json_encode(array("message" => "New_TagName/FacName or Tag/FacName are not providied"));
    }
}
if($upcheck)
{
    if($facility->update()){
        http_response_code(201);
        echo json_encode(array("message" => "facility was updaed!."));
    }
    else{
        http_response_code(503);
        echo json_encode(array("message"=> "Not updated, Either token is wrong or invalid input!"));
    }
}else{
    http_response_code(503);
    echo json_encode(array("message"=> "Cannot update due to invalid inputs"));
}
?>