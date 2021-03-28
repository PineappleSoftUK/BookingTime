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
  public $status;

  public function __construct($db, $id, $name, $status)
  {
    $this->db = $db;
    $this->id = $id;
    $this->name = $name;
    $this->status = $status;
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
  * Setter for status.
  *
  */
  public function setStatus($status)
  {
    $this->status = $status;
  }

  /**
  * Getter for status.
  *
  */
  public function getStatus()
  {
    return $this->status;
  }

  /**
  * New asset
  *
  * Adds the asset provided to the database
  *
  */
  public function newAsset($name, $capacity, $days, $times)
  {
    $stmt = $this->db->prepare('INSERT INTO assets (name, location, capacity, timeslotLength, timeslotStart, days, times, status) VALUES (:name, :location, :capacity, :days, :times, "Live")');
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':location', $this->id);
    $stmt->bindValue(':capacity', $capacity);
    $stmt->bindValue(':timeslotLength', $timeslotLength);
    $stmt->bindValue(':timeslotStart', $timeslotStart);
    $stmt->bindValue(':days', serialize($days));
    $stmt->bindValue(':times', serialize($times));
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
      $object = new Asset($this->db, $row['id'], $row['name'], $row['location'], $row['capacity'], $row['timeslotLength'], $row['timeslotStart'], unserialize($row['days']), unserialize($row['times']), $row['status']);
      array_push($assetArray, $object);
    }
    return $assetArray;
  }

  /**
  * Get an asset
  *
  * This returns one asset based on id provided.
  *
  */
 public function getAnAsset($assetID)
 {
   $stmt = $this->db->prepare('SELECT * FROM assets WHERE id = :id');
   $stmt->bindValue(':id', $assetID);
   $result = $stmt->execute();
   $array = $result->fetchArray();
   $asset = new asset($this->db, $array['id'], $array['name'], $array['location'], $array['capacity'], $array['timeslotLength'], $array['timeslotStart'], unserialize($array['days']), unserialize($array['times']), $array['status']);
   return $asset;
 }

 /**
 * Edit asset function.
 *
 * Updated the atributes of a location.
 *
 */
 public function editAsset($asset, $updatedAssetName, $updatedCapacity, $updatedTimeslotLength, $updatedTimeslotStart, $updatedDays, $updatedTimes)
 {
   $stmt = $this->db->prepare('UPDATE assets SET name = :name, capacity = :capacity, timeslotLength = :timeslotLength, timeslotStart = :timeslotStart, days = :days, times = :times WHERE id = :id');
   $stmt->bindValue(':name', $updatedAssetName);
   $stmt->bindValue(':capacity', $updatedCapacity);
   $stmt->bindValue(':timeslotLength', $updatedTimeslotLength);
   $stmt->bindValue(':timeslotStart', $updatedTimeslotStart);
   $stmt->bindValue(':days', serialize($updatedDays));
   $stmt->bindValue(':times', serialize($updatedTimes));

   $stmt->bindValue(':id', $asset->getID());
   $result = $stmt->execute();
 }

  /**
  * Delete asset function.
  *
  * This takes a asset object and removes it from the database.
  *
  */
  public function deleteAsset($assetToDelete)
  {
    $stmt = $this->db->prepare('UPDATE assets SET status = "Deleted" WHERE id = :id');
    $stmt->bindValue(':id', $assetToDelete->getID());
    $result = $stmt->execute();
  }

  /**
  * Restore asset function.
  *
  * This takes a asset id and marks its status as Live.
  *
  */
  public function restoreAsset($assetToRestore)
  {
    $stmt = $this->db->prepare('UPDATE assets SET status = "Live" WHERE id = :id');
    $stmt->bindValue(':id', $assetToRestore->getID());
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
