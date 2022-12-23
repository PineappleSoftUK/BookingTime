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
include_once __DIR__ . '/../class/booking.php';

$booking = new Booking($db);

// set ID property of record to read
$booking->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of booking to be edited
$booking->readOne();

if($booking->id!=null){
  // create array
  $booking_arr = array(
      "id" =>  $booking->id,
      "client" => $booking->client,
      "asset" => $booking->asset,
      "status" => $booking->status,
      "created" => $booking->created,
      "modifed" => $booking->modified
  );

  // set response code - 200 OK
  http_response_code(200);

  // make it json format
  echo json_encode($booking_arr);

} else {

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user booking does not exist
  echo json_encode(array("message" => "Booking does not exist."));
}
?>
