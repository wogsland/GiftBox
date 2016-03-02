<?php
namespace Sizzle;

/**
 * This class is for database interaction with organizations.
 */
class Organization
{
    protected $id;
    protected $name;
    protected $paying_user;
    protected $created;

    /**
     * This function constructs the class from the specified id.
     *
     * @param int $id - optional id of the organization
     */
    public function __construct($id = null)
    {
        if ($id !== null && 0 < (int) $id) {
            $page = execute_query(
                "SELECT * FROM organization
                WHERE id = '$id'"
            )->fetch_object();
            if (is_object($page)) {
                foreach (get_object_vars($page) as $key => $value) {
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
}
