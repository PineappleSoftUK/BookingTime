<?php
/**
 * A location that houses assets that can be booked.
 *
 */

namespace System;

class Location
{
  public $id;
  public $name;
  public $assets;

  public function __construct($name)
  {
    $this->name = $name;
  }

  public function setName($name)
  {
    $this->name = $name;
  }

  public function getName()
  {
    return $this->name;
  }

  public function toString()
  {
    return "Location name: " . $this->name;
  }
}
