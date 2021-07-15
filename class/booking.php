<?php
/**
 * A booking is an object linked to an asset that will hold details
 * of a booker and a will contain a timeslot.
 *
 */

namespace System;

class Booking
{
  public $db;
  public $id;
  public $client;
  public $asset;
  public $status;

  public function __construct($db, $id, $asset, $status)
  {
    $this->db = $db;
    $this->id = $id;
    $this->client = 1; //Placeholder for future use
    $this->asset = $asset;
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
  * Setter for client.
  *
  */
  public function setClient($client)
  {
    $this->client = $client;
  }

  /**
  * Getter for client.
  *
  */
  public function getClient()
  {
    return $this->client;
  }


  /**
  * Setter for asset.
  *
  */
  public function setasset($asset)
  {
    $this->asset = $asset;
  }

  /**
  * Getter for asset.
  *
  */
  public function getasset()
  {
    return $this->asset;
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
  * New timeslot
  *
  * Adds a new timeslot to the database
  *
  */
  public function newTimeslot($timeslotObject)
  {
    $stmt = $this->db->prepare('INSERT INTO timeslots (bookingID, timeslotDate, timeslotTime, timeslotLength, client, status) VALUES (:bookingID, :timeslotDate, :timeslotTime, :timeslotLength, :client, "Live")');
    $stmt->bindValue(':bookingID', $this->id);
    $stmt->bindValue(':timeslotDate', $timeslotObject->getDate());
    $stmt->bindValue(':timeslotTime', $timeslotObject->getTime());
    $stmt->bindValue(':timeslotLength', $timeslotObject->getDuration());
    $stmt->bindValue(':timeslotLength', $this->getClient());
    $result = $stmt->execute();
    return $this->db->lastInsertRowID();
  }

  /**
  * toString method.
  *
  */
  public function toString()
  {
    return "Booking ID: " . $this->id .  ", Asset id: " . $this->asset;
  }
}
