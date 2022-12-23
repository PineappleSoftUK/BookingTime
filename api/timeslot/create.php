<?php
/**
 * Create
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

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
  !empty($data->bookingID) &&
  !empty($data->status)
){

  // set timeslot property values
  $timeslot->bookingID = $data->bookingID;
  $timeslot->timeslotDate = $data->timeslotDate;
  $timeslot->timeslotTime = $data->timeslotTime;
  $timeslot->timeslotLength = $data->timeslotLength;
  $timeslot->status = $data->status;
  $timeslot->created = date('Y-m-d H:i:s');

  // create the timeslot
  if($timeslot->create()){

    // set response code - 201 created
    http_response_code(201);

    // tell the user
    echo json_encode(array("message" => "Timeslot was created."));

  } else {

    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message" => "Unable to create timeslot."));
    }

} else {

  // set response code - 400 bad request
  http_response_code(400);

  // tell the user
  echo json_encode(array("message" => "Unable to create timeslot. Data is incomplete."));
}
?>
