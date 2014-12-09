<?php
include_once 'util.php';

class Divider {
	var $id;
	var $giftbox_id;
	var $css_id;
	var $css_width;
	var $css_height;
	var $css_top;
	var $css_left;
	
	public function init($object) {
		foreach (get_object_vars($object) as $key => $value) {
			$this->$key = $value;
		}
	}
	
	public function setGiftboxId($id) {
		$this->giftbox_id = $id;
	}
	
	public function save() {
		$sql = "INSERT INTO divider (giftbox_id, css_id, css_width, css_height, css_top, css_left) "
			."VALUES ($this->giftbox_id, '$this->css_id', '$this->css_width', '$this->css_height', "
			."'$this->css_top', '$this->css_left')";
		$this->id = insert($sql);
	}
	
	public function width_percentage() {
		$width = round(($this->css_width/1011)*100);
		echo ' style="width: '.$width.'%"';
	}
	
	public function height_percentage() {
		$height = round(($this->css_height/756)*100);
		echo ' style="height: '.$height.'%"';
	}
	
}