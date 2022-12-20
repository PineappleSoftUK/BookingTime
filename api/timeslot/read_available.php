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
include_once __DIR__ . '/../class/asset.php';
include_once __DIR__ . '/../class/timeslot.php';

//Create the objects
$timeslot = new Timeslot($db);
$asset = new Asset($db);

//Set the asset
$asset->id = isset($_GET['id']) ? $_GET['id'] : die();
$asset->readOne();

  if($asset->name!=null){

  //Get the date
  $queryDate = isset($_GET['day']) ? $_GET['day'] : die();

  //Get timeslots
  $timeslotsForAsset = $asset->timeslots;



    //Step 1 obtain the date and lookup day.
    //Step 2 look up asset and find timeslots for set date. Add to an array
    //Step 3 remove any from array that are booked.
    //Step 4 return the list.


  // set response code - 200 OK
  http_response_code(200);

  var_dump($timeslotsForAsset);


} else {

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user timeslot does not exist
  echo json_encode(array("message" => "Timeslot does not exist."));
}
?>
