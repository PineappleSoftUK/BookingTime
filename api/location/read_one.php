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
include_once __DIR__ . '/../class/location.php';

$location = new Location($db);

// set ID property of record to read
$location->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of location to be edited
$location->readOne();

if($location->name!=null){
  // create array
  $location_arr = array(
      "id" =>  $location->id,
      "name" => $location->name,
      "status" => $location->status,
  );

  // set response code - 200 OK
  http_response_code(200);

  // make it json format
  echo json_encode($location_arr);

} else {

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user location does not exist
  echo json_encode(array("message" => "Location does not exist."));
}
?>
