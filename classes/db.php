<?php
/*
* Mysql database class - only one connection alowed
*/
class Database {
	private $_connection;
	private static $_instance; //The single instance
	private $_host;
	private $_username;
	private $_password;//
	private $_database;

	/*
	Get an instance of the Database
	@return Instance
	*/
	public static function getInstance($DATABASE_HOST,$DATABASE_NAME,$DATABASE_LOGIN,$DATABASE_PASSWORD) {
		if(!self::$_instance) { // If no instance then make one
			self::$_instance = new self($DATABASE_HOST,$DATABASE_NAME,$DATABASE_LOGIN,$DATABASE_PASSWORD);
		}
		return self::$_instance;
	}

	// Constructor
	private function __construct($DATABASE_HOST,$DATABASE_NAME,$DATABASE_LOGIN,$DATABASE_PASSWORD) {
            $this->_database=$DATABASE_NAME;
            $this->_host=$DATABASE_HOST;
            $this->_password=$DATABASE_PASSWORD;
            $this->_username=$DATABASE_LOGIN;
		$this->_connection = new mysqli($this->_host, $this->_username, 
			$this->_password, $this->_database,'3308');//3306 3308
	
		// Error handling
        if ($mysqli->connect_errno) {
                echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        /*
		if(mysqli_connect_error()) {
			trigger_error("Failed to conencto to MySQL: " . mysqli_connect_error(),
				 E_USER_ERROR);
		}
        */
	}

	// Magic method clone is empty to prevent duplication of connection
	private function __clone() { }

	// Get mysqli connection
	public function getConnection() {
		return $this->_connection;
	}
}

$db = Database::getInstance($DATABASE_HOST,$DATABASE_NAME,$DATABASE_LOGIN,$DATABASE_PASSWORD);
$mysqli = $db->getConnection(); 
$sql_query = "SET NAMES 'utf8' ";
$result = $mysqli->query($sql_query);
