<?php
/**
 * Asset
 *
 * An asset that can be booked.
 *
 * @author  PineappleSoft
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Asset{

  // database connection and table name
  private $conn;
  private $table_name = "assets";

  // object properties
  public $id;
  public $name;
  public $location;
  public $capacity;
  public $timeslots;
  public $status;
  public $created;

  // constructor, $db as database connection
  public function __construct($db){
      $this->conn = $db;
  }

  /**
   * Read
   *
   * Reads and returns all items in database
   *
   * @return array
   */
  function read(){
    // select all query
    $query = <<<SQL
    SELECT id, name, location, capacity, timeslots, status, created
    FROM $this->table_name
    ORDER BY name ASC
    SQL;

    // prepare and execute query statement
    $stmt = $this->conn->prepare($query);
    $result = $stmt->execute();

    return $result;
  }

  /**
   * Create
   *
   * Insert a new item into database
   *
   * @return boolean
   */
  function create(){
    // query to insert record
    $query = <<<SQL
    INSERT INTO $this->table_name (name, location, capacity, timeslots, status, created)
    VALUES (:name, :location, :capacity, :timeslots, :status, :created)
    SQL;

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize inputs
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->location=htmlspecialchars(strip_tags($this->location));
    $this->capacity=htmlspecialchars(strip_tags($this->capacity));
    $this->timeslots=htmlspecialchars(strip_tags($this->timeslots));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->created=htmlspecialchars(strip_tags($this->created));

    // bind values
    $stmt->bindValue(":name", $this->name);
    $stmt->bindValue(":location", $this->location);
    $stmt->bindValue(":capacity", $this->capacity);
    $stmt->bindValue(":timeslots", $this->timeslots);
    $stmt->bindValue(":status", $this->status);;
    $stmt->bindValue(":created", $this->created);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

  }

  /**
   * Read One
   *
   * Reads one item from database and returns
   *
   * @return array
   */
  function readOne(){

    // query to read single record
    $query = <<<SQL
    SELECT id, name, location, capacity, timeslots, status, created
    FROM $this->table_name
    WHERE id = :assetID
    LIMIT 0,1
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':assetID', $this->id);

    $result = $stmt->execute();

    // get retrieved row
    $row = $result->fetchArray(SQLITE3_ASSOC);

    // check if records are returned
    if(!empty($row)){

      // set values to object properties
      $this->name = $row['name'];
      $this->location = $row['location'];
      $this->capacity = $row['capacity'];
      $this->timeslots = $row['timeslots'];
      $this->status = $row['status'];
      $this->created = $row['created'];
    }
  }

  /**
   * Update
   *
   * Updates item in database
   *
   * @return boolean
   */
  function update(){

    // update query
    $query = <<<SQL
    UPDATE $this->table_name
    SET
      name = :name,
      location = :location,
      capacity = :capacity,
      timeslots = :timeslots,
      status = :status
    WHERE id = :id
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->location=htmlspecialchars(strip_tags($this->location));
    $this->capacity=htmlspecialchars(strip_tags($this->capacity));
    $this->timeslots=htmlspecialchars(strip_tags($this->timeslots));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind new values
    $stmt->bindValue(":name", $this->name);
    $stmt->bindValue(":location", $this->location);
    $stmt->bindValue(":capacity", $this->capacity);
    $stmt->bindValue(":timeslots", $this->timeslots);
    $stmt->bindValue(":status", $this->status);;
    $stmt->bindValue(":id", $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }

    return false;
  }


  /**
   * Delete
   *
   * Deletes the selected item from database
   *
   * @return boolean
   */
  function delete(){

    // delete query
    $query = <<<SQL
    DELETE FROM $this->table_name
    WHERE id = :id
    SQL;

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind id of record to delete
    $stmt->bindValue(':id', $this->id);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;
  }

  /**
   * Search
   *
   * Reads database and returns the items matching search key
   *
   * @param string $keywords The search term
   * @return array
   */
  function search($keywords){

    // select all query
    $query = <<<SQL
    SELECT id, name, status, created
    FROM $this->table_name
    WHERE name LIKE :name OR status LIKE :status
    ORDER BY name ASC
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    // bind
    $stmt->bindValue(':name', $keywords);
    $stmt->bindValue(':status', $keywords);

    //Return results
    $result = $stmt->execute();

    return $result;

  }

  /**
   * Read Paging
   *
   * Reads database and returns the items along with pagination
   *
   * @param int $from_record_num   Record to start from
   * @param int $records_per_page  Number of records to return
   * @return array
   */
  public function readPaging($from_record_num, $records_per_page){

    // select query
    $query = <<<SQL
    SELECT id, name, status, created
    FROM $this->table_name
    ORDER BY created ASC
    LIMIT :fromNumber, :quantity
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // bind variable values
    $stmt->bindValue(':fromNumber', $from_record_num);
    $stmt->bindValue(':quantity', $records_per_page);

    // execute query
    $result = $stmt->execute();

    // return values from database
    return $result;
  }

  /**
   * Count
   *
   * A helper function used as part of pagination
   *
   * @return array
   */
  public function count(){
    $query = "SELECT COUNT(*) as total_rows FROM " . $this->table_name . "";

    $stmt = $this->conn->prepare($query);
    $result = $stmt->execute();
    $row = $result->fetchArray(SQLITE3_ASSOC);

    return $row['total_rows'];
  }

}
?>
