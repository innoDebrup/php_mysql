<?php

/**
 * Database Class to connect to the MySQL server and insert data in to the database.
 */
class ConnectDB {
  /**
   * Stores the connected database object provided by mysqli.
   * @var mixed
   */
  private $conn;
  private $servername = 'localhost';
  private $username = 'debrup';
  private $password = '1234';
  private $database = 'UserLogin';
  /**
   * Constructor to establish connection.
   *
   * @param string $servername
   * Name of the DBMS server.
   * @param string $username
   * The DBMS username.
   * @param string $password
   * The DBMS access/login password.
   * @param string $database
   * The name of the Database to be used.
   * 
   */
  public function __construct() {
    $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->database);

    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }
  /**
   * Get connected Database object.
   *
   * @return mysqli| FALSE
   */
  public function getConn() {
    return $this->conn;
  }

  /**
   * Function to close connection.
   *
   * @return void
   */
  public function closeConnection() {
    $this->conn->close();
  }

}