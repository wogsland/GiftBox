<?php
include_once 'util.php';
include 'Bento.class.php';
include 'Divider.class.php';

class Token {
	var $id;
	var $css_id;
	var $name;
	var $user_id;
	var $letter_text;
	var $wrapper_type;
	var $unload_count;
	var $user_agent;
	var $last_modified;
	var $bentos;
	var $dividers;
	var $columns;
	
	public function __construct($id = null) {
		if ($id !== null) {
			$token = execute_query("SELECT * from giftbox where id = $id")->fetch_object("Token");
			foreach (get_object_vars($token) as $key => $value) {
				$this->$key = $value;
			}
			$this->load_bentos();
			$this->load_dividers();
			$this->load_columns();
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
			$this->bentos[count($this->bentos)] = $bento;
		}
	}
	
	private function initDividers($array) {
		foreach ($array as $d) {
			$divider = new Divider();
			$divider->init((object)$d);
			$this->dividers[count($this->dividers)] = $divider;
		}
	}
	
	private function initColumns($array) {
		foreach ($array as $c) {
			$column = new Divider();
			$column->init((object)$c);
			$this->columns[count($this->columns)] = $column;
		}
	}
	
	private function saveBentos() {
		execute("DELETE FROM bento WHERE giftbox_id = $this->id");
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

	private function load_bentos() {
		$results = execute_query("SELECT * FROM bento WHERE giftbox_id = $this->id ORDER by css_id");
		while ($bento = $results->fetch_object("Bento")) {
			$this->bentos[$bento->css_id] = $bento;
		}
	}

	private function load_dividers() {
		$results = execute_query("SELECT * FROM divider WHERE giftbox_id = $this->id AND css_id LIKE 'divider%' ORDER BY css_id");
		while ($divider = $results->fetch_object("Divider")) {
			$this->dividers[$divider->css_id] = $divider;
		}
	}

	private function load_columns() {
		$results = execute_query("SELECT * FROM divider WHERE giftbox_id = $this->id AND css_id LIKE 'column%' ORDER BY css_id");
		while ($column = $results->fetch_object("Divider")) {
			$this->columns[$column->css_id] = $column;
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
				}
			} else {
				$this->$key = $value;
			}
		}
	}
	
	public function save() {
		if (!$this->id) {
			$sql = "INSERT into giftbox (name, css_id, user_id, letter_text, wrapper_type, unload_count, user_agent) "
				."VALUES ('$this->name', '$this->css_id', $this->user_id, '$this->letter_text', "
				."'$this->wrapper_type', $this->unload_count, '$this->user_agent')";
			$this->setId(insert($sql));
		} else {
			$sql = "UPDATE giftbox SET name = '$this->name', letter_text = '$this->letter_text', "
				. "wrapper_type = '$this->wrapper_type', unload_count = $this->unload_count, "
				. "last_modified = CURRENT_TIMESTAMP() "
				. "WHERE id = $this->id";
			execute($sql);
		}
		$this->saveBentos();
		$this->saveDividers();
		$this->saveColumns();
	}

}