<?php
/**
 * Read one
 *
 * @author  PineappleSoft
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// required headers
//header("Access-Control-Allow-Origin: *"); //Uncomment/edit if APP and API are on different domains
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and classes
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../class/asset.php';

$asset = new Asset($db);

// set ID property of record to read
$asset->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of asset to be edited
$asset->readOne();

if($asset->name!=null){
  // create array
  $asset_arr = array(
      "id" =>  $asset->id,
      "name" =>  $asset->name,
      "location" => $asset->location,
      "capacity" => $asset->capacity,
      "timeslots" => $asset->timeslots,
      "status" => $asset->status,
      "created" => $asset->created,
      "modified" => $asset->modified
  );

  // set response code - 200 OK
  http_response_code(200);

  // make it json format
  echo json_encode($asset_arr);

} else {

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user asset does not exist
  echo json_encode(array("message" => "Asset does not exist."));
}
?>
