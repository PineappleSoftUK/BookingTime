<?php
/**
 * Validate user
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

// required to decode jwt
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/BeforeValidException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/ExpiredException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/JWT.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/Key.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Get header Authorization
 * https://stackoverflow.com/questions/40582161/how-to-properly-use-bearer-tokens
 *
 */
function getAuthorizationHeader(){
    $headers = null;
    if (isset($_SERVER['Authorization'])) {
        $headers = trim($_SERVER["Authorization"]);
    }
    else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
        $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
    } elseif (function_exists('apache_request_headers')) {
        $requestHeaders = apache_request_headers();
        // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
        $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
        //print_r($requestHeaders);
        if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
        }
    }
    return $headers;
}

/**
 * get access token from header
 * https://stackoverflow.com/questions/40582161/how-to-properly-use-bearer-tokens
 *
 */
function getBearerToken() {
    $headers = getAuthorizationHeader();
    // HEADER: Get the access token from the header
    if (!empty($headers)) {
        if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
            return $matches[1];
        }
    }
    return null;
}

// get jwt
$jwt = getBearerToken();

// if jwt is not empty
if($jwt){

  // decode the JWT (check user is authorised)
  try {
    // decode jwt
    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
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
    exit();
  }

}

// show error message if jwt is empty
else{

  // set response code
  http_response_code(401);

  // tell the user access denied
  echo json_encode(array("message" => "Access denied."));
  exit();
}

?>
