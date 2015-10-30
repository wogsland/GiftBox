<?php
namespace GiveToken;

class ButtonLog {
	var $id;
	var $giftbox_id;
	var $press_time;
	var $button;
	var $email;

	static function getTokenButtonLog($giftbox_id) {
		$button_log = null;
		$result = execute_query("SELECT * FROM button_log WHERE giftbox_id = '$giftbox_id' ORDER BY press_time");
		if ($result->num_rows > 0) {
			$button_log = $result->fetch_all(MYSQLI_ASSOC);
		}
		return $button_log;
	}

	public function __construct($id = null) {
		if ($id !== null) {
			$button_logger = execute_query("SELECT * from button_log where id = '$id'")->fetch_object("ButtonLogger");//should this be GiveToken\ButtonLog?
			foreach (get_object_vars($button_logger) as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	public function save() {
		if (!$this->id) {
			$sql = "INSERT into button_log (giftbox_id, button, email) VALUES ('$this->giftbox_id', '$this->button', '$this->email')";
			$this->id = insert($sql);
		} else {
			$sql = "UPDATE button_log SET giftbox_id = '$this->giftbox_id', button = '$this->button', email = '$this->email' WHERE id = '$this->id'";
			execute($sql);
		}
	}

}
