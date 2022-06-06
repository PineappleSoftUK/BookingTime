<?php
/**
 * Read paging
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
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../shared/utilities.php';
include_once __DIR__ . '/../class/location.php';

$utilities = new Utilities();
$location = new Location($db);

// query locations
$result = $location->readPaging($from_record_num, $records_per_page);
$numOfColumns = $result->numColumns();

// check if more than 0 record found
if($numOfColumns>0){

  // locations array
  $locations_arr=array();
  $locations_arr["records"]=array();
  $locations_arr["paging"]=array();

  // retrieve our table contents
  // fetch() is faster than fetchAll()
  // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
  while ($row = $result->fetchArray(SQLITE3_ASSOC)){
    // extract row
    // this will make $row['name'] to
    // just $name only
    extract($row);

    $location_item=array(
      "id" => $id,
      "name" => $name,
      "status" => html_entity_decode($status),
      "price" => $price,
      "location_id" => $location_id,
      "location_name" => $location_name
    );

    array_push($locations_arr["records"], $location_item);
  }


  // include paging
  $total_rows=$location->count();
  $page_url="{$home_url}location/read_paging.php?";
  $paging=$utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
  $locations_arr["paging"]=$paging;

  // set response code - 200 OK
  http_response_code(200);

  // make it json format
  echo json_encode($locations_arr);
}

else{

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user locations does not exist
  echo json_encode(
      array("message" => "No locations found.")
  );
}
?>
