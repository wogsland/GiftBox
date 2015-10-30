<?php
namespace GiveToken;

class Social{
	private $id;
	public $user_id;
	public $network;
	public $url;

	public function __construct($id = null) {
		if ($id !== null) {
			$social = execute_query("SELECT * from social where id = $id")->fetch_object("GiveToken\Social");
			foreach (get_object_vars($social) as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	private function set_id($id){
		$this->id = $id;
	}

	public function save(){
		$hold = null;
		if(strpos($this->url, 'https://') == true){
			$this->url = substr($this->url, 8);
		}
		$social = execute_query("SELECT * from social where user_id = $this->user_id and network = '$this->network'")->fetch_object("GiveToken\Social");
		foreach(get_object_vars($social) as $key => $value){
			$hold->$key = $value;
		}
		if (!$hold->id) {
			$sql = "INSERT into social (user_id, network, url) "
				."VALUES ('$this->user_id', '$this->network', '$this->url')";
			$this->set_id(insert($sql));
		} else {
			$sql = "UPDATE social SET user_id = '$this->user_id', network = '$this->network', "
				. "url = '$this->url' "
				. "WHERE id = $hold->id";
			execute($sql);
		}
	}
}
