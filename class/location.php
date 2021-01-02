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
  * Add asset.
  *
  * ##### For future use #####
  *
  */
  /*
  public function addAsset($asset)
  {
    $stmt = $this->db->prepare('INSERT INTO assets (name, location, capacity) VALUES (:name, :location, :capacity)');
    $stmt->bindValue(':name', $asset->getName());
    $stmt->bindValue(':location', $asset->getLocation());
    $stmt->bindValue(':capacity', $asset->getCapacity());
    $result = $stmt->execute();
  }
  */

  /**
  * toString method.
  *
  */
  public function toString()
  {
    return "Location name: " . $this->name;
  }
}
