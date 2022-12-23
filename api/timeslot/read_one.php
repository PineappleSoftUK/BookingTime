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
include_once __DIR__ . '/../class/timeslot.php';

$timeslot = new Timeslot($db);

// set ID property of record to read
$timeslot->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of timeslot to be edited
$timeslot->readOne();

if($timeslot->name!=null){
  // create array
  $timeslot_arr = array(
      "id" =>  $timeslot->id,
      "bookingID" => $timeslot->bookingID,
      "timeslotDate" => $timeslot->timeslotDate,
      "timeslotTime" => $timeslot->timeslotTime,
      "timeslotLength" => $timeslot->timeslotLength,
      "status" => $timeslot->status,,
      "created" => $asset->created,
      "modifed" => $asset->modified 
  );

  // set response code - 200 OK
  http_response_code(200);

  // make it json format
  echo json_encode($timeslot_arr);

} else {

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user timeslot does not exist
  echo json_encode(array("message" => "Timeslot does not exist."));
}
?>
