<?php
/**
 * Database
 *
 * This opens the database, or creates one if none exists.
 *
 * @author  PineappleSoft
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Open or create database file
class ConstructDB extends SQLite3
{
  function __construct()
  {
    try {
      $this->open(__DIR__ . '/database.db');
    }
    catch(Exception $e) {
      echo '<b>Error opening or creating the database file, perhaps permissions are incorrect, here is the error message:</b><br /><br />' . $e->getMessage();
    }
  }
}

$db = new ConstructDB();

//Check for exisiting table and if needed create the set of tables
$tableCheck = $db->query("SELECT name FROM sqlite_master WHERE name='users'");

if ($tableCheck->fetchArray() === false)
{
  include_once __DIR__ . '/create_initial_tables.php';
}
?>
