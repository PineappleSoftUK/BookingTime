<?php
/**
 * Validate token
 *
 * @author  PineappleSoft
 */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// required headers
// required headers
//header("Access-Control-Allow-Origin: *"); //Uncomment/edit if APP and API are on different domains
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// required to decode jwt
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/BeforeValidException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/ExpiredException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/JWT.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/Key.php';
use \Firebase\JWT\JWT;
use Firebase\JWT\Key;

// get posted data
$data = json_decode(file_get_contents("php://input"));

// get jwt
$jwt=isset($data->jwt) ? $data->jwt : "";

// if jwt is not empty
if($jwt){

  // if decode succeed, show user details
  try {
    // decode jwt
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

    // set response code
    http_response_code(200);

    // show user details
    echo json_encode(array(
      "message" => "Access granted.",
      "data" => $decoded->data
    ));

  }

  // if decode fails, it means jwt is invalid
  catch (Exception $e){

    // set response code
    http_response_code(401);

    // tell the user access denied  & show error message
    echo json_encode(array(
      "message" => "Access denied.",
      "error" => $e->getMessage()
    ));
  }

}

// show error message if jwt is empty
else{

  // set response code
  http_response_code(401);

  // tell the user access denied
  echo json_encode(array("message" => "Access denied."));
}

?>
