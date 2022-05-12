<?php 

/**
 * @author Jakhongir Ganiev (https://ganiyev.uz)
 * @license MIT
 * @date 5/12/2022 09:17 AM
 */


class db_handler {

	private $host = 'localhost'; 	// Change as required
	private $username = 'root'; 	// Change as required
	private $password = ''; 		// Change as required
	private $database = 'crud_oop';	// Change as required

	protected $table;
	private $connect;

	//connection method
	public function __construct(){
		$this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
	}
	public function select($table){
		$this->table = $table;
	}
	//simplier query method
	public function query($query){
		$this->query = $query;	
		return $this->connection->query($query);

			 		
	}
	//the method witch fetchs all data from database with assoc keys
	public function fetch_all($limit=10, $offset=0){
		$query = $this->query($this->query . "ORDER BY `id` DESC LIMIT $limit OFFSET $offset");
		return $query->fetch_all(MYSQLI_ASSOC);
	}

	//escape string method that clears unneccesary chars from query
    protected function escape_string($value) { 
		return $this->connection->real_escape_string($value);
    } 

}
