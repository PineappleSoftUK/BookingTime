<?php
/**
 * Update user
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

// required to encode json web token
include_once __DIR__ . '/../config/core.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/BeforeValidException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/ExpiredException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/SignatureInvalidException.php';
include_once __DIR__ . '/../libs/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;

// Validate user
include_once __DIR__ . '/validate_user.php';

// include database and classes
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../class/user.php';

$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// if decode succeed, show user details
try {

  // set user property values
  $user->firstname = $data->firstname;
  $user->lastname = $data->lastname;
  $user->email = $data->email;
  $user->password = $data->password;
  $user->id = $decoded->data->id;

  // update the user record
  if($user->update()){
    // we need to re-generate jwt because user details might be different
    $token = array(
     "iat" => $issued_at,
     "exp" => $expiration_time,
     "iss" => $issuer,
     "data" => array(
         "id" => $user->id,
         "firstname" => $user->firstname,
         "lastname" => $user->lastname,
         "email" => $user->email
     )
    );
    $jwt = JWT::encode($token, $key);

    // set response code
    http_response_code(200);

    // response in json format
    echo json_encode(
      array(
          "message" => "User was updated.",
          "jwt" => $jwt
      )
    );
  }

  // message if unable to update user
  else{
    // set response code
    http_response_code(401);

    // show error message
    echo json_encode(array("message" => "Unable to update user."));
  }
}

// if failed
catch (Exception $e){

  // set response code
  http_response_code(401);

  // show error message
  echo json_encode(array(
    "message" => "Error updating record",
    "error" => $e->getMessage()
  ));
}
?>
