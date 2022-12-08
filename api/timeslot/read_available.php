<?php
/**
 * Read available
 *
 * This will return a list of timeslots that are available to book
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
$queryDate = isset($_GET['id']) ? $_GET['id'] : die();

// query timeslots and return an SQLiteResult object
$result = $timeslot->read();
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

  // tell the user timeslot does not exist
  echo json_encode(array("message" => "Timeslot does not exist."));
}
?>
