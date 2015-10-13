<?php
namespace GiveToken;

class BentoFiles {
	public $bento_id;
	public $file_names = array();
	public $giftboxId;

	static function fetch($bento_id) {
		$bento_files = null;
		$result = execute_query("SELECT * FROM bento_files WHERE bento_id = '".$bento_id."'");
		if ($result->num_rows > 0) {
			$bento_files = $result->fetch_all(MYSQLI_ASSOC);
		}
		return $bento_files;
	}

	public function init($object) {
		foreach (get_object_vars($object) as $key => $value) {
			$this->$key = $value;
		}
	}

	public function setBentoId($id) {
		$this->bento_id = $id;
	}

	public function setFileNames($array){
		foreach($array as $files){
			array_push($this->file_names, $files);
		}
	}

	public function save() {
		execute("DELETE FROM bento_files WHERE bento_id = '$this->bento_id'");
		foreach ($this->file_names as $file){
			$image_file = str_replace("'", "''", $file);
			$test = explode("_", $image_file);
			if($test[0] != $this->giftboxId){
				$image_file = $this->giftboxId."_".$image_file;
			}
			insert("INSERT INTO bento_files (bento_id, file_name) VALUES ('$this->bento_id', '$image_file')");
		}
	}
}
