<?php
/**
 * Search
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
//include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../class/asset.php';

$asset = new Asset($db);

// get keywords
$keywords=isset($_GET["s"]) ? $_GET["s"] : "";

// query assets
$result = $asset->search($keywords);
$numOfColumns = $result->numColumns();

// check if more than 0 record found
if($numOfColumns>0){
  // assets array
  $assets_arr=array();
  $assets_arr["records"]=array();

  // retrieve table contents
  while ($row = $result->fetchArray(SQLITE3_ASSOC)){
    // extract row (this will make $row['name'] to just $name only)
    extract($row);

    $asset_item=array(
      "id" => $id,
      "name" => $name,
      "status" => html_entity_decode($status),
    );

    array_push($assets_arr["records"], $asset_item);
  }

  // set response code - 200 OK
  http_response_code(200);

  // show assets data
  echo json_encode($assets_arr);

} else {

  // set response code - 404 Not found
  http_response_code(404);

  // tell the user no assets found
  echo json_encode(
    array("message" => "No assets found.")
  );
}
?>
