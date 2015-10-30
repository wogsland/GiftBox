<?php
namespace GiveToken;

class Divider {
	var $id;
	var $giftbox_id;
	var $css_id;
	var $css_width;
	var $css_height;
	var $css_top;
	var $css_left;
	var $parent_css_id;
	var $parent;

	public function init($object) {
		foreach (get_object_vars($object) as $key => $value) {
			$this->$key = $value;
		}
	}

	public function setParent($parent) {
		$this->parent = $parent;
	}

	public function setGiftboxId($id) {
		$this->giftbox_id = $id;
	}

	public function save() {
		$sql = "INSERT INTO divider (giftbox_id, css_id, css_width, css_height, css_top, css_left, parent_css_id) "
			."VALUES ($this->giftbox_id, '$this->css_id', '$this->css_width', '$this->css_height', "
			."'$this->css_top', '$this->css_left', '$this->parent_css_id')";
		$this->id = insert($sql);
	}

	public function width_percentage() {
		$width = round(($this->css_width/$this->parent->css_width)*100, 4);
		echo ' style="width: '.$width.'%"';
	}

	public function height_percentage() {
		$height = round(($this->css_height/$this->parent->css_height)*100, 4);
		echo ' style="height: '.$height.'%"';
	}

}
