<?php
namespace GiveToken;

/*

CREATE TABLE user_group (
	id		INT(11) NOT NULL AUTO_INCREMENT,
	name	VARCHAR(200) NOT NULL,
	PRIMARY KEY (id)
);

ALTER TABLE user ADD COLUMN user_group INT(11) NULL DEFAULT NULL AFTER access_token, ADD INDEX idx_user_group_id (user_group ASC);

ALTER TABLE user ADD CONSTRAINT fk_user_group_id FOREIGN KEY (user_group) REFERENCES user_group(id) ON DELETE NO ACTION ON UPDATE NO ACTION;

ALTER TABLE user ADD COLUMN group_admin VARCHAR(1) NOT NULL DEFAULT 'N' AFTER user_group;

ALTER TABLE user_group ADD COLUMN max_users INT(11) NOT NULL DEFAULT 0 AFTER `name`;


*/
class UserGroup {
	var $id;
	var $name;
	var $max_users;

	static function all_user_groups() {
		$groups = execute_query("SELECT user_group.id, name, max_users, count(user.id) as user_count FROM user_group LEFT JOIN user ON user_group.id = user.user_group GROUP BY id, name, max_users ORDER BY upper(name)")->fetch_all(MYSQLI_ASSOC);
		return $groups;
	}

	public function __construct($id = null) {
		if ($id !== null) {
			$user_group = execute_query("SELECT * from user_group where id = $id")->fetch_object("GiveToken\UserGroup");
			foreach (get_object_vars($user_group) as $key => $value) {
				$this->$key = $value;
			}
		}
	}

	public function save() {
		if (!$this->id) {
			$sql = "INSERT into user_group (name, max_users) VALUES ('".escape_string($this->name)."', ".escape_string($this->max_users).")";
			$this->id = insert($sql);
		} else {
			$sql = "UPDATE user_group SET name = '".escape_string($this->name)."', max_users = ".escape_string($this->max_users)." WHERE id = $this->id";
			execute($sql);
		}

	}

	public function delete() {
		execute("DELETE FROM user_group WHERE id = $this->id");
		$this->id = null;
	}

}
