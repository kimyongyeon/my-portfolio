<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
 
// include database and object files
include_once '../config/database.php';
include_once '../domain/profile.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare profile object
$profile = new profile($db);
 
// set ID property of record to read
$profile->id = isset($_GET['id']) ? $_GET['id'] : die();
 
// read the details of profile to be edited
$profile->readOne();
 
if($profile->name!=null){
    // create array
    $profile_arr = array(
        "id" =>  $profile->id,
        "name" => $profile->name,
        "description" => $profile->description,
    );
 
    // set response code - 200 OK
    http_response_code(200);
 
    // make it json format
    echo json_encode($profile_arr);
}
 
else{
    // set response code - 404 Not found
    http_response_code(404);
 
    // tell the user profile does not exist
    echo json_encode(array("message" => "profile does not exist."));
}
?>