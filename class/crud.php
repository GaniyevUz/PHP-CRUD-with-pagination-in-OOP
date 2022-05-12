<?php
/**
 * @author Jakhongir Ganiev (https://ganiyev.uz)
 * @license MIT
 * @date 5/12/2022 09:17 AM
 */

require_once 'db_handler.php';

class CRUD extends db_handler {
	public $message;

	//create method
	public function create($data) {
		$name 		= 	$this->escape_string($data['name']);
		$email 		= 	$this->escape_string($data['email']);
		$address	= 	$this->escape_string($data['address']);
		$phone  	=  	$this->escape_string($data['phone']);
		if (empty($name) || empty($email) || empty($address) || empty($phone)) {
			$this->message = 'some fields are not filled!';
			exit();
		}
		$sql = "INSERT INTO `$this->table` (`id`, `name`, `email`, `address`, `phone`) VALUES (NULL, '$name', '$email', '$address', '$phone')";
		try {
				$this->query($sql);
				$this->message = 'created successfully';
			} catch (Exception $e) {
				$this->message = $e->getMessage();
			}
	}

	//update method
	public function update($data) {
		$id = $this->escape_string($data['id']);
		foreach ($data as $column => $value) {
			$value = $this->escape_string($value);
			if ($column != 'id' && $column != 'submit') {
				$sql = "UPDATE $this->table SET $column = '$value' WHERE id = '$id'";
				try {
					$this->query($sql);
				} catch (Exception $e) {
					$this->message = $value.' cannot be updated to the column '. $column . ' because '. $e->getMessage();
				}
			}
		}
	}
	
	//delete method
	public function delete($id) {
		$sql = "DELETE FROM $this->table WHERE id = '$id'";
		$this->query($sql);
		$this->message = 'deleted successfully';
	}

	//update method simple you can compare both update and update_simple methods
	public function update_simple($data){
		$id = $this->escape_string($data['id']);
		$name 		= 	$this->escape_string($data['name']);
		$email 		= 	$this->escape_string($data['email']);
		$address	= 	$this->escape_string($data['address']);
		$phone  	=  	$this->escape_string($data['phone']);
		$sql = "UPDATE `$this->table` SET `name` = '$name', `email` = '$email', `address` = '$address', `phone` = '$phone' WHERE id = '$id'";
		return $this->query($sql);
	}
}
