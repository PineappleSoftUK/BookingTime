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

  function __construct($db)
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
}
