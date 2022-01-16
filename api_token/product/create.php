 <?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
  

include_once '../config/database.php';
include_once '../objects/facility.php';


$database = new database();
$db = $database->getConnection();

$facility = new facility($db);

$data = json_decode(file_get_contents("php://input"));
$keys = array_keys(json_decode(file_get_contents("php://input"),true));


if(count($keys)==4){
    $facility->FacName= $data->FacName;
    $facility->TagName= $data->TagName;
    $facility->LocCity= $data->LocCity;
    $facility->token = $data->Token;
    

    if($facility->create()){
        http_response_code(201);
        echo json_encode(array("message" => "facility was created."));
    }
    else{
        echo json_encode(array("message"=> "Not created, Either token is wrong or invalid input!"));
    }
    }
else{
    http_response_code(400); //bad response, means there is problemr
    echo json_encode(array("message" => "Complete data please!"));
}

?> 
