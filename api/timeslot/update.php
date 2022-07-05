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
include_once __DIR__ . '/../class/timeslot.php';

$timeslot = new Timeslot($db);

// get id of timeslot to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of timeslot to be edited
$timeslot->id = $data->id;

// set timeslot property values
$timeslot->bookingID = $data->bookingID;
$timeslot->timeslotDate = $data->timeslotDate;
$timeslot->timeslotTime = $data->timeslotTime;
$timeslot->timeslotLength = $data->timeslotLength;
$timeslot->status = $data->status;

// update the timeslot
if($timeslot->update()){

  // set response code - 200 ok
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "Timeslot was updated."));
}

// if unable to update the timeslot, tell the user
else{

  // set response code - 503 service unavailable
  http_response_code(503);

  // tell the user
  echo json_encode(array("message" => "Unable to update timeslot."));
}
?>
