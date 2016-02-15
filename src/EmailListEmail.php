<?php
namespace Sizzle;

/**
 * This class is for database interaction with emails in lists.
 */
class EmailListEmail
{
    protected $id;
    protected $email_list_id;
    protected $email;
    protected $created;

    /**
     * This function constructs the class
     *
     * @param int $id - optional id of the email
     */
    public function __construct($id = null)
    {
        if ($id !== null && (int) $id == $id) {
            $token = execute_query(
                "SELECT * FROM email_list_email
                WHERE id = '$id'
                AND deleted IS NULL"
            )->fetch_object("Sizzle\EmailListEmail");
            if (is_object($token)) {
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
     * This function creates an entry in the email_list_email table
     *
     * @param int    $email_list_id - id of the email_list
     * @param string $email         - the email to add to the list
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($email_list_id, $email)
    {
        $query = "INSERT INTO email_list_email (email_list_id, email)
                  VALUES ('$email_list_id', '$email')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->email_list_id = $email_list_id;
            $this->email = $email;
        }
        return $id;
    }

    /**
     * This function marks an entry deleted in the email_list_email table
     *
     * @return boolean - success of deletion
     */
    public function delete()
    {
        $success = false;
        if (isset($this->id)) {
            $sql = "UPDATE email_list_email SET deleted = NOW() WHERE id = {$this->id}";
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
