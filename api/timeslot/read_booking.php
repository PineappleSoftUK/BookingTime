<?php
/**
 * Read
 *
 * @author  PineappleSoft
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// required headers
//header("Access-Control-Allow-Origin: *"); //Uncomment/edit if APP and API are on different domains
header("Content-Type: application/json; charset=UTF-8");

// include database and classes
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../class/timeslot.php';

$timeslot = new Timeslot($db);

// Get ID of booking read
$bookingID = isset($_GET['id']) ? $_GET['id'] : die();

// query timeslots and return an SQLiteResult object
$result = $timeslot->readByBooking($bookingID);
$numOfColumns = $result->numColumns();

// check if records are returned
if($numOfColumns>0){
  // timeslots array
  $timeslots_arr=array();
  $timeslots_arr["records"]=array();

  // retrieve table contents
  while ($row = $result->fetchArray(SQLITE3_ASSOC)){
    // extract row (this will make $row['name'] to just $name only)
    extract($row);

    $timeslot_item=array(
      "id" =>  $id,
      "bookingID" => $bookingID,
      "timeslotDate" => $timeslotDate,
      "timeslotTime" => $timeslotTime,
      "timeslotLength" => $timeslotLength,
      "status" => html_entity_decode($status),
      "created" => html_entity_decode($created)
    );

    array_push($timeslots_arr["records"], $timeslot_item);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show timeslots data in json format
  echo json_encode($timeslots_arr);

} else {
  // set response code - 404 Not found
  http_response_code(404);

  // tell the user no results found
  echo json_encode(
      array("message" => "No results found.")
  );
}
