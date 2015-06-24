<?php
include_once 'config.php';
include_once 'util.php';

class PhotoGallery {
	public $id;
	public $bento_id;
	public $file_names = array();
	public $giftboxId;

	static function fetch($bento_id) {
		$gallery_files = null;
		$result = execute_query("SELECT * FROM gallery_photos WHERE bento_id = '".$bento_id."'");
		if ($result->num_rows > 0) {
			$gallery_files = $result->fetch_all();
		}
		return $gallery_files;
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
		$delete_existing = "DELETE FROM gallery_photos WHERE bento_id = '$this->bento_id'";
		execute($delete_existing);
		foreach ($this->file_names as $file){
			$image_file = str_replace("'", "''", $file);
			$test = explode("_", $image_file);
			if($test[1] != $this->giftboxId){
				$image_file = $this->giftboxId."_".$image_file;
			}
			$sql = "INSERT INTO gallery_photos (bento_id, file_name)"
			."VALUES ('$this->bento_id', '$image_file')";
			insert($sql); 
		}
	}
}