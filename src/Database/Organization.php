<?php
namespace Sizzle\Database;

/**
 * This class is for database interaction with organizations.
 */
class Organization extends \Sizzle\DatabaseEntity
{
    protected $name;
    protected $website;
    protected $paying_user;

    /**
     * This function sets a protected property
     *
     * @param string $var - the class property to set
     * @param string $val - the value to set it to
     */
    public function __set($var, $val)
    {
        if (isset($this->id)) {
            $settable = ['name', 'website', 'paying_user'];
            if (in_array($var, $settable)) {
                $val = escape_string($val);
                $sql = "UPDATE organization SET $var = '$val' WHERE id = '{$this->id}'";
                if (1 == update($sql)) {
                    $this->$var = $val;
                }
            }
        }
    }

    /**
     * This function creates an entry in the organization table
     *
     * @param string $name        - name of organization
     * @param string $website     - (optional) website of organization
     * @param int    $paying_user - (optional) user id of user who we charge
     *
     * @return int $id - id of inserted row or 0 on fail
     */
    public function create($name, $website = null, $paying_user = null)
    {
        $this->name = $name;
        $this->website = $website;
        $this->paying_user = $paying_user;
        $this->save();
        return $this->id;
    }
}
