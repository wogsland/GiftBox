<?php
namespace Sizzle;

/**
 * This class is for database interaction with organizations.
 */
class Organization
{
    protected $id;
    protected $name;
    protected $website;
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

    /**
     * This function creates an entry in the organization table
     *
     * @param string $name     - name of organization
     * @param string $website  - (optional) website of organization
     * @param int $paying_user - (optional) user id of user who we charge
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($name, $website = null, $paying_user = null)
    {
        $query = "INSERT INTO organization (
                    name
                    ".(isset($website) ? ", website":'')."
                    ".(isset($paying_user) ? ", paying_user":'')."
                  )
                  VALUES (
                    '$name'
                    ".(isset($website) ? ", '$website'":'')."
                    ".(isset($paying_user) ? ", '$paying_user'":'')."
                  )";
        $id = insert($query);
        if ($id > 0) {
            $this->id = $id;
            $this->name = $name;
            $this->website = $website;
            $this->paying_user = $paying_user;
        }
        return $id;
    }
}
