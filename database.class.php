<?php

class database 
{
	private $host;
	private $user;
	private $pass;
	private $dbName;
	
	private static $instance;
	
	private $connection;
	private $results;
	private $numRows;
	
	private function __construct() {
	}
	
	static function getInstance() {
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	function connect($host, $user, $pass, $dbName) {
		this->host = $host;
		this->user = $user;
		this->pass = $pass;
		$this->dbName = $dbName;
		$this->connection = mysqli_connect($this->host, $this->user, $this->pass, $this->dbName);
	}
	
	public function  doQuery($sql) {
		$this->results = mysqli_query($this->connection, $sql);
		$this->numRows = $this->results_num_rows;
	}
	
	public function loadOjectList() {
		$obj = "No Results";
		if ($this->results) {
			$obj = mysqli_fetch_assoc($this->results);
		}
		return $obj;
	}

}
?>