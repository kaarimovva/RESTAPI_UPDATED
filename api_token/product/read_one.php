<?php

//include '../config/headers.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/facility.php';

//get database connection
$database = new database();
$db = $database->getConnection();

$facility = new facility($db);

$facility->TagName = isset($_GET['TagName'])? $_GET['TagName'] : "";
$facility->FacName = isset($_GET['FacName'])? $_GET['FacName'] : "";
$facility->token = isset($_GET['Token'])? $_GET['Token']: "";

$data = json_decode(file_get_contents("php://input"));

$facility->readOne();


if($facility->FacName!=null && $facility->TagName!=null ) {

    // create array
    $facility_arr = array(
        "FacID" =>  $facility->FacID,
        "FacName" => $facility->FacName,
        "TagName" => $facility->TagName,
        "LocCity" => $facility->LocCity
    );
   
    http_response_code(200);
  
    // make it json format
    echo json_encode($facility_arr);
}
else{
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user product does not exist
    echo json_encode(array("message" => "Invalid input / Product does not exist."));
}

?>