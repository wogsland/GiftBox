<?php
include_once 'util.php';

class User {
	private $id;
	public $email_address;
	public $first_name;
	public $last_name;
	public $password = null;
	public $activation_key = null;
	public $admin = "N";
	public $level = 1;
	public $stripe_id;
	public $active_until;
	public $facebook_email;
	public $access_token;
	
	static function exists ($email_address) {
		$exists = FALSE;
		$user = User::fetch($email_address);
		if ($user) {
			$exists = TRUE;
		}
		return $exists;
	}
	
	static function fetch($email_address) {
		$user = null;
		$result = execute_query("SELECT * FROM user WHERE upper(email_address) = '".strtoupper($email_address)."'");
		if ($result->num_rows > 0) {
			$user = $result->fetch_object("User");
		}
		return $user;
	}
	
	public function __construct($id = null) {
		if ($id !== null) {
			$user = execute_query("SELECT * from user WHERE id = $id")->fetch_object("User");
			foreach (get_object_vars($user) as $key => $value) {
				$this->$key = $value;
			}
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function save() {
		if (!$this->id) {
			$sql = "INSERT into user (email_address, first_name, last_name, password, activation_key, admin, level) "
				."VALUES ("
				."'".escape_string($this->email_address)."'"
				.", '".escape_string($this->first_name)."'"
				.", '".escape_string($this->last_name)."'"
				.", ".($this->password ? "'".$this->password."'" : "null")
				.", ".($this->activation_key ? "'".$this->activation_key."'" : "null")
				.", '$this->admin'"
				.", $this->level)";
			$this->id = insert($sql);
		} else {
			$sql = "UPDATE user SET email_address = '".escape_string($this->email_address)."', "
				. "first_name = '".escape_string($this->first_name)."', "
				. "last_name = '".escape_string($this->last_name)."', "
				. "password = ".($this->password ? "'".$this->password."'" : "null").", "
				. "activation_key = ".($this->activation_key ? "'".$this->activation_key."'" : "null").", "
				. "admin = '$this->admin', "
				. "level = $this->level, "
				. "stripe_id = ".($this->stripe_id ? "'".$this->stripe_id."'" : "null").", "
				. "active_until =  ".($this->active_until ? "'".$this->active_until."'" : "null")." "
				. "WHERE id = $this->id";
			execute($sql);
		}
	}
	
}
