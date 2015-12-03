<?php
namespace GiveToken;

class City extends DatabaseEntity
{
    protected $name;
    protected $image_file;
    protected $population;
    protected $longitude;
    protected $latitude;
    protected $county;
    protected $country;
    protected $timezone;
    protected $temp_hi_spring;
    protected $temp_lo_spring;
    protected $temp_avg_spring;
    protected $temp_hi_summer;
    protected $temp_lo_summer;
    protected $temp_avg_summer;
    protected $temp_hi_fall;
    protected $temp_lo_fall;
    protected $temp_avg_fall;
    protected $temp_hi_winter;
    protected $temp_lo_winter;
    protected $temp_avg_winter;
    protected $created;

    /**
     * Overrides DatabaseEntity::__construct() to set created as read-only
     * after calling parent::__construct()
     */
    public function __construct($id = null)
    {
        parent::__construct($id);
        $this->addReadOnly('created');
    }

    /**
     * Gets all the cities sorted by name
     *
     * @return array - the cities
     */
    public static function getAll()
    {
        $cities = array();
        $results = execute_query("SELECT * FROM city ORDER BY name");
        if ($results) {
            while($object = $results->fetch_object()) {
                $cities[count($cities)] = $object;
            }
            $results->free();
            return $cities;
        }
    }

    /**
     * Gets the city id given the city name
     *
     * @param string $name - the name of the city to pull from the database
     *
     * @return int - the id of the named city
     */
    public static function getIdFromName($name)
    {
        $sql = "SELECT id FROM city WHERE name = '$name'";
        $id = execute_query($sql)->fetch_object()->id;
        return $id;
    }

    /**
     * Inserts or updates a city in the database
     *
     * @return boolean - success of update or insert
     */
    public function save()
    {
        if (!$this->id) {
            return $this->insert();
        } else {
            return $this->update();
        }
    }

    /**
     * Inserts a city into the database if all required fields are set
     *
     * @return boolean - success of insert
     */
    protected function insert()
    {
      $success = true;

      // check for required columns
      foreach (get_object_vars($this) as $key => $value) {
          if (!in_array($key, $this->readOnly)) {
              $success = $success && isset($value);
          }
      }
      if ($success) {
          parent::insert();
          if ($success = $success && ((int) $this->id > 0)) {
              $sql = "SELECT created
                      FROM {$this->tableName()}
                      WHERE id = $this->id";
              $this->created = execute_query($sql)->fetch_object()->created;
          }
      }

      // return results
      return $success;
    }

    /**
     * Updates a city in the database
     *
     * @return boolean - success of update
     */
    protected function update()
    {
        $success = false;
        return $success;
    }
}
