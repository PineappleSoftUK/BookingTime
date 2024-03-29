<?php
/**
 * Update
 *
 * @author  PineappleSoft
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// required headers
//header("Access-Control-Allow-Origin: *"); //Uncomment/edit if APP and API are on different domains
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Validate user
include_once __DIR__ . '/../users/validate_user.php';

// include database and classes
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../class/asset.php';

$asset = new Asset($db);

// get id of asset to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of asset to be edited
$asset->id = $data->id;

// set asset property values
$asset->name = $data->name;
$asset->location = $data->location;
$asset->capacity = $data->capacity;
$asset->timeslotStart = $data->timeslotStart;
$asset->timeslotLength = $data->timeslotLength;
$asset->timeslots = $data->timeslots;
$asset->status = $data->status;
$asset->modified = date('Y-m-d H:i:s');

// update the asset
if($asset->update()){

  // set response code - 200 ok
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "Asset was updated."));
}

// if unable to update the asset, tell the user
else{

  // set response code - 503 service unavailable
  http_response_code(503);

  // tell the user
  echo json_encode(array("message" => "Unable to update asset."));
}
?>
