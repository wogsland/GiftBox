<?php
namespace GiveToken;

/**
 * This class is for database interaction with email credentials.
 */
class EmailCredential
{
    protected $id;
    protected $user_id;
    protected $username;
    protected $password;
    protected $smtp_host;
    protected $smtp_port;
    protected $created;

    /**
     * This function constructs the class
     *
     * @param int $id - optional id of the email credentials
     */
    public function __construct($id = null)
    {
        if ($id !== null && (int) $id == $id) {
            $token = execute_query(
                "SELECT * FROM email_credentials
                WHERE id = '$id'
                AND deleted IS NULL"
            )->fetch_object("GiveToken\EmailCredential");
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
     */
    public function __get($var)
    {
        if (isset($this->$var)) {
          return $this->$var;
        }
    }

    /**
     * This function creates an entry in the email_credentials table
     *
     * @param int    $user_id - id of the user
     * @param string $username - credential username
     * @param string $password - credential password
     * @param string $smtp_host - the SMTP host to connect to
     * @param string $smtp_port - the SMTP port to connect to on that host
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($user_id, $username, $password, $smtp_host, $smtp_port)
    {
        $query = "INSERT INTO
            email_credentials (user_id, username, password, smtp_host, smtp_port)
            VALUES
            ('$user_id', '$username', '$password', '$smtp_host', '$smtp_port')";
        $id = insert($query);
        if ($id > 0) {
          $this->id = $id;
          $this->user_id = $user_id;
          $this->username = $username;
          $this->password = $password;
          $this->smtp_host = $smtp_host;
          $this->smtp_port = $smtp_port;
        }
        return $id;
    }

    /**
     * This function updates the email_credentials table by marking the old
     * credentials deleted and creating new ones. This is so we still have any
     * old credentials used to send emails for a robust audit trail since
     * we're sending emails with their credentials.
     *
     * @param string $username - credential username
     * @param string $password - credential password
     * @param string $smtp_host - the SMTP host to connect to
     * @param string $smtp_port - the SMTP port to connect to on that host
     *
     * @return boolean - success of update
     */
    public function update($username, $password, $smtp_host, $smtp_port)
    {
        $id = 0;
        if (isset($this->id)) {
            $user_id = $this->user_id;
            $this->delete();
            $id = $this->create($user_id, $username, $password, $smtp_host, $smtp_port);
        }
        return ($id > 0);
    }

    /**
     * This function marks an entry deleted in the email_credentials table
     *
     * @return boolean - success of deletion
     */
    public function delete()
    {
        $success = false;
        if (isset($this->id)) {
          $sql = "UPDATE email_credentials SET deleted = NOW() WHERE id = {$this->id}";
          execute($sql);
          $vars = get_class_vars(get_class($this));
          foreach ($vars as $key=>$value) {
              unset($this->$key);
          }
        }
        return $success;
    }
}
