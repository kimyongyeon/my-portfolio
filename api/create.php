<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../config/database.php';
include_once '../domain/profile.php';
 
$database = new Database();
$db = $database->getConnection();
 
$profile = new Profile($db);
 
// get posted data
$data = json_decode(file_get_contents("php://input"));
 
// make sure data is not empty
if(
    !empty($data->name) &&
    !empty($data->price) &&
    !empty($data->description) 
){
 
    // set profile property values
    $profile->name = $data->name;
    $profile->price = $data->price;
    $profile->description = $data->description;
    $profile->created = date('Y-m-d H:i:s');
 
    // create the profile
    if($profile->create()){
 
        // set response code - 201 created
        http_response_code(201);
 
        // tell the user
        echo json_encode(array("message" => "profile was created."));
    }
 
    // if unable to create the profile, tell the user
    else{
 
        // set response code - 503 service unavailable
        http_response_code(503);
 
        // tell the user
        echo json_encode(array("message" => "Unable to create profile."));
    }
}
 
// tell the user data is incomplete
else{
 
    // set response code - 400 bad request
    http_response_code(400);
 
    // tell the user
    echo json_encode(array("message" => "Unable to create profile. Data is incomplete."));
}
?>