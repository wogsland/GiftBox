<?php
namespace Sizzle;

/**
 * This class is for database interaction with email lists.
 */
class EmailList
{
    protected $id;
    protected $user_id;
    protected $name;
    protected $created;

    /**
     * This function constructs the class
     *
     * @param mixed $value - optional id or name of the email list
     * @param string $key  - if $value is id or name
     */
    public function __construct($value = null, $key = 'id')
    {
        if ($value !== null) {
            if ($key == 'id' && (int) $value == $value) {
                $token = execute_query(
                    "SELECT * FROM email_list
                    WHERE id = '$value'
                    AND deleted IS NULL"
                )->fetch_object("Sizzle\EmailList");
            } elseif ($key == 'name') {
                $token = execute_query(
                    "SELECT * FROM email_list
                    WHERE name = '$value'
                    AND deleted IS NULL"
                )->fetch_object("Sizzle\EmailList");
            }
            if (isset($token) && is_object($token)) {
                foreach (get_object_vars($token) as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
    }

    /**
     * This function gets a protected property
     *
     * @param string $var - the class property desired
     *
     * @return mixed - the class property
     */
    public function __get($var)
    {
        if (isset($this->$var)) {
            return $this->$var;
        }
    }

    /**
     * This function checks if a protected property is set
     *
     * @param string $var - the class property to check
     *
     * @return bool - if the property is set
     */
    public function __isset($var)
    {
        return isset($this->$var);
    }

    /**
     * This function creates an entry in the email_list table
     *
     * @param int    $user_id - id of the user
     * @param string $name    - list name
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($user_id, $name)
    {
        $query = "INSERT INTO email_list (user_id, name) VALUES ('$user_id', '$name')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->user_id = $user_id;
            $this->name = $name;
        }
        return $id;
    }

    /**
     * This function updates the email_list name column
     *
     * @param string $name  - list name
     *
     * @return boolean - success of update
     */
    public function update($name)
    {
        if (isset($this->id)) {
            $query = "UPDATE email_list SET name = '$name' WHERE id = {$this->id}";
            $rows = update($query);
            if ($rows > 0) {
                $this->name = $name;
                return true;
            }
        }
        return false;
    }

    /**
     * This function marks an entry deleted in the email_list table
     *
     * @return boolean - success of deletion
     */
    public function delete()
    {
        $success = false;
        if (isset($this->id)) {
            $sql = "UPDATE email_list SET deleted = NOW() WHERE id = {$this->id}";
            execute($sql);
            $vars = get_class_vars(get_class($this));
            foreach ($vars as $key=>$value) {
                unset($this->$key);
            }
            $success = true;
        }
        return $success;
    }
}
