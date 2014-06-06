<?php
	function execute_query($sql) {
		include 'database.php';
		if ($result = $mysqli->query($sql)) {
			return $result;
		} else {
			throw new Exception($mysqli->error);
		}
	}

	function execute($sql) {
		include 'database.php';
		debug_output($sql);
		if (!$mysqli->query($sql)) {
			throw new Exception($mysqli->error);
		}
		if (!$mysqli->query("commit")) {
			throw new Exception($mysqli->error);
		}
	}

	function update($sql) {
		include 'database.php';
		debug_output($sql);
		if (!$mysqli->query($sql)) {
			error_log("util.php:".__METHOD__.":".$mysqli->error);
			throw new Exception($mysqli->error);
		}
		return $mysqli->affected_rows;
	}
	
	function logged_in() {
		$logged_in = FALSE;
		if (isset($_COOKIE['user_id'])) {
			$logged_in = TRUE;;
		}
		return $logged_in;
	}

	function debug() {
		$debug = FALSE;
		if (isset($_SESSION['debug'])) {
			if ($_SESSION['debug'] == 'ON') {
				$debug = TRUE;
			}
		}
		return $debug;
	}
	
	function debug_output($text) {
		if (debug()) {
			echo "<pre>";
			foreach(debug_backtrace() as $value) {
				echo "\t";
			}
			echo $text."</pre>\n";
		}
	}
	
?>