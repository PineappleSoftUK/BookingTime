<?php
/*
* A script that checks for a valid database and opens or creates it along with the necessary tables
*/

//Check if this is being called by the software
if(!$includes) {
  echo "You cannot open this file, it is part of the system and must be called by another file";
  exit();
}

//Check for exisiting table and if needed create the set of tables
$tableCheck = $db->query("SELECT name FROM sqlite_master WHERE name='setup'");

if ($tableCheck->fetchArray() === false)
{
  //Setup table
  $db->exec('CREATE TABLE IF NOT EXISTS setup (id INTEGER PRIMARY KEY AUTOINCREMENT, type TEXT)');

  //Set chosen timeslot type:
  $stmt = $db->prepare('INSERT INTO setup (type) VALUES (:type)');
  $stmt->bindValue(':type', $type);
  $result = $stmt->execute();
}
?>
