<?php

include_once 'util.php';

class Social{
	var $id;
	var $user_id;
	var $network;
	var $url;

	public function __construct($id = null) {
		if ($id !== null) {
			$social = execute_query("SELECT * from social where id = $id")->fetch_object("Token");
			foreach (get_object_vars($social) as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	private function set_id($id){
		$this->id = $id;
	}

	private function save(){
		if (!$this->id) {
			$sql = "INSERT into social (user_id, network, url) "
				."VALUES ('$this->user_id', '$this->network', '$this->url')";
			$this->setId(insert($sql));
		} else {
			$sql = "UPDATE social SET user_id = '$this->user_id', network = $this->network, "
				. "url = $this->url "
				. "WHERE id = $this->id";
			execute($sql);
		}
	}
}