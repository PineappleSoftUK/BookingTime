<?php
/**
 * A location that houses assets that can be booked.
 *
 */

namespace System;

/**
 * The location class.
 */
class Location
{
  public $id;
  public $name;
  public $assets;

  public function __construct($name)
  {
    $this->name = $name;
  }
}
