<?php
namespace Sizzle;

/**
 * This class is for database interaction with email_open.
 */
class EmailOpen
{
    protected $id;
    protected $email_template_id;
    protected $email_address;
    protected $recruiting_token_id;
    protected $created;

    /**
     * This function constructs the class
     *
     * @param mixed  $value - optional id or name of the email list
     * @param string $key   - if $value is id or name
     */
    public function __construct($value = null, $key = 'id')
    {
        if ($value !== null) {
            if ($key == 'id' && (int) $value == $value) {
                $token = execute_query(
                    "SELECT * FROM email_open
                    WHERE id = '$value'"
                )->fetch_object("Sizzle\EmailOpen");
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
     * This function creates an entry in the email_open table
     *
     * @param int    $template - id of the email template
     * @param string $email    - email recipient that opened the email
     * @param int    $token    - (optional) recruiting token id
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($template, $email, $token = null)
    {
        $query = isset($token) ?
                "INSERT INTO email_open (email_template_id, email_address, recruiting_token_id)
                 VALUES ('$template', '$email', '$token')"
                :
                "INSERT INTO email_open (email_template_id, email_address)
                 VALUES ('$template', '$email')";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->email_template_id = $template;
            $this->email_address = $email;
            $this->recruiting_token_id = $token;
        }
        return $id;
    }

}
