<?php
/*
* A script that checks for a valid database and opens or creates it along with the necessary tables
*/

//Check if this is being called by the software
if(!$includes) {
  echo "You cannot open this file, it is part of the system and must be called by another file";
  exit();
}

//Security for includes
$includes = TRUE;

//Open or create database file
class ConstructDB extends SQLite3
{
  function __construct()
  {
    $this->open(__DIR__ . '/bookingtime.db');
  }
}

$db = new ConstructDB();

//Check for faults table and if needed create the set of tables
$tableCheck = $db->query("SELECT name FROM sqlite_master WHERE name='locations'");

if ($tableCheck->fetchArray() === false)
{
  //Locations table
  $db->exec('CREATE TABLE IF NOT EXISTS locations (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(255))');

  //Assets table
  $db->exec('CREATE TABLE IF NOT EXISTS assets (id INTEGER PRIMARY KEY AUTOINCREMENT, name VARCHAR(255), location INTEGER, capacity VARCHAR(255))');

}
?>
