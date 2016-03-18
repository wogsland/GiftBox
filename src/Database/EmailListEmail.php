<?php
namespace Sizzle\Database;

/**
 * This class is for database interaction with emails in lists.
 */
class EmailListEmail extends \Sizzle\DatabaseEntity
{
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
        $this->addReadOnly('created');
        if ($id !== null && (int) $id == $id) {
            $token = execute_query(
                "SELECT * FROM email_list_email
                WHERE id = '$id'
                AND deleted IS NULL"
            )->fetch_object("Sizzle\Database\EmailListEmail");
            if (is_object($token)) {
                foreach (get_object_vars($token) as $key => $value) {
                    $this->$key = $value;
                }
            }
        }
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

    /**
     * This function gets emails on a list by the list id
     *
     * @param int $list_id - id of the list
     *
     * @return array - emails associated with the list
     */
    public function getByEmailListId($list_id)
    {
        $return = array();
        $query = "SELECT `email`
                  FROM email_list_email
                  WHERE deleted IS NULL
                  AND email_list_id = '$list_id'";
        $results = execute_query($query);
        while ($row = $results->fetch_assoc()) {
            $return[] = $row['email'];
        }
        return $return;
    }
}
