<?php
class db {
	private $conn;
	private $host;
	private $user;
	private $password;
	private $baseName;
	private $port;
	private $Debug;
 
    function __construct($params=array()) {
		$this->conn = false;
		$this->host = 'localhost'; //hostname
		$this->user = 'root'; //username
		$this->password = ''; //password
		$this->baseName = 'rfs2'; //name of your database
		$this->port = '3306';
		$this->debug = true;
		$this->connect();
	}
 

	
	function connect() {
		if (!$this->conn) {
			try {
				$this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->baseName.'', $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));  
			}
			catch (Exception $e) {
				die('Erreur : ' . $e->getMessage());
			}
 
			if (!$this->conn) {
				$this->status_fatal = true;
				echo 'Connection BDD failed';
				die();
			} 
			else {
				$this->status_fatal = false;
			}
		}
 
		return $this->conn;
	}
 

	

	  
	
	
	
	

}