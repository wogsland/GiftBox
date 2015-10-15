<?php
namespace GiveToken;

use \GiveToken\Bento;
use \GiveToken\Divider;
use google\appengine\api\cloud_storage\CloudStorageTools;

class Token {
	var $id;
	var $css_id;
	var $css_width;
	var $css_height;
	var $name;
	var $thumbnail_name;
	var $image_path;
	var $user_id;
	var $letter_text;
	var $wrapper_type;
	var $unload_count;
	var $user_agent;
	var $last_modified;
	var $bentos;
	var $dividers;
	var $columns;
	var $attachments;
	var $description;
	var $animation_color;
	var $animation_style;

	public function __construct($id = null) {
		if ($id !== null) {
			$token = execute_query("SELECT * from giftbox where id = $id")->fetch_object("GiveToken\Token");
			foreach (get_object_vars($token) as $key => $value) {
				$this->$key = $value;
			}
			$this->thumbnail_name = $token->id."_thumbnail";
			$this->load_bentos();
			$this->load_dividers();
			$this->load_columns();
			$this->load_attachments();
		}
	}

	private function setId($id) {
		$this->id = $id;
		foreach ($this->bentos as $bento) {
			$bento->setGiftboxId($id);
		}
		foreach ($this->dividers as $divider) {
			$divider->setGiftboxId($id);
		}
		foreach ($this->columns as $column) {
			$column->setGiftboxId($id);
		}
	}

	private function initBentos($array) {
		foreach ($array as $b) {
			$bento = new Bento();
			$bento->init((object)$b);
			$this->bentos[$bento->css_id] = $bento;
		}
	}

	private function initDividers($array) {
		foreach ($array as $d) {
			$divider = new Divider();
			$divider->init((object)$d);
			$this->dividers[$divider->css_id] = $divider;
		}
	}

	private function initColumns($array) {
		foreach ($array as $c) {
			$column = new Divider();
			$column->init((object)$c);
			$this->columns[$column->css_id] = $column;
		}
		$this->assignParents();
	}

	private function initAttachments($array) {
		$this->attachments = array();
		foreach ($array as $a) {
			$attachment = new stdClass();
			foreach (get_object_vars((object)$a) as $key => $value) {
				$attachment->$key = $value;
			}
			array_push($this->attachments, $attachment);
		}
	}

	private function assignParents() {
		foreach ($this->columns as $column) {
			if (isset($this->columns[$column->parent_css_id])) {
				$column->parent = $this->columns[$column->parent_css_id];
			} else {
				$column->parent = $this;
			}
		}
	}

	private function saveBentos() {
		foreach ($this->bentos as $bento) {
			$bento->save();
		}
	}

	private function saveDividers() {
		execute("DELETE FROM divider WHERE giftbox_id = $this->id");
		foreach ($this->dividers as $divider) {
			$divider->save();
		}
	}

	private function saveColumns() {
		foreach ($this->columns as $column) {
			$column->save();
		}
	}

	private function saveAttachments() {
		if (isset($this->attachments)) {
			foreach ($this->attachments as $attachment) {
				//$file_name = str_replace("'", "''", $attachment->file_name);
				$download_file_name = str_replace("'", "''", $attachment->download_file_name);
				$sql = "INSERT INTO attachment (giftbox_id, file_name, download_file_name, download_mime_type) "
					."VALUES ($this->id, '$download_file_name', '$download_file_name', '$attachment->download_mime_type')";
				$attachment->id = insert($sql);
			}
		}
	}

	private function load_bentos() {
		$results = execute_query("SELECT * FROM bento WHERE giftbox_id = $this->id ORDER by css_id");
		while ($bento = $results->fetch_object("GiveToken\Bento")) {
			$this->bentos[$bento->css_id] = $bento;
		}
	}

	private function load_dividers() {
		$results = execute_query("SELECT * FROM divider WHERE giftbox_id = $this->id AND css_id LIKE 'divider%' ORDER BY css_id");
		while ($divider = $results->fetch_object("GiveToken\Divider")) {
			$this->dividers[$divider->css_id] = $divider;
		}
	}

	private function load_columns() {
		$results = execute_query("SELECT * FROM divider WHERE giftbox_id = $this->id AND css_id LIKE 'column%' ORDER BY css_id");
		while ($column = $results->fetch_object("GiveToken\Divider")) {
			$this->columns[$column->css_id] = $column;
		}
		$this->assignParents();
	}

	private function load_attachments() {
		$this->attachments = array();
		$results = execute_query("SELECT * FROM attachment WHERE giftbox_id = $this->id GROUP BY download_file_name");
		while ($a = $results->fetch_object()) {
			array_push($this->attachments, $a);
		}
	}

	public function init($object) {
		foreach (get_object_vars($object) as $key => $value) {
			if (is_array($value)) {
				if ($key === "bentos")  {
					$this->initBentos($value);
				} elseif ($key === "dividers") {
					$this->initDividers($value);
				} elseif ($key === "columns") {
					$this->initColumns($value);
				} elseif ($key === "attachments") {
					$this->initAttachments($value);
				}
			} else {
				$this->$key = $value;
			}
		}
	}

	public function save() {
		if(!$this->unload_count){
			$this->unload_count = 0;
		}
		if (!$this->id) {
			$sql = "INSERT into giftbox (name, css_id, css_width, css_height, user_id, letter_text, wrapper_type, unload_count, user_agent, description, animation_color, animation_style) "
				."VALUES ('".escape_string($this->name)."', '$this->css_id', '$this->css_width', '$this->css_height', $this->user_id, '".escape_string($this->letter_text)."', "
				."'$this->wrapper_type', $this->unload_count, '$this->user_agent', '$this->description', '$this->animation_color', '$this->animation_style')";
			$this->setId(insert($sql));
		} else {
			$sql = "UPDATE giftbox SET name = '".escape_string($this->name)."', letter_text = '".escape_string($this->letter_text)."', "
				. "wrapper_type = '$this->wrapper_type', unload_count = $this->unload_count, "
				. "last_modified = CURRENT_TIMESTAMP(), description = '$this->description', animation_color = '$this->animation_color', animation_style = '$this->animation_style' "
				. "WHERE id = $this->id";
			execute($sql);
		}
		$this->saveBentos();
		$this->saveDividers();
		$this->saveColumns();
		$this->saveAttachments();
	}

	public function render() {
		include "./templates/preview-$this->css_id.php";
	}

	public function delete() {
		$sql = "DELETE FROM giftbox WHERE id = $this->id";
		execute($sql);
	}

}
