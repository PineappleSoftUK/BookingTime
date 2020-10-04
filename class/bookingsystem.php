<?php
/**
 * The booking system itself.
 *
 */

namespace System;

class BookingSystem
{
  public $db;
  public $locations;

  public function __construct($db)
  {
    $this->db = $db;
  }

  /**
  * Add location function.
  *
  * This takes a location object and adds it to the database.
  *
  */
  public function addLocation($location)
  {
    $locationName = $location->getName();

    $stmt = $this->db->prepare('INSERT INTO locations (name) VALUES (:name)');
    $stmt->bindValue(':name', $locationName);
    $result = $stmt->execute();
  }

  /**
  * Get all locations
  *
  * This returns all locations as an array.
  *
  */
  public function getAllLocations()
  {
    $locationArray = array();
    $res = $this->db->query('SELECT * FROM locations');
    while ($row = $res->fetchArray())
    {
      $object = new Location($row['name']);
      array_push($locationArray, $object);
    }
    return $locationArray;
  }
}
