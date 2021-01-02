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
  * New Location function.
  *
  * This adds a new location to the database.
  *
  */
  public function newLocation($locationName)
  {
    $stmt = $this->db->prepare('INSERT INTO locations (name) VALUES (:name)');
    $stmt->bindValue(':name', $locationName);
    $result = $stmt->execute();
  }

  /**
  * Get a location
  *
  * This returns one location based on id provided.
  *
  */
  public function getALocation($locationID)
  {
    $stmt = $this->db->prepare('SELECT * FROM locations WHERE id = :id');
    $stmt->bindValue(':id', $locationID);
    $result = $stmt->execute();

    $array = $result->fetchArray();
    $location = new Location($this->db, $array['id'], $array['name']);
    return $location;
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
    while ($row = $res->fetchArray()) {
      $object = new Location($this->db, $row['id'], $row['name']);
      array_push($locationArray, $object);
    }
    return $locationArray;
  }

  /**
  * Delete location function.
  *
  * This takes a location id and removes it from the database.
  *
  */
  public function deleteLocation($locationID)
  {
    $stmt = $this->db->prepare('DELETE FROM locations WHERE id = :id');
    $stmt->bindValue(':id', $locationID);
    $result = $stmt->execute();
  }
}
