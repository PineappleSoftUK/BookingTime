<?php
/**
 * A location that houses assets that can be booked.
 *
 */

namespace System;

class Location
{
  public $db;
  public $id;
  public $name;

  public function __construct($db, $id, $name)
  {
    $this->db = $db;
    $this->id = $id;
    $this->name = $name;
  }

  /**
  * Setter for id.
  *
  */
  public function setID($id)
  {
    $this->id = $id;
  }

  /**
  * Getter for id.
  *
  */
  public function getID()
  {
    return $this->id;
  }


  /**
  * Setter for name.
  *
  */
  public function setName($name)
  {
    $this->name = $name;
  }

  /**
  * Getter for name.
  *
  */
  public function getName()
  {
    return $this->name;
  }

  /**
  * New asset
  *
  * Adds the asset provided to the database
  *
  */
  public function newAsset($name, $capacity)
  {
    $stmt = $this->db->prepare('INSERT INTO assets (name, location, capacity, status) VALUES (:name, :location, :capacity, "Live")');
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':location', $this->id);
    $stmt->bindValue(':capacity', $capacity);
    $result = $stmt->execute();
  }

  /**
  * Get all assets
  *
  * This returns an array of all asset objects linked this location.
  *
  */
  public function getAllAssets()
  {
    $assetArray = array();
    $stmt = $this->db->prepare('SELECT * FROM assets WHERE location = :location');
    $stmt->bindValue(':location', $this->id);
    $res = $stmt->execute();
    while ($row = $res->fetchArray()) {
      $object = new Asset($this->db, $row['id'], $row['name'], $row['location'], $row['capacity']);
      array_push($assetArray, $object);
    }
    return $assetArray;
  }

  /**
  * Delete asset function.
  *
  * This takes a asset object and removes it from the database.
  *
  */
  public function deleteAsset($assetToDelete)
  {
    $stmt = $this->db->prepare('DELETE FROM assets WHERE id = :id');
    $stmt->bindValue(':id', $assetToDelete->getID());
    $result = $stmt->execute();
  }

  /**
  * toString method.
  *
  */
  public function toString()
  {
    return "Location name: " . $this->name;
  }
}
