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
    $this->$client = 1; //Placeholder for future use
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
  * toString method.
  *
  */
  public function toString()
  {
    return "Booking ID: " . $this->id .  ", Asset id: " . $this->asset;
  }
}
