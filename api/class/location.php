<?php
/**
 * Location
 *
 * A location that houses assets that can be booked.
 *
 * @author  PineappleSoft
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

class Location{

  // database connection and table name
  private $conn;
  private $table_name = "locations";

  // object properties
  public $id;
  public $name;
  public $status;
  public $created;
  public $modified;

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
    SELECT id, name, status, created
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
    INSERT INTO $this->table_name (name, status, created)
    VALUES (:name, :status, :created)
    SQL;

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize inputs
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->created=htmlspecialchars(strip_tags($this->created));

    // bind values
    $stmt->bindValue(":name", $this->name);
    $stmt->bindValue(":status", $this->status);
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
    SELECT id, name, status, created, modified
    FROM $this->table_name
    WHERE id = :locationID
    LIMIT 0,1
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);
    $stmt->bindValue(':locationID', $this->id);

    $result = $stmt->execute();

    // get retrieved row
    $row = $result->fetchArray(SQLITE3_ASSOC);

    // check if records are returned
    if(!empty($row)){

      // set values to object properties
      $this->name = $row['name'];
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
      status = :status,
      modified = :modified
    WHERE id = :id
    SQL;

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->status=htmlspecialchars(strip_tags($this->status));
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->modified=htmlspecialchars(strip_tags($this->modified));

    // bind new values
    $stmt->bindValue(':name', $this->name);
    $stmt->bindValue(':status', $this->status);
    $stmt->bindValue(':id', $this->id);
    $stmt->bindValue(':modified', $this->modified);

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
    UPDATE $this->table_name
    SET
      status = :status,
      modified = :modified
    WHERE id = :id
    SQL;

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));
    $this->modified=htmlspecialchars(strip_tags($this->modified));

    // bind id of record to delete
    $stmt->bindValue(':status', "Deleted");
    $stmt->bindValue(':id', $this->id);
    $stmt->bindValue(':modified', $this->modified);

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
