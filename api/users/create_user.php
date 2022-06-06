<?php
/**
 * Create User
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

// include database and classes
include_once __DIR__ . '/../config/database.php';
include_once __DIR__ . '/../class/user.php';

$user = new User($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set user property values
$user->firstname = $data->firstname;
$user->lastname = $data->lastname;
$user->email = $data->email;
$user->password = $data->password;

if ($user->emailExists()){
  // set response code
  http_response_code(400);

  // display message: unable to create user
  echo json_encode(array("message" => "Email address already exists, please choose another."));
  exit();
}

// create the user
if(
  !empty($user->firstname) &&
  !empty($user->email) &&
  !empty($user->password) &&
  $user->create()
){

  // set response code
  http_response_code(200);

  // display message: user was created
  echo json_encode(array("message" => "User was created."));
}

// message if unable to create user
else{

  // set response code
  http_response_code(400);

  // display message: unable to create user
  echo json_encode(array("message" => "Unable to create user."));
}
?>
